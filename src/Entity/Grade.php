<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $grade;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'grades')]
    private $student;

    #[ORM\Column(type: 'string', length: 255)]
    private $studentName;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?float
    {
        return $this->grade;
    }

    public function setGrade(float $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getStudentName(): ?string
    {
        return $this->studentName;
    }

    public function setStudentName(string $studentName): self
    {
        $this->studentName = $studentName;

        return $this;
    }




    }

