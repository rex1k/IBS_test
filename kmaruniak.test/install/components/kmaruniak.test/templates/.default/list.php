<?php

/**
 * @var $APPLICATION CMain
 * @var $arResult array
 * @var $arParams array
 * @var $component CBitrixComponent
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    'kmaruniak.test.list',
    '',
    [
        'SEF_FOLDER_TEMPLATE' => $arParams['SEF_FOLDER'],
    ],
    $component
);