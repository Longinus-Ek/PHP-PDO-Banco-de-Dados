<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();
$statement = $pdo->query("SELECT * FROM students");

var_dump($studentList);









/*
while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    $student = new Student(
        $studentData['id'], 
        $studentData['name'], 
        new DateTimeImmutable($studentData['birth_date'])          //MÉTODO UTILIZADO PARA BUSCAR SOMENTE LINHAS SELECIONADAS NO BANCO
    );
    echo $student->age() . PHP_EOL;
}
exit();
*/