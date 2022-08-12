<?php

use Alura\Pdo\Domain\Repository\StudentRepository;

function enviaEmailParaAniversariantes(StudentRepository $studentRepository)
{
    $studentList = $studentRepository->studentsBirthAt(new DateTimeImmutable());

}