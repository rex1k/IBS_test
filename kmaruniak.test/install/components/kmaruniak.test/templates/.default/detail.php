<?php

/**
 * @var $APPLICATION CMain
 * @var $component CBitrixComponent
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    'kmaruniak.test.detail',
    '',
    [],
    $component
);