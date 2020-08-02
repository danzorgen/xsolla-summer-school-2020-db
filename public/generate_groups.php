<?php

$groups = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$query = '
    INSERT INTO university.`group` (id, name)
    VALUES ';

foreach ($groups as $groupId) {
    $query .= sprintf("(%s, 'Group %s'), ", $groupId, $groupId);
}

$query = substr($query, 0, -2);

$pdo = new PDO('mysql:host=localhost;dbname=university', 'root', 'root');
$pdo->exec($query);
