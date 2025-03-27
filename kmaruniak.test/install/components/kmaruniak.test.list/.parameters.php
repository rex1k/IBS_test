<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'GROUPS' => [
        'SETTINGS' => [
            'NAME' => 'Настройки компонента',
        ],
    ],
    'PARAMETERS' => [
        'SEF_FOLDER_TEMPLATE' => [
            'PARENT' => 'SETTINGS',
            'NAME' => GetMessage('SEF_PARAMETER_NAME'),
            'TYPE' => 'string',
            'DEFAULT' => '',
        ]
    ],
];