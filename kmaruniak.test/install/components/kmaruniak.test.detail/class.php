<?php

use Bitrix\Main\Loader;
use KMaruniak\Factory\RepositoryFactory;
use KMaruniak\Helper\EntityHelper;
use KMaruniak\Orm\LaptopTable;

class KMaruniakTestDetailComponent extends CBitrixComponent
{
    public function __construct($component = null)
    {
        parent::__construct($component);
        Loader::includeModule('kmaruniak.test');
    }

    public function onPrepareComponentParams($arParams): array
    {
        $arParams['match'] = EntityHelper::getMatchesFromUri($this->request->getRequestUri(), EntityHelper::DETAIL_PATTERN);

        return $arParams;
    }

    public function executeComponent(): void
    {
        $repository = RepositoryFactory::createRepositoryByTableClass(LaptopTable::class);
        if ($this->arParams['match']) {
            $this->arResult['element'] = $repository->getByName($this->arParams['match']['laptop']);
        }

        $this->includeComponentTemplate();
    }
}