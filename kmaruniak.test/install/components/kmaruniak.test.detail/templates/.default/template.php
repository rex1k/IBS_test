<?php

use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Extension::load("ui.bootstrap4");

$element = !empty($arResult['element']) ? current($arResult['element']) : [];

if (empty($element)) { ?>
    <h1>Элемент не найден</h1>
<?php } else { ?>
    <h1><?= $element['name'] ?></h1>
    <p>цена <?= $element['price'] ?></p>
    <p>модель <?= $element['laptop_model_name'] ?></p>
    <p>производитель <?= $element['vendor_name'] ?></p>
    <?php if (!empty($element['options'])) { ?>
        <h4>опции</h4>
        <ul>
            <?php foreach ($element['options'] as $option) { ?>
                <li><?= $option['options_name'] ?></li>
            <?php } ?>
        </ul>
    <?php }
}