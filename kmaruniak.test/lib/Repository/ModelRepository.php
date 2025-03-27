<?php

declare(strict_types=1);

namespace KMaruniak\Repository;

use KMaruniak\Orm\ModelTable;
use Kmaruniak\Repository\AbstractRepository;

class ModelRepository extends AbstractRepository
{
    /**
     * @param array $filter
     * @param int $limit
     * @param int $offset
     * @param array|string[] $order
     * @return array
     */
    public function getByFilter(array $filter, int $limit = 10, int $offset = 0, array $order = ['id' => 'desc']): array
    {
        return ModelTable::getList(
            [
                'filter' => $filter,
                'limit'  => $limit,
                'offset' => $offset,
                'select' => $this->getDefaultSelect(),
                'cache'  => [
                    'ttl' => 24 * 3600,
                ],
            ]
        )->fetchAll();
    }

    /**
     * @return string[]
     */
    public function getDefaultSelect(): array
    {
        return ['id', 'name', 'model_vendor_id' => 'vendor.id', 'model_vendor_name' => 'vendor.name'];
    }
}