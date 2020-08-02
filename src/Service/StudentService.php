<?php

namespace App\Service;

use App\Model\Student;
use App\Repository\GroupRepository;
use App\Repository\StudentRepository;
use Doctrine\DBAL\DBALException;

class StudentService
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(StudentRepository $studentRepository, GroupRepository $groupRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return Student[]
     * @throws DBALException
     */
    public function getStudentsByName(string $name): array
    {
        $students = $this->studentRepository->findByName($name);

        foreach ($students as $student) {
            $groupId = $student->getGroupId();
            $group = $this->groupRepository->findById($groupId);

            $student->setGroup($group);
        }

        return $students;
    }
}
