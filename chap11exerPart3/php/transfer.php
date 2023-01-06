<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Transfer Funds</title>
	<style type="text/css">
		body {
			font-size: large;
			margin-left: 100px;
		}

		select,
		input {
			font-size: large;
		}

		.success {
			color: green;
		}

		.error {
			color: red;
		}
	</style>
</head>

<body>
	<h1>Transfer Funds</h1>
	<?php # Script 11.7 - transfer.php
	// This page performs a transfer of funds from one account to another.
	// This page uses transactions.

	// Always need the database connection:
	$dbc = mysqli_connect('localhost', 'root', 'password', 'banking') or die('Could not connect to MySQL: ' . mysqli_connect_error());

	// Check if the form has been submitted:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// Minimal form validation:
		if (
			isset($_POST['from'], $_POST['to'], $_POST['amount']) &&
			is_numeric($_POST['from']) && is_numeric($_POST['to']) && is_numeric($_POST['amount'])
		) {

			$from = $_POST['from'];
			$to = $_POST['to'];
			$amount = $_POST['amount'];

			// Make sure enough funds are available:
			$q = "SELECT balance FROM accounts WHERE account_id=$from";
			$r = @mysqli_query($dbc, $q);
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			if ($amount > $row['balance']) {
				echo '<p class="error">Insufficient funds to complete the transfer.</p>';
			} else {
				// Turn autocommit off:
				mysqli_autocommit($dbc, FALSE);

				$q = "UPDATE accounts SET balance=balance-$amount WHERE account_id=$from";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

					$q = "UPDATE accounts SET balance=balance+$amount WHERE account_id=$to";
					$r = @mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

						mysqli_commit($dbc);
						$success = "The transfer of $amount was a success!";
					} else {
						mysqli_rollback($dbc);
						$error = "Insufficient funds to complete the transfer of $amount.";
						echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
					}
				} else {
					mysqli_rollback($dbc);
					$error = "Insufficient funds to complete the transfer of $amount.";
					echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
				}
			}
		} else { // Invalid submitted values.
			echo '<p class="error">Please select a valid "from" and "to" account and enter a numeric amount to transfer.</p>';
		}
	} // End of submit conditional.

	// Always show the form...

	// Get all the accounts and balances as OPTIONs for the SELECT menus:
	$q = "SELECT account_id, CONCAT(last_name, ', ', first_name) AS name, acct_type, balance FROM accounts LEFT JOIN customers USING (customer_id) ORDER BY name";
	$r = @mysqli_query($dbc, $q);
	$options = '';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$balance = number_format($row['balance'], 2);
		//insert number_format() function to format the balance to 2 decimal places
		$options .= "<option value=\"{$row['account_id']}\">{$row['name']} ({$row['acct_type']}) \${$row['balance']}</option>\n";
	}

	// Create the form:
	echo '<form action="transfer.php" method="post">
<p>From Account: <select name="from">' . $options . '</select></p>
<p>To Account: <select name="to">' . $options . '</select></p>
<p>Amount: <input type="number" name="amount" step="0.01" min="1"></p>
<p><input type="submit" name="submit" value="Submit"></p>
</form>';

	if (!empty($success)) : ?>
		<h3 class="success"><?php echo $success; ?></h3>
	<?php elseif (!empty($error)) : ?>
		<h3 class="error"><?php echo $error; ?></h3>
	<?php endif; ?>


</body>

</html>
