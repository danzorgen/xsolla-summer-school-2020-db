<?php

namespace App\Repository\Common;

use Redis;

class RepositoryCacheDecorator implements RepositoryInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var \Redis
     */
    private $redis;

    public function __construct(RepositoryInterface $repository, Redis $redis)
    {
        $this->repository = $repository;
        $this->redis = $redis;
    }

    public function findOne(string $query, array $parameters): ?array
    {
        $value = $this->getFromRedis($query, $parameters);

        if ($value === null) {
            $value = $this->repository->findOne($query, $parameters);
            $this->setToRedis($query, $parameters, $value);
        }

        return $value;
    }

    public function findMany(string $query, array $parameters): array
    {
        $value = $this->getFromRedis($query, $parameters);

        if ($value === null) {
            $value = $this->repository->findMany($query, $parameters);
            $this->setToRedis($query, $parameters, $value);
        }

        return $value;
    }

    private function getFromRedis(string $query, array $parameters): ?array
    {
        $key = $this->getKey($query, $parameters);
        $value = $this->redis->get($key);

        return $value
            ? json_decode($value, true)
            : null;
    }

    private function setToRedis(string $query, array $parameters, $value): void
    {
        $key = $this->getKey($query, $parameters);
        $value = json_encode($value);

        $this->redis->set($key, $value, 60 * 60 * 24 * 7);
    }

    private function getKey(string $query, array $parameters): string
    {
        return md5($query . json_encode($parameters));
    }
}
