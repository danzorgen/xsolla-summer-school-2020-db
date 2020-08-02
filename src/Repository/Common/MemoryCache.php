<?php

namespace App\Repository\Common;

class MemoryCache
{
    /**
     * @var array
     */
    private $cache = [];

    public function add($entity, $entityId): void
    {
        $className = get_class($entity);
        $this->cache[$className][$entityId] = $entity;
    }

    public function getById($className, $entityId)
    {
        return $this->cache[$className][$entityId] ?? null;
    }
}
