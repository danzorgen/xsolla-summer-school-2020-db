<?php

use App\Model\ModelFactory;
use App\Repository\Common\MemoryCache;
use App\Repository\Common\Repository;
use App\Repository\Common\RepositoryCacheDecorator;
use App\Repository\GroupRepository;
use App\Repository\StudentRepository;
use App\Service\StudentService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;

require_once __DIR__ . '/../vendor/autoload.php';


// connections
$mysqlConnection = new Connection(
    [
        'host' => 'localhost',
        'dbname' => 'university',
        'user' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ],
    new Driver()
);

$redisConnection = new Redis();
$redisConnection->connect('localhost');


// services
$repository = new Repository($mysqlConnection);
$repositoryCacheDecorator = new RepositoryCacheDecorator($repository, $redisConnection);

$modelFactory = new ModelFactory();
$memoryCache = new MemoryCache();

$studentRepository = new StudentRepository($repositoryCacheDecorator, $modelFactory);
$groupRepository = new GroupRepository($repositoryCacheDecorator, $modelFactory, $memoryCache);
$studentService = new StudentService($studentRepository, $groupRepository);


// program
$timeStart = microtime(true);
$students = $studentService->getStudentsByName('Powerful');
$timeEnd = microtime(true);


// view
echo sprintf("Time: %f", round($timeEnd - $timeStart, 3));

echo '  <table>
            <tr>
                <td>Student id</td>
                <td>Student name</td>
                <td>Student age</td>
                <td>Group name</td>
            </tr>';

foreach ($students as $student) {
    echo "  <tr>
                <td>{$student->getId()}</td>
                <td>{$student->getName()}</td>
                <td>{$student->getAge()}</td>
                <td>{$student->getGroupName()}</td>
            </tr>";
}

echo '  </table>';
