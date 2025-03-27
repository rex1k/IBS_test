<?php

declare(strict_types=1);

namespace KMaruniak\Factory;

use KMaruniak\Orm\LaptopTable;
use KMaruniak\Orm\ModelTable;
use KMaruniak\Orm\VendorTable;
use KMaruniak\Repository\AbstractRepository;
use KMaruniak\Repository\LaptopRepository;
use KMaruniak\Repository\ModelRepository;
use KMaruniak\Repository\VendorRepository;

class RepositoryFactory
{
    public static function createRepositoryByTableClass(string $class): AbstractRepository
    {
        return match ($class) {
            VendorTable::class => new VendorRepository($class),
            ModelTable::class => new ModelRepository($class),
            LaptopTable::class => new LaptopRepository($class),
        };
    }
}