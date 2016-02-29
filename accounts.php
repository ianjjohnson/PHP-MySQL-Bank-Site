<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<h3>Accounts</h3>


	<?php

		try{

			$db = new PDO('mysql:host=localhost;dbname=bank;charset=utf8', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$select = $db->prepare('SELECT * FROM session WHERE sessionKey = :k AND username = :u');
			
			$select->execute(array(':k' => $_COOKIE['sessionKey'], 
									':u' => $_COOKIE['username']
									));
				
			$arr = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($arr) >= 1){
				
				$select = $db->prepare('SELECT * FROM account WHERE username = :u');

				$select->execute(array(':u' => $_COOKIE['username']));

				$arr = $select->fetchAll(PDO::FETCH_ASSOC);

				foreach($arr as $acc){
					echo $acc['name'] . ': $' . $acc['balance'] . '<br />';
				}

			} else {
				echo "Nah, nah, nah";
			}

		} catch (PDOException $e){
				echo "Error: " . $e->getMessage();
		}

	?>

	<h3>Deposit</h3>

	<form method="post" action="deposit.php">
  		Account<br>
  		<input type="text" name="account"><br>
  		Amount<br>
  		<input type="text" name="amount"><br>
  		<input type="submit" value="Submit">
	</form>

	<h3>Withdraw</h3>

	<form method="post" action="withdraw.php">
  		Account<br>
  		<input type="text" name="account"><br>
  		Amount<br>
  		<input type="text" name="amount"><br>
  		<input type="submit" value="Submit">
	</form>

	<h3>Transfer</h3>

	<form method="post" action="transfer.php">
  		From Account<br>
  		<input type="text" name="from"><br>
  		To Account<br>
  		<input type="text" name="to"><br>
  		Amount<br>
  		<input type="text" name="amount"><br>
  		<input type="submit" value="Submit">
	</form>

	<h3>Logout</h3>

	<form method="post" action="logout.php">
  		<input type="submit" value="Logout">
	</form>

</body>



</html>