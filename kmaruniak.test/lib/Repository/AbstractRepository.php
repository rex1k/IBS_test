<?php

declare(strict_types=1);

namespace KMaruniak\Repository;

use Bitrix\Main\ORM\Data\DataManager;
use Exception;
use KMaruniak\Repository\Interfaces\RepositoryInterface;
use Kmaruniak\Repository\Interfaces\SelectInterface;

abstract class AbstractRepository implements RepositoryInterface, SelectInterface
{
    protected string $entityClass;

    public function __construct(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @param array $filter
     * @param int $limit
     * @param int $offset
     * @param array $order
     * @return array
     */
    public function getByFilter(array $filter, int $limit = 10, int $offset = 0, array $order = ['id' => 'desc']): array
    {
        $result = $this->entityClass::getList(
            [
                'filter' => $filter,
                'limit'  => $limit,
                'offset' => $offset,
                'select' => $this->getDefaultSelect(),
                'order'  => $order,
                'cache'  => [
                    'ttl' => 24 * 3600,
                ],
            ]
        )->fetchAll();

        return array_column($result, null, 'id');
    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        if ($id <= 0) {
            return [];
        }

        $result = $this->entityClass::getList(
            [
                'filter' => ['id' => $id],
                'select' => $this->getDefaultSelect(),
                'cache' => ['ttl' => 24 * 3600],
            ],
        )->fetchAll();

        return array_column(
            $result,
            null,
            'id'
        );
    }

    public function getByName(string $name): array
    {
        if (empty($name)) {
            return [];
        }

        $result = $this->entityClass::getList(
            [
                'filter' => ['name' => $name],
                'select' => $this->getDefaultSelect(),
                'cache' => ['ttl' => 24 * 3600],
            ],
        )->fetchAll();

        return array_column(
            $result,
            null,
            'id'
        );
    }

    public function getTotalCount(array $filter = []): int
    {
        return $this->entityClass::getCount($filter);
    }

    public function create(array $data): int
    {
        try {
            $result = $this->entityClass::add($data);

        if ($result->isSuccess()) {
            return $result->getId();
        }
        } catch (Exception $exception) {
            return 0;
        }


        return 0;
    }
}