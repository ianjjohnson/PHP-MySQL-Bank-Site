<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' 
			&& isset($_POST['from'])
			&& isset($_POST['to'])
			&& isset($_POST['amount'])
		){

			$db = new PDO('mysql:host=localhost;dbname=bank;charset=utf8', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$select = $db->prepare('SELECT * FROM session WHERE sessionKey = :k AND username = :u');
			
			$select->execute(array(':k' => $_COOKIE['sessionKey'], 
									':u' => $_COOKIE['username']
									));
				
			$arr = $select->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($arr)){
				
				echo "User is legit" . $_POST['account'] . $_COOKIE['username'];
				echo "User is legit";

				$selectFrom = $db->prepare('SELECT * FROM account WHERE name = :n AND username = :u');
			
				$selectFrom->execute(array(':n' => $_POST['from'], 
									':u' => $_COOKIE['username']
									));

				$accounts = $selectFrom->fetchAll(PDO::FETCH_ASSOC);

				if(empty($accounts)){
					echo "No such account. <br />";
				}

				$fromBalance = 0;

				foreach($accounts as $account){
					$fromBalance = $account['balance'];
				}

				$selectTo = $db->prepare('SELECT * FROM account WHERE name = :n AND username = :u');
			
				$selectTo->execute(array(':n' => $_POST['to'], 
									':u' => $_COOKIE['username']
									));

				$accounts = $selectTo->fetchAll(PDO::FETCH_ASSOC);

				if(empty($accounts)){
					echo "No such account. <br />";
				}


				$toBalance = 0;

				foreach($accounts as $account){
					$toBalance = $account['balance'];
				}

			

				$newBalanceFrom = floatval($fromBalance) - floatval($_POST['amount']);

				$newBalanceTo = floatval($toBalance) + floatval($_POST['amount']);

				if($newBalanceFrom > 0){

					$update = $db->prepare('UPDATE account SET balance = :b WHERE username = :u AND name = :n');
					$update->execute(array(':n' => $_POST['from'], 
									':u' => $_COOKIE['username'],
									':b' => $newBalanceFrom
									));
					$update->execute(array(':n' => $_POST['to'], 
									':u' => $_COOKIE['username'],
									':b' => $newBalanceTo
									));

				}

				header('Location: accounts.php');
				

				

			} else {
				echo "Nah, nah, nah";
			}
		} else {
			echo "Bad dog!";
		}
	?>

</body>



</html>