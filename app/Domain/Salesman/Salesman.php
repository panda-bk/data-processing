<?php

namespace App\Domain\Salesman;


use phpDocumentor\Reflection\Type;

class Salesman
{
    private $id;
    private $cpf;
    private $name;
    private $salary;


    public function __construct($id, $cpf, $name, $salary)
    {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->name = $name;
        $this->salary = floatval($salary);
    }

    public function getName() :string
    {
        return $this->name;
    }

    public function getSalary() : float
    {
        return $this->salary;
    }
}