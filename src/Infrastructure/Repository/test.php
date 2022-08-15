<?php

use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$pdo = new PDO ('sqlite:memory');

$repository = new PdoStudentRepository($pdo);

empty($repository->allStudents());

