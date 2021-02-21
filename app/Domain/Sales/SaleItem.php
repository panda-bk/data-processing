<?php


namespace App\Domain\Sales;


class SaleItem
{
    private string $id;
    private float $quantity;
    private float $price;

    public function __construct(string $id, float $quantity, float $price)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function getQuantity() : float
    {
        return $this->quantity;
    }
    
}