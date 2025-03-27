<?php

declare(strict_types=1);

namespace KMaruniak\Repository;

use KMaruniak\Orm\ModelTable;
use KMaruniak\Repository\Interfaces\RepositoryInterface;

class VendorRepository extends AbstractRepository
{
    public function getDefaultSelect(): array
    {
        return ['id', 'name'];
    }
}