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
	<?php 
	$dbc = mysqli_connect('localhost', 'root', 'password', 'banking') or die('Could not connect to MySQL: ' . mysqli_connect_error());

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (
			isset($_POST['from'], $_POST['to'], $_POST['amount']) &&
			is_numeric($_POST['from']) && is_numeric($_POST['to']) && is_numeric($_POST['amount'])
		) {

			$from = $_POST['from'];
			$to = $_POST['to'];
			$amount = $_POST['amount'];

			$q = "SELECT balance FROM accounts WHERE account_id=$from";
			$r = @mysqli_query($dbc, $q);
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			if ($amount > $row['balance']) {
				$error = "Insufficient funds to complete the transfer of $" . number_format($amount, 2) . "!";
			} else {
				mysqli_autocommit($dbc, FALSE);

				$q = "UPDATE accounts SET balance=balance-$amount WHERE account_id=$from";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) {

					$q = "UPDATE accounts SET balance=balance+$amount WHERE account_id=$to";
					$r = @mysqli_query($dbc, $q); 
					if (mysqli_affected_rows($dbc) == 1) {

						mysqli_commit($dbc);
						$success = "The transfer of $" . number_format($amount, 2) . " was a success!";
					} else {
						mysqli_rollback($dbc);
						$error = "Insufficient funds to complete the transfer of $" . number_format($amount, 2) . "!";
						echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>';
					}
				} else {
					mysqli_rollback($dbc);
					$error = "Insufficient funds to complete the transfer of $" . number_format($amount, 2) . "!";
					echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>';
				}
			}
		} else {
			echo '<p class="error">Please select a valid "from" and "to" account and enter a numeric amount to transfer.</p>';
		}
	} 
	$q = "SELECT account_id, CONCAT(last_name, ', ', first_name) AS name, acct_type, balance FROM accounts LEFT JOIN customers USING (customer_id) ORDER BY name";
	$r = @mysqli_query($dbc, $q);
	$options = '';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$balance = number_format($row['balance'], 2);
		$options .= "<option value=\"{$row['account_id']}\">{$row['name']} ({$row['acct_type']}) \${$balance}</option>\n";
	}

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
