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
        "SEF_MODE" => [
            "laptop" => [
                "NAME" => 'laptop',
                "DEFAULT" => "detail/#laptop#",
                "VARIABLES" => [
                    "ELEMENT_ID",
                    "ELEMENT_CODE",
                    "SECTION_ID",
                    "SECTION_CODE",
                    "SECTION_CODE_PATH",
                ],
            ],
        ]
    ],
];