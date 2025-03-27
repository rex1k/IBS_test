<?php

declare(strict_types=1);

use Bitrix\Main\Loader;
use KMaruniak\Helper\EntityHelper;
use KMaruniak\Orm\LaptopTable;
use KMaruniak\Orm\ModelTable;
use KMaruniak\Orm\VendorTable;

class TestComplexComponent extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array
    {
        Loader::includeModule('kmaruniak.test');

        $arParams['useFolder'] = !empty($arParams['SEF_FOLDER']);
        $arParams['match'] = EntityHelper::getMatchesFromUri(
            $this->request->getRequestUri(),
            $arParams['useFolder'] ? EntityHelper::FOLDER_PATTERN : EntityHelper::DEFAULT_PATTERN
        );
        $arParams['template'] = $this->getComponentTemplate($arParams['match']);

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->includeComponentTemplate($this->arParams['template']);
    }

    private function getComponentTemplate(array $match): string
    {
        if ($match['vendor'] === 'detail') {
            return 'detail';
        }

        return 'list';
    }
}