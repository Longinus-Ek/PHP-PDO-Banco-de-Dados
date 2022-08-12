<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;


require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query("SELECT * FROM students");
$studentDataList =  $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($studentDataList as $studentData){
    $studentList[]= new Student($studentData['id'], 
        $studentData['name'], 
        new DateTimeImmutable 
        ($studentData['birth_date']));
}


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