<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			try{

				$db = new PDO('mysql:host=localhost;dbname=bank;charset=utf8', 'root', '');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$select = $db->prepare('DELETE FROM session WHERE username= :u');
			
				$select->execute(array(':u' => $_COOKIE['username']));

				header('Location: index.php');

			} catch (PDOException $e){
				echo "Error: " . $e->getMessage();
			}
		} else {
			echo "Bad dog";
		}
	?>

</body>



</html>