<?php

declare(strict_types=1);

namespace KMaruniak\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;

class VendorTable extends Datamanager
{
    public static function getTableName(): string
    {
        return 'vendors';
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
        ];
    }
}