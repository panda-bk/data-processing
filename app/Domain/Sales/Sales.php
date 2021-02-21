<?php

namespace App\Domain\Sales;

use App\Domain\Salesman\Salesman;
use Doctrine\Common\Collections\Collection;

class Sales
{
    private string $id;
    private string $saleId;
    private string $salesman;
    private Collection $items;
    private float $total;

    public function __construct(string $id, int $saleId, string $salesman, Collection $items)
    {
        $this->id = $id;
        $this->saleId = $saleId;
        $this->salesman = $salesman;
        $this->items = $items;
    }

    public function getTotal()
    {
        $this->total = 0;

        $this->items->map(function ($value) {
            $this->total += ($value->getPrice() * $value->getQuantity());
        });

        return $this->total;
    }

    public function getSalesId()
    {
        return $this->saleId;
    }

    public function getSalesman()
    {
        return $this->salesman;
    }
} 