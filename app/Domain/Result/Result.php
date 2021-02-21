<?php

namespace App\Domain\Result;


use App\Domain\Customer\Customer;
use App\Domain\Sales\Sales;
use App\Domain\Salesman\Salesman;

class Result
{
    private array $salesmanList;
    private array $customerList;
    private array $saleList;
    private float $averageWage;
    private array $maxSale;
    private string $worstSeller;

    public function __construct($salesmanList = [], $customerList = [], $maxSale = [], $saleList = [])
    {
        $this->salesmanList = $salesmanList;
        $this->customerList = $customerList;
        $this->saleList = $saleList;
        $this->maxSale = $maxSale;
    }

    public function addSalesman(Salesman $salesman)
    {
        if (array_key_exists($salesman->getName(), $this->salesmanList)) {
            return $this->salesmanList[$salesman->getName()] = $this->salesmanList[$salesman->getName()] + $salesman->getSalary();
        }

        $this->salesmanList = array_merge($this->salesmanList, [$salesman->getName() => $salesman->getSalary()]);

        return $this->salesmanList;
    }

    public function addCustomer(Customer $customer)
    {
        if (in_array($customer->getName(), $this->customerList)) {
            return $this->customerList;
        }

        $this->customerList = array_merge($this->customerList, [$customer->getName()]);

        return $this->customerList;
    }

    public function setMaxSale(Sales $sales): array
    {
        if (!$this->maxSale) {
            $this->maxSale = [$sales->getSalesId(), $sales->getTotal()];
        }

        if ($this->maxSale[1] < $sales->getTotal()) {
            $this->maxSale = [$sales->getSalesId(), $sales->getTotal()];
        }

        return $this->maxSale;
    }

    public function getMaxSale(): array
    {
        return $this->maxSale;
    }

    public function getTotalCustomer(): int
    {
        return count($this->customerList);
    }

    public function getTotalSalesman(): int
    {
        return count($this->salesmanList);
    }

    public function getAverageWage(): float
    {
        $this->averageWage = array_sum($this->salesmanList) / $this->getTotalSalesman();

        return $this->averageWage;
    }

    public function getWorstSeller()
    {
        asort($this->saleList);

        $this->worstSeller = array_key_first($this->saleList);

        return $this->worstSeller;
    }

    public function addSales(Sales $sales)
    {
        if (array_key_exists($sales->getSalesman(), $this->saleList)) {
            return $this->saleList[$sales->getSalesman()] = $this->saleList[$sales->getSalesman()] + $sales->getTotal();
        }

        $this->saleList = array_merge($this->saleList, [$sales->getSalesman() => $sales->getTotal()]);

        return $this->saleList;
    }


}