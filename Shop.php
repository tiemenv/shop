<?php
class Shop
{
	private static $shopInstance = null;

	private $db;

	private function __construct()
	{
		try
		{
		    $config = Config::getConfigInstance();
			$server = $config->getServer();
			$database = $config->getDatabase();
			$username = $config->getUsername();
			$password = $config->getPassword();
			
			$this->db = new PDO("mysql:host=$server; dbname=$database; charset=utf8mb4",
				$username,
				$password,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public static function getShopInstance()
	{
		if(is_null(self::$shopInstance))
		{
			self::$shopInstance = new Shop();
		}
		return self::$shopInstance;
	}

	public function closeDB()
	{
		self::$shopInstance = null;
	}

	public function getLastInsertId()
	{
		return intval($this->db->lastInsertId());
	}
	
	public function getAllProducts()
	{
		try
		{
			$sql = "SELECT * FROM producten";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$producttable = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}

		return $producttable;
	}

	public function getProductByNr($productnr)
	{
		try
		{
			$sql = "SELECT * FROM producten
                        WHERE productnr = :productnr";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":productnr", $productnr);
			$stmt->execute();
			$product = $stmt->fetch(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}

		if(empty($product))
		{
			die("Productnr niet gevonden");
		}

		return $product;
	}

	public function addCustomer($customername, $email)
	{
		try
		{
			$sql = "INSERT INTO klanten(klantnaam, email)
						VALUES(:klantnaam, :email)";
			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(":klantnaam", $customername);
			$stmt->bindParam(":email", $email);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public function addOrder($customernr, $productnr, $amount)
	{
		try
		{
			$sql = "INSERT INTO bestellingen(klantnr, productnr, aantal)
						VALUES(:klantnr, :productnr, :aantal)";
			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(":klantnr", $customernr);
			$stmt->bindParam(":productnr", $productnr);
			$stmt->bindParam(":aantal", $amount);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public function addCustomerWithOrder($customername, $email, $cartArray)
	{
		try
        {
            $this->addCustomer($customername, $email);
            $klantnr = $this->getLastInsertId();
            foreach ($cartArray as $productnr => $amount)
            {
                $this->addOrder($klantnr, $productnr, $amount);
            }
        }
        catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
}

