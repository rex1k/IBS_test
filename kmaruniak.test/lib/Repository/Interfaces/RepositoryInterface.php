<?php

declare(strict_types=1);

namespace KMaruniak\Repository\Interfaces;

interface RepositoryInterface
{
    /**
     * @param array $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getByFilter(array $filter, int $limit = 10, int $offset = 0): array;

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array;
}