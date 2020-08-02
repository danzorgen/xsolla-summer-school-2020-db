<?php

namespace App\Repository;

use App\Model\ModelFactory;
use App\Model\Student;
use App\Repository\Common\RepositoryInterface;

class StudentRepository
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    public function __construct(RepositoryInterface $repository, ModelFactory $modelFactory)
    {
        $this->repository = $repository;
        $this->modelFactory = $modelFactory;
    }

    /**
     * @return Student[]
     */
    public function findByName(string $name): array
    {
        $students = [];

        $rows = $this->repository->findMany('
            SELECT SQL_NO_CACHE
                    id AS student_id,
                    name AS student_name,
                    age AS student_age,
                    group_id AS group_id
            FROM university.student
            WHERE name LIKE ?',
            [$name . '%']
        );

        foreach ($rows as $row) {
            $students[] = $this->modelFactory->createStudentFromRow($row);
        }

        return $students;
    }
}
