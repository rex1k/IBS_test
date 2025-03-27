<?php

declare(strict_types=1);

namespace KMaruniak\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\TextField;
use KMaruniak\Orm\LaptopTable;

class OptionsTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'options';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField(
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                ],
            ),
            new TextField(
                'name',
                [
                    'nullable' => false,
                    'unique' => true,
                ]
            ),
            (new ManyToMany(
                'laptops',
                LaptopTable::class
            ))->configureTableName('option_relations'),
        ];
    }
}