<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usr'])){

			try{

				$db = new PDO('mysql:host=localhost;dbname=bank;charset=utf8', 'root', '');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$usr = $_POST['usr'];


				$select = $db->prepare('SELECT * FROM auth WHERE username = ?');

				$select->execute(array($usr));
				
				$arr = $select->fetchAll(PDO::FETCH_ASSOC);

				echo '<br />';

				$found = false;

				foreach($arr as $item){
					echo 'Hash: ' . $item['hash'] . '<br />';
					echo 'Salt: ' . $item['salt'] . '<br />';

					if(hash('sha256', $_POST['pwd'] . $item['salt']) == $item['hash']){
						echo "Logged in <br />";
						$num = mt_rand(0,9999999999);
						setcookie('sessionKey', $num, time() + 60*15, '/');
						setcookie('username', $usr, time() + 60*15, '/');

						$insert = $db->prepare('INSERT into session values( \'' . $usr . '\' , ' . $num . ')');
						$insert->execute();
						echo $num;

						header('Location: accounts.php');
						$found = true;
					}
				}

				if($found == false){
					header('Location: index.php');
				}

			} catch (PDOException $e){
				echo "Error: " . $e->getMessage();
			}
		} else {
			echo "Bad dog";
		}
	?>

</body>



</html>