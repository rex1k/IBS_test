<?php

declare(strict_types=1);

namespace KMaruniak\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Query\Join;
use KMaruniak\Orm\VendorTable;

class ModelTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'models';
    }

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
            new IntegerField(
                'vendor_id',
                [
                    'unique' => false,
                    'nullable' => false,
                ]
            ),
            new Reference(
                'vendor',
                VendorTable::class,
                Join::on('this.vendor_id', 'ref.id')
            ),
        ];
    }
}