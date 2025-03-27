<?php

declare(strict_types=1);

namespace KMaruniak\Helper;

use KMaruniak\Orm\LaptopTable;
use KMaruniak\Orm\ModelTable;
use KMaruniak\Orm\VendorTable;

class EntityHelper
{
    public const DEFAULT_PATTERN = '/\/(?<vendor>[a-zA-Z0-9-\s\.,]+)?\/?(?<model>[a-zA-Z0-9-\s\.,]+)?\/?/';

    public const FOLDER_PATTERN = '/\/(?<folder>[a-zA-Z0-9-]+)\/?(?<vendor>[a-zA-Z0-9-\s\.,]+)?\/?(?<model>[a-zA-Z0-9-\s\.,]+)?\/?/';

    public const DETAIL_PATTERN = '/detail\/(?<laptop>[a-zA-Z0-9-\s\.,]+)?\//';

    /**
     * @param string $uri
     * @param bool $useFolder
     * @param array $match
     * @return string
     */
    public static function getRequestedEntity(string $uri, bool $useFolder = false, array $match = []): string
    {
        if (empty($match)) {
            $match = self::getMatchesFromUri($uri, $useFolder ? self::FOLDER_PATTERN : self::DEFAULT_PATTERN);
        }

        if ($match['vendor'] === 'detail') {
            return LaptopTable::class;
        }

        if (!empty($match['model'])) {
            return LaptopTable::class;
        }

        if (!empty($match['vendor'])) {
            return ModelTable::class;
        }

        return VendorTable::class;
    }

    /**
     * @param string $requestUri
     * @param string $pattern
     * @return array
     */
    public static function getMatchesFromUri(string $requestUri, string $pattern): array
    {
        $match = [];
        preg_match($pattern, $requestUri, $match);

        return $match;
    }

    /**
     * @param string $entity
     * @return string
     */
    public static function getEntityShortName(string $entity): string
    {
        return match ($entity) {
            VendorTable::class => 'vendor',
            ModelTable::class  => 'model',
            LaptopTable::class => 'laptop',
        };
    }
}