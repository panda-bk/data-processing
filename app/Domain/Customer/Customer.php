<?php

namespace App\Domain\Customer;


class Customer
{
    private $id;
    private $cnpj;
    private $name;
    private $businessArea;

    public function __construct($id, $cnpj, $name, $businessArea)
    {
        $this->id = $id;
        $this->cnpj = $cnpj;
        $this->name = $name;
        $this->businessArea = $businessArea;
    }

    public function getName()
    {
        return $this->name;
    }
}