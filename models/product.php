<?php
class Product{
    public $idproduct;
    public $name;
    public $description;
    public $price;
    public $quantity;
    public $image;
    public $idcartdetail;

    public function __construct($idproduct,$quantity)
    {
        $this->idproduct=$idproduct;
        $this->quantity=$quantity;
    }
}