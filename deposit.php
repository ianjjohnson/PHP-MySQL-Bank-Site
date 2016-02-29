<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' 
			&& isset($_POST['account'])
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

				$select = $db->prepare('SELECT * FROM account WHERE name = :n AND username = :u');
			
				$select->execute(array(':n' => $_POST['account'], 
									':u' => $_COOKIE['username']
									));

				$accounts = $select->fetchAll(PDO::FETCH_ASSOC);

				if(empty($accounts)){
					echo "No such account. <br />";
				}

				$balance = 0;

				foreach($accounts as $account){
					$balance = $account['balance'];
				}

				$newBalance = floatval($balance) + floatval($_POST['amount']);

				$update = $db->prepare('UPDATE account SET balance = :b WHERE username = :u AND name = :n');
				$update->execute(array(':n' => $_POST['account'], 
									':u' => $_COOKIE['username'],
									':b' => $newBalance
									));

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