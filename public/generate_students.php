<?php

use Nubs\RandomNameGenerator\All;

require_once __DIR__ . '/../vendor/autoload.php';

$namesGenerator = All::create();
$ages = [18, 19, 20, 21, 22, 23, 24, 25];
$groups = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$agesCount = count($ages);
$groupsCount = count($groups);

$query = '
    INSERT INTO university.student (name, age, group_id)
    VALUES ';

$i = 0;

while ($i < 200000) {
    $name = $namesGenerator->getName();
    $age = $ages[random_int(0, $agesCount - 1)];
    $groupId = $groups[random_int(0, $groupsCount - 1)];

    $query .= sprintf("(\"%s\", %d, %d), ", $name, $age, $groupId);
    $i++;
}

$query = substr($query, 0, -2);

$pdo = new PDO('mysql:host=localhost;dbname=university', 'root', 'root');
$pdo->exec($query);
