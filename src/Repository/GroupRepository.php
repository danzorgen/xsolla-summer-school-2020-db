<?php

namespace App\Repository;

use App\Model\Group;
use App\Model\ModelFactory;
use App\Repository\Common\MemoryCache;
use App\Repository\Common\RepositoryInterface;
use Doctrine\DBAL\DBALException;
use LogicException;

class GroupRepository
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    /**
     * @var MemoryCache
     */
    private $memoryCache;

    public function __construct(
        RepositoryInterface $repository,
        ModelFactory $modelFactory,
        MemoryCache $memoryCache
    ) {
        $this->repository = $repository;
        $this->modelFactory = $modelFactory;
        $this->memoryCache = $memoryCache;
    }

    /**
     * @throws DBALException
     */
    public function findById(int $groupId): Group
    {
        $group = $this->memoryCache->getById(Group::class, $groupId);

        if ($group !== null) {
            return $group;
        }

        $row = $this->repository->findOne('
            SELECT SQL_NO_CACHE
                    id AS group_id,
                    name AS group_name
            FROM university.group
            WHERE id = ?',
            [$groupId]
        );

        if ($row === null) {
            throw new LogicException(sprintf('Group %s not found', $groupId));
        }

        $group = $this->modelFactory->createGroupFromRow($row);
        $this->memoryCache->add($group, $groupId);

        return $group;
    }
}
