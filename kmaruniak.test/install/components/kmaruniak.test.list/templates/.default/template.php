<?php

/**
 * @var $APPLICATION CMain
 * @var $arParams array
 * @var $arResult array
 */

use Bitrix\Main\Grid\Options;
use Bitrix\Main\UI\PageNavigation;
use KMaruniak\Helper\EntityHelper;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    'bitrix:main.ui.filter',
    '',
    [
        'FILTER_ID' => EntityHelper::getEntityShortName($arParams['entity']),
        'GRID_ID' => EntityHelper::getEntityShortName($arParams['entity']),
        'ENABLE_LIVE_SEARCH' => true,
        'ENABLE_LABEL' => true,
        'FILTER' => [
            ['id' => 'id', 'name' => 'id', 'type' => 'string'],
            ['id' => 'name', 'name' => 'name', 'type' => 'string'],
        ],
    ]
);

$grid_options = new Options(EntityHelper::getEntityShortName($arParams['entity']));
$nav_params = $grid_options->GetNavParams();

$nav = new PageNavigation(EntityHelper::getEntityShortName($arParams['entity']));
$nav->allowAllRecords(false)
    ->setRecordCount($arResult['count'])
    ->setPageSize($arParams['page_size'])
    ->initFromUri();

$APPLICATION->includeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID' => EntityHelper::getEntityShortName($arParams['entity']),
        'ROWS' => $arResult['elements'],
        'COLUMNS' => $arResult['columns'],
        'NAV_OBJECT' => $nav,
        'SHOW_NAVIGATION_PANEL'     => true,
        'SHOW_PAGINATION'           => true,
        'SHOW_SELECTED_COUNTER'     => true,
        'SHOW_TOTAL_COUNTER'        => true,
        'SHOW_PAGESIZE'             => true,
        'SHOW_CHECK_ALL_CHECKBOXES' => true,
        'SHOW_GRID_SETTINGS_MENU'   => true,
        'SEF_MODE' => 'Y',
        'AJAX_MODE' => 'Y',
        'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
        'PAGE_SIZES' => [
            ['NAME' => "5", 'VALUE' => 5],
            ['NAME' => '10', 'VALUE' => 10],
            ['NAME' => '20', 'VALUE' => 20],
            ['NAME' => '50', 'VALUE' => 50],
            ['NAME' => '100', 'VALUE' => 100]
        ],
        'AJAX_OPTION_JUMP'          => 'N',
        'ALLOW_COLUMNS_SORT'        => true,
        'ALLOW_COLUMNS_RESIZE'      => true,
        'ALLOW_HORIZONTAL_SCROLL'   => true,
        'ALLOW_SORT'                => true,
        'ALLOW_PIN_HEADER'          => true,
        'AJAX_OPTION_HISTORY'       => 'N'
    ]
);