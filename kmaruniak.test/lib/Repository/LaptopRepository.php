<?php

declare(strict_types=1);

namespace KMaruniak\Repository;

use Kmaruniak\Repository\AbstractRepository;

class LaptopRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $result = parent::getById($id);

        if (empty($result)) {
            return $result;
        }

        return $this->combineLaptopsWithOptions(
            $result,
            $this->getOptions([$id])
        );
    }

    public function getByName(string $name): array
    {
        $result = parent::getByName($name);
        $options = $this->getOptions(array_keys($result));

        return $this->combineLaptopsWithOptions($result, $options);

    }

    /**
     * @param array $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getByFilter(array $filter, int $limit = 5, int $offset = 0, array $order = ['id' => 'desc']): array
    {
        $laptops = $this->entityClass::getList(
            [
                'filter' => $filter,
                'limit' => $limit,
                'select' => $this->getDefaultSelect(),
                'offset' => $offset,
                'order' => $order,
                'cache' => [
                    'ttl' => 24 * 3600,
                ],
                'count_total' => 1,
            ]
        )->fetchAll();

        if (empty($laptops)) {
            return [];
        }

        $laptops = array_column($laptops, null, 'id');

        return $this->combineLaptopsWithOptions(
            $laptops,
            $this->getOptions(array_keys($laptops))
        );
    }

    /**
     * @return string[]
     */
    public function getDefaultSelect(): array
    {
        return ['id', 'name', 'year', 'price', 'laptop_model_id' => 'model.id', 'laptop_model_name' => 'model.name', 'vendor_id' => 'model.vendor.id', 'vendor_name' => 'model.vendor.name'];
    }

    /**
     * @return string[]
     */
    private function getOptionsSelect(): array
    {
        return ['laptop_id' => 'id', 'options_' => 'options'];
    }

    private function getOptions(array $ids): array
    {
        return array_column(
            $this->entityClass::getList(
                [
                    'filter' => ['id' => $ids, '!options.id' => false],
                    'select' => $this->getOptionsSelect(),
                    'cache' => ['ttl' => 24 * 3600],
                ]
            )->fetchAll(),
            null,
            'options_id'
        );
    }

    /**
     * @param array $laptops
     * @param array $options
     * @return array
     */
    private function combineLaptopsWithOptions(array $laptops, array $options): array
    {
        foreach ($options as $option) {
            $laptops[$option['laptop_id']]['options'][$option['options_id']] = $option;
        }

        return $laptops;
    }
}