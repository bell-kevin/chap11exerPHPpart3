
CREATE DATABASE banking CHARACTER SET utf8 COLLATE utf8_general_ci;

USE banking;

CREATE TABLE customers (
customer_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
first_name 	VARCHAR(20) NOT NULL,
last_name 	VARCHAR(40) NOT NULL,
PRIMARY KEY (customer_id),
INDEX full_name (last_name, first_name)
) ENGINE = INNODB;

CREATE TABLE accounts (
account_id INT 	UNSIGNED NOT NULL AUTO_INCREMENT,
customer_id INT UNSIGNED NOT NULL,
acct_type ENUM('Checking', 'Savings') NOT NULL,
balance DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.0,
PRIMARY KEY (account_id),
INDEX (customer_id),
INDEX (acct_type),
FOREIGN KEY (customer_id) REFERENCES customers (customer_id) 
	ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = INNODB;

CREATE TABLE transactions (
transaction_id 	INT UNSIGNED NOT NULL AUTO_INCREMENT,
to_account_id 	INT UNSIGNED NOT NULL,
from_account_id INT UNSIGNED NOT NULL,
amount DECIMAL(5,2) UNSIGNED NOT NULL,
date_entered TIMESTAMP NOT NULL,
PRIMARY KEY (transaction_id),
INDEX (to_account_id),
INDEX (from_account_id),
INDEX (date_entered),
FOREIGN KEY (to_account_id) REFERENCES accounts (account_id)
	ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (from_account_id) REFERENCES accounts (account_id)
	ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = INNODB;

INSERT INTO customers (first_name, last_name)
VALUES ('Sarah', 'Vowell'), 
	('David', 'Sedaris'), 
	('Kojo', 'Nnamdi'),
	('Dean', 'Brookston'), 
	('Mary', 'Jamison'), 
	('Adam', 'Cook'),
	('Nick', 'Hornby'),
	('Melissa', 'Bank')
	;
INSERT INTO accounts (customer_id, balance)
VALUES (1, 5460.23), 
	(2, 909325.24), 
	(3, 892.00),
	(4, 12056.41),
	(5, 32901.50),
	(6, 54120.00),
	(7, 167309.56),
	(8, 87156.44)
	;
INSERT INTO accounts (customer_id, acct_type, balance)
VALUES (2, 'Savings', 13546.97),
	(4, 'Savings', 585.90),
	(5, 'Savings', 1879456.00),
	(7, 'Savings', 1298701.50),
	(8, 'Savings', 1015809.25)
;

