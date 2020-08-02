<?php

namespace App\Repository\Common;

use App\Model\Student;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use PDO;

class Repository implements RepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function findOne(string $query, array $parameters): ?array
    {
        return $this->connection->fetchAssoc($query, $parameters);
    }

    /**
     * @return Student[]
     * @throws DBALException
     */
    public function findMany(string $query, array $parameters): array
    {
        $array = [];
        $rows = $this->connection->executeQuery($query, $parameters);

        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        return $array;
    }
}
