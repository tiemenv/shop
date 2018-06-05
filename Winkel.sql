CREATE DATABASE Winkel;
USE Winkel;

CREATE TABLE klanten (
  klantnr INT NOT NULL AUTO_INCREMENT,
  klantnaam VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  PRIMARY KEY (klantnr)
) ENGINE = INNODB;

CREATE TABLE producten (
  productnr VARCHAR(20) NOT NULL,
  productnaam VARCHAR(100) NOT NULL,
  prijs INT NOT NULL,
  PRIMARY KEY (productnr)
) ENGINE = INNODB;

CREATE TABLE bestellingen (
  klantnr INT NOT NULL,
  productnr VARCHAR(20) NOT NULL,
  aantal INT NOT NULL DEFAULT 0,
  PRIMARY KEY (klantnr,productnr),
  CONSTRAINT bestellingen_fk_1 FOREIGN KEY (klantnr) REFERENCES klanten(klantnr),
  CONSTRAINT bestellingen_fk_2 FOREIGN KEY (productnr) REFERENCES producten(productnr)
) ENGINE = INNODB;

INSERT INTO producten(productnr, productnaam, prijs) 
VALUES 	('P0802','Windows Phone',500),
	('P0855','Android Phone',400),
	('P0945','Externe monitor',200),
	('P1506','Laptop Dell',1000),
	('P1587','Laptop HP',1200);