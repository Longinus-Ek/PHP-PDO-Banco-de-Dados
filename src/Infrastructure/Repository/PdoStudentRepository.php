<?php 

namespace Alura\Pdo\Infrastructure\Repository;

require_once 'vendor/autoload.php';

use PDO;
use PDOStatement;
use DateTimeImmutable;
use DateTimeInterface;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;

class PdoStudentRepository implements StudentRepository
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents() : array
    {
        $sqlSearchAll = 'SELECT * FROM students;';
        $statement = $this->connection->query($sqlSearchAll); 
    
        return $this->hydrateStudentList($statement);
    }

    public function studentsBirthAt(DateTimeInterface $birthDate) : array
    {
        $sqlSearchBirthDate = 'SELECT * FROM students WHERE birth_date = ?';
        $statement = $this->connection->prepare($sqlSearchBirthDate); 
        $statement->bindValue(1, $birthDate->format('Y-d-m'));
        $statement->execute();

        return $this->hydrateStudentList($statement);
    }

    private function hydrateStudentList(PDOStatement $statement) : array
    {
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach($studentDataList as $studentData){
            $studentList[] = new Student (
                $studentData['id'], 
                $studentData['name'], 
                new DateTimeImmutable($studentData['birth_date'])
            );
        }
        return $studentList;
    }

    public function save(Student $student) : bool
    {
        if($student->id() === null){
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student) : bool    
    {
        $sqlInsert = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $statement = $this->connection->prepare($sqlInsert);
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $student->defineId($this->connection->lastInsertId());
        return $statement->execute();
    }

    private function update(Student $student) : bool
    {
        $sqlUpdate = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $statement = $this->connection->prepare($sqlUpdate);
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate());
        $statement->bindValue(':id', $student->id(PDO::PARAM_INT));

        return $statement->execute();
    }

    public function remove(Student $student) : bool
    {
        $sqlDelete = 'DELETE FROM students WHERE id = ?;';
        $preparedStatement = $this->connection->prepare($sqlDelete);
        $preparedStatement->bindValue(1, $student->id(), PDO::PARAM_INT);
        
        return $preparedStatement->execute();
         
    }
}