<?php

declare(strict_types=1);

use Bitrix\Main\Grid\Options;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Filter\Options as FilterOptions;
use KMaruniak\Factory\RepositoryFactory;
use KMaruniak\Helper\EntityHelper;
use KMaruniak\Orm\LaptopTable;
use KMaruniak\Orm\ModelTable;
use KMaruniak\Orm\VendorTable;
use KMaruniak\Repository\AbstractRepository;

class TestListComponent extends CBitrixComponent
{
    private AbstractRepository $repository;

    public function onPrepareComponentParams($arParams)
    {
        Loader::includeModule('kmaruniak.test');

        $arParams['useFolder'] = !empty($arParams['SEF_FOLDER_TEMPLATE']);
        $arParams['entity'] = EntityHelper::getRequestedEntity(urldecode($this->request->getRequestUri()), $arParams['useFolder']);
        $arParams['match'] = EntityHelper::getMatchesFromUri(
            urldecode($this->request->getRequestUri()),
            $arParams['useFolder'] ? EntityHelper::FOLDER_PATTERN : EntityHelper::DEFAULT_PATTERN
        );
        $entityShortName = EntityHelper::getEntityShortName($arParams['entity']);

        if ($this->request->getQuery($entityShortName)) {
            $arParams['page'] = (int)filter_var($this->request->getQuery($entityShortName), FILTER_SANITIZE_NUMBER_INT);
        }

        if ($this->request->getQuery('by') && $this->request->getQuery('order')) {
            $arParams['sort'] = [$this->request->getQuery('by') => $this->request->getQuery('order')];
        }

        $arParams['grid_options'] = (new Options($entityShortName))->getCurrentOptions();
        $arParams['filter_options'] = (new FilterOptions($entityShortName))->getFilter();
        $arParams['page_size'] = $arParams['grid_options']['page_size'] ?: 20;

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->repository = RepositoryFactory::createRepositoryByTableClass($this->arParams['entity']);

        $this->arResult['elements'] = $this->convertToGridData($this->getElements());
        $this->arResult['count'] = $this->repository->getTotalCount($this->getCombinedFilters());
        $this->arResult['columns'] = $this->getEntityColumns();

        $this->includeComponentTemplate();
    }

    /**
     * @return array
     */
    private function getEntityColumns(): array
    {
        $selectFields = $this->repository->getDefaultSelect();
        $columns = [];

        foreach ($selectFields as $alias => $field) {
            if (is_numeric($alias)) {
                $alias = $field;
            }

            $columns[] = [
                'id' => $alias,
                'name' => $alias,
                'sort' => $field,
                'default' => true,
            ];
        }

        return $columns;
    }

    private function convertToGridData(array $elements): array
    {
        $result = [];
        foreach ($elements as $element) {
            $result[$element['id']] = ['data' => $element, 'id' => $element['id']];

            if ($this->arParams['entity'] === LaptopTable::class) {
                $result[$element['id']]['actions'] = [
                    [
                        'text' => 'Перейти',
                        'onclick' => 'document.location.href="' . $this->arParams['SEF_FOLDER_TEMPLATE'] . '/detail/' . $element['name'] . '/"'
                    ]
                ];
            }

            if ($this->arParams['entity'] === ModelTable::class) {
                $result[$element['id']]['actions'] = [
                    [
                        'text' => 'Перейти',
                        'onclick' => 'document.location.href="' . $this->arParams['SEF_FOLDER_TEMPLATE'] . '/' . $element['model_vendor_name'] . '/' . $element['name'] . '/"',
                    ]
                ];
            }

            if ($this->arParams['entity'] === VendorTable::class) {
                $result[$element['id']]['actions'] = [
                    [
                        'text' => 'Перейти',
                        'onclick' => 'document.location.href="' . $this->arParams['SEF_FOLDER_TEMPLATE'] . '/' . $element['name'] . '/"',
                    ]
                ];
            }
        }

        return $result;
    }

    private function getDefaultFilter(): array
    {
        if (!empty($this->arParams['match']['model'])) {
            return ['model.name' => $this->arParams['match']['model']];
        }

        if (!empty($this->arParams['match']['vendor'])) {
            return ['vendor.name' => $this->arParams['match']['vendor']];
        }

        return [];
    }

    private function getCombinedFilters(): array
    {
        $filter = [];
        foreach ($this->repository->getDefaultSelect() as $field) {
            if (!empty($this->arParams['filter_options'][$field])) {
                $filter[$field] = $this->arParams['filter_options'][$field];
            }
        }
        return array_merge($this->getDefaultFilter(), $filter);
    }

    private function getElements(): array
    {
        return $this->repository->getByFilter(
            $this->getCombinedFilters(),
            $this->arParams['grid_options']['page_size'] ?: 5,
            ($this->arParams['page'] === null || $this->arParams['page'] === 0)
                ? 0
                : (abs($this->arParams['page']) - 1) * $this->arParams['page_size'],
            $this->arParams['grid_options']['last_sort_by']
                ? [$this->arParams['grid_options']['last_sort_by'] => $this->arParams['grid_options']['last_sort_order']]
                : [],
        );
    }
}