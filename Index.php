<?php
session_start();
require_once 'header.php';
require_once 'General.php';

$shop = Shop::getShopInstance();
$producttable = $shop->getAllProducts();

Execute::showShop($producttable);

$cart = new Cart();
//var_dump($cart);

$action = isset($_GET["actie"]) ? $_GET["actie"] : "";

switch ($action)
{
	case "toevoegen":
		$cart->addToCart($_GET["productnr"]);
        Execute::showCart($cart->getCartArray());
    	break;
	case "verwijderen":
		$cart->deleteFromCart($_GET["productnr"]);
        Execute::showCart($cart->getCartArray());
		break;
	case "bestellen":
		if(!isset($_POST["bevestigknop"]))
		{
            Execute::showCart($cart->getCartArray());
            Execute::showOrderForm();
		}
		else
        {
            $errortable = Helper::checkData($_POST["klantnaam"], $_POST["email"]);
            if (empty($errortable))
            {
                $shop->addCustomerWithOrder($_POST["klantnaam"], $_POST["email"], $cart->getCartArray());
                $cart->emptyCart();
                Execute::showTitle("Bedankt voor de bestelling");
        	}
			else
            {
                Execute::showCart($cart->getCartArray());
                Execute::showOrderForm();
                Execute::showErrors($errortable);
			}
		}
		break;
	case "herbeginnen":
        $cart->emptyCart();
        Execute::showCart($cart->getCartArray());
		break;
}

Shop::getShopInstance()->closeDB();

require_once 'footer.php';
