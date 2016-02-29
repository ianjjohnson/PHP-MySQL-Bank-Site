<html>

<head>

<title> The Bank of Ian Johnson </title>

</head>

<h1> The Bank of Ian Johnson </h1>

<body>

	<form method="post" action="login.php">
  		Username<br>
  		<input type="text" name="usr"><br>
  		Password<br>
  		<input type="password" name="pwd"><br>
  		<input type="submit" value="Submit">
	</form>

  Current users:
  <br />
  'ian' => 'pass'
  <br />
  'johndoe' => 'helloworld'


  <?php

      if(isset($_COOKIE['username']) && isset($_COOKIE['sessionKey'])){


        $db = new PDO('mysql:host=localhost;dbname=bank;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $select = $db->prepare('SELECT * FROM session WHERE username = :u AND sessionKey = :k');

        $select->execute(array(':u' => $_COOKIE['username'],
                              ':k' => $_COOKIE['sessionKey']
          ));

        $arr = $select->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($arr)){
            header('Location: accounts.php');
        }

      }
  ?>

</body>



</html>