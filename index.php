<?php

echo '<h1 style="text-align:center; text-decoration: underline; font-weight:normal; color: blue;" > MAIN PAGE</h1>'; 

try {
		$bdd = new PDO('mysql:host=localhost;dbname=datawarehouse;charset=utf8', 'root', '');
	}catch(Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

		$requete = $bdd->query('SELECT productdimension.productName, timedimension.month , locationdimension.district , sales.quantity , sales.total
							FROM sales
							JOIN productdimension    ON  productdimension.productID = sales.productID
							JOIN timedimension       ON  timedimension.timeID = sales.timeID
							JOIN locationdimension   ON  locationdimension.locationID = sales.locationID');

	echo'	<table border style="margin:auto;">
	  		  <tr>
			    <th>Product Name</th>
			    <th>Month</th>
			    <th>district</th>
			    <th>Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	while($donnees = $requete->fetch()) {

		echo'<tr>
			    <td>'.$donnees['productName'].'</td>
			    <td>'.$donnees['month'].'</td>
			    <td>'.$donnees['district'].'</td>
			    <td>'.$donnees['quantity'].'</td>
			    <td>'.$donnees['total'].'</td>
			</tr>';

			 }



	echo'</table>';

	echo'<footer style="text-align: right;">
   	<a href="http://localhost/data warehouse/index.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Main Page</a><br> 
   	<a href="http://localhost/data warehouse/rollUp.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollUp Page</a><br>
   	<a href="http://localhost/data warehouse/rollDown.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollDown Page</a><br>
   	<a href="http://localhost/data warehouse/slice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Slice Page</a><br>
   	<a href="http://localhost/data warehouse/dice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Dice Page</a><br>
   </footer>';

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="form.css">
  <script src="script.js"></script>
</head>
	<body>
	  
	</body>
</html>




