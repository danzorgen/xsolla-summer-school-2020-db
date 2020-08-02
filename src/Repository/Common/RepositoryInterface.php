<?php

namespace App\Repository\Common;

interface RepositoryInterface
{
    public function findOne(string $query, array $parameters): ?array;

    public function findMany(string $query, array $parameters): array;
}
