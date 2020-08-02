<?php

namespace App\Model;

class ModelFactory
{
    public function createStudentFromRow(array $row): Student
    {
        return new Student(
            (int)$row['student_id'],
            $row['student_name'],
            (int)$row['student_age'],
            (int)$row['group_id']
        );
    }

    public function createGroupFromRow(array $row): Group
    {
        return new Group(
            (int)$row['group_id'],
            $row['group_name']
        );
    }
}
