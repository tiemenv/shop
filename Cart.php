<?php
class Cart
{
    private $cartArray;

    public function __construct()
    {
        $this->cartArray = isset($_SESSION["winkelwagen"]) ? $_SESSION["winkelwagen"] : array();
    }

    public function getCartArray()
    {
        return $this->cartArray;
    }

    public function addToCart($productnr)
    {
        if(isset($this->cartArray[$productnr]))
        {
            $this->cartArray[$productnr]++;
        }
        else
        {
            $this->cartArray[$productnr] = 1;
        }

        $_SESSION["winkelwagen"] = $this->cartArray;
    }

    public function deleteFromCart($productnr)
    {
        if(isset($this->cartArray[$productnr]))
        {
            unset($this->cartArray[$productnr]);
            $_SESSION["winkelwagen"] = $this->cartArray;
        }
    }

    public function emptyCart()
    {
        unset($_SESSION["winkelwagen"]);
        $this->cartArray = array();
    }
}