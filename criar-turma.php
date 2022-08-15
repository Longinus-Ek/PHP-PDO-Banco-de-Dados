<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';
//Conexão com o bando de dados;

$connection = ConnectionCreator::CreateConnection();
$studentRepository = new PdoStudentRepository($connection);

//Processo de definição da turma

//Inserir os alunos da turma

$connection->beginTransaction(); // Iniciar uma transação para o banco de dados
try{
    $aStudent = new Student(
        null,
        'Niko Bellet',
        new DateTimeImmutable('1950-08-26'),
    );
    $studentRepository->save($aStudent);


    $anotherStudent = new Student(
        null,
        'Ele elevem',
        new DateTimeImmutable('1998-05-26'),
    );
    $studentRepository->save($anotherStudent);

    $connection->commit();

} catch (PDOException $e){
    echo $e->getMessage();
    $connection->rollBack;
}
// $connection->commit(); // // Finalizar uma transação para o banco de dados

// $connection->rollBack(); // // Finalizar uma transação e desfazer as alterações