<?php

declare(strict_types=1);

namespace Kmaruniak\Repository\Interfaces;

interface SelectInterface
{
    /**
     * @return array
     */
    public function getDefaultSelect(): array;
}