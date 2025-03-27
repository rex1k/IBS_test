<?php

declare(strict_types=1);

namespace KMaruniak\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Query\Join;
use KMaruniak\Orm\ModelTable;

class LaptopTable extends DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'laptops';
    }

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            new IntegerField(
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                ]
            ),
            new TextField(
                'name',
                [
                    'nullable' => false,
                    'unique' => true,
                ]
            ),
            new DateField(
                'year',
                [
                    'nullable' => false,
                ]
            ),
            new FloatField(
                'price',
                [
                    'nullable' => false,
                    'precision' => 2,
                ]
            ),
            new IntegerField(
                'model_id',
                [
                    'nullable' => false,
                ],
            ),
            new Reference(
                'model',
                ModelTable::class,
                Join::on('this.model_id', 'ref.id')
            ),
            (new ManyToMany(
                'options',
                OptionsTable::class
            ))->configureTableName('option_relations'),
        ];
    }
}
