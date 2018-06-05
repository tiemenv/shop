<?php
class Execute
{
    public static function showTitle($title)
    {
        echo "<h1>$title</h1>";
    }

    public static function showShop($producttable)
    {
        Execute::showTitle("Shop");
        $resstring = "<table>";
        $resstring .= "<tr>";
        $resstring .= "<td><strong>Productnr</strong></td>";
        $resstring .= "<td><strong>Productnaam</strong></td>";
        $resstring .= "<td><strong>Prijs</strong></td>";
        $resstring .= "<td><strong>Toevoegen aan winkelwagen</strong></td>";
        $resstring .= "</tr>";
        foreach ($producttable as $product) {
            $resstring .= "<tr>";
            $resstring .= "<td>" . Helper::cleanData($product->productnr) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($product->productnaam) . "</td>";
            $resstring .= "<td>" . Helper::cleanData($product->prijs) . "</td>";
            $resstring .= "<td><a href=\"Index.php?actie=toevoegen&productnr=" . Helper::cleanData($product->productnr) . "\">Toevoegen aan winkelwagen</a></td>";
            $resstring .= "</tr>";
        }
        $resstring .= "</table>";
        echo $resstring;
    }

    public static function showCart($cartArray)
    {
        //toon winkelwagen met onderaan bestellen-hyperlink en herbeginnen-hyperlink
        Execute::showTitle("Cart");
        if (!empty($cartArray))
        {
            $resstring = "<table>";
            $resstring .= "<tr>";
            $resstring .= "<td><strong>Aantal</strong></td>";
            $resstring .= "<td><strong>Productnaam</strong></td>";
            $resstring .= "<td><strong>Prijs</strong></td>";
            $resstring .= "<td><strong>Totaal</strong></td>";
            $resstring .= "<td><strong>Verwijderen uit winkelwagen</strong></td>";
            $resstring .= "</tr>";

            $total = 0;
            foreach ($cartArray as $productnr => $amount)
            {
                $product = Shop::getShopInstance()->getProductByNr($productnr);
                $rowTotal = intval($amount) * intval($product->prijs);
                $total += $rowTotal;
                $resstring .= "<tr>";
                $resstring .= "<td>" . Helper::cleanData($amount) . "</td>";
                $resstring .= "<td>" . Helper::cleanData($product->productnaam) . "</td>";
                $resstring .= "<td>" . Helper::cleanData($product->prijs) . "</td>";
                $resstring .= "<td>" . $rowTotal . "</td>";
                $resstring .= "<td><a href=\"Index.php?actie=verwijderen&productnr=" . Helper::cleanData($productnr) . "\">Verwijderen uit winkelwagen</a></td>";
                $resstring .= "</tr>";
            }

            $resstring .= "<tr>";
            $resstring .= "<td><strong>Totaal</strong></td>";
            $resstring .= "<td></td>";
            $resstring .= "<td></td>";
            $resstring .= "<td><strong>" . $total . "</strong></td>";
            $resstring .= "<td></td>";
            $resstring .= "</tr>";

            $resstring .= "<tr>";
            $resstring .= "<td><a href=\"Index.php?actie=bestellen\">Bestellen</a></td>";
            $resstring .= "<td><a href=\"Index.php?actie=herbeginnen\">Herbeginnen</a></td>";
            $resstring .= "<td></td>";
            $resstring .= "<td></td>";
            $resstring .= "<td></td>";
            $resstring .= "</tr>";

            $resstring .= "</table>";
        }
        else
        {
            $resstring = "Cart is leeg";
        }
        echo $resstring;
    }

    public static function showOrderForm()
    {
        Execute::showTitle("Bestelling");
        ?>
        <form action="Index.php?actie=bestellen" method=post>
            <div>
                <label for=klantnaam>Klantnaam</label>
                <input type=text name=klantnaam id=klantnaam>
            </div>
            <div>
                <label for=email>E-mail</label>
                <input type=text name=email id=email>
            </div>
            <div>
                <input type=submit name=bevestigknop value=Bestel>
            </div>
        </form>

        <?php
    }

    public static function showErrors($errortable)
    {
        $resstring = "<p><strong>Fouten in de invoer</strong></p>";
        $resstring .= "<p>";
        foreach ($errortable as $error)
        {
            $resstring .= $error . "; ";
        }
        $resstring .= "<p>";
        echo $resstring;
    }
}

