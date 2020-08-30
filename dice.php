<?php 

try {
		$bdd = new PDO('mysql:host=localhost;dbname=datawarehouse;charset=utf8', 'root', '');
	}catch(Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

			echo '<h1 style="text-align:center; text-decoration: underline; font-weight:normal; color: blue;">DICE PAGE</h1>';

	if(isset($_POST['Submit'])) {

		if (isset($_POST['timedimension'])&&isset($_POST['productdimension']) ) {
			
			$time = $_POST['timedimension'];
			$product = $_POST['productdimension'];

			$requete = $bdd->prepare('SELECT timeID FROM timedimension WHERE timedimension.day = ?');
			$requete->execute(array($time));

			$requete2 = $bdd->prepare('SELECT productID FROM productdimension WHERE productdimension.productName = ?');
			$requete2->execute(array($product));

			$test = true;
			$dayID = 0;
			$productID = 0;

			while ($donnee = $requete->fetch()) {

				while($donnee2 = $requete2->fetch()){
				$test = false;

				$dayID = $donnee['timeID'];
				$productID = $donnee2['productID'];					
				}

			}


			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  locationdimension.district , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN locationdimension ON  locationdimension.locationID = sales.locationID
							WHERE sales.timeID = ? AND sales.productID = ?
							GROUP BY locationdimension.district');

			$req->execute(array($dayID,$productID));


            echo'<table border style="margin:auto;">
	  		  <tr>
			    <th>District</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
				    <td>'.$donnees['district'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



		echo'</table>';
	

			}

			//implementation

		if (isset($_POST['locationdimension'])&&isset($_POST['productdimension']) ) {
			
			$location = $_POST['locationdimension'];
			$product = $_POST['productdimension'];

			$requete = $bdd->prepare('SELECT locationID FROM locationdimension WHERE locationdimension.district = ?');
			$requete->execute(array($location));

			$requete2 = $bdd->prepare('SELECT productID FROM productdimension WHERE productdimension.productName = ?');
			$requete2->execute(array($product));

			$test = true;
			$locationID = 0;
			$productID = 0;

			while ($donnee = $requete->fetch()) {

				while($donnee2 = $requete2->fetch()){
				$test = false;

				$locationID = $donnee['locationID'];
				$productID = $donnee2['productID'];					
				}

			}


			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  timedimension.day , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN timedimension     ON  timedimension.timeID = sales.timeID
							WHERE sales.locationID = ? AND sales.productID = ?
							GROUP BY timedimension.day');

			$req->execute(array($locationID,$productID));


            echo'<table border style="margin:auto;">
	  		  <tr>
			    <th>Day</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
				    <td>'.$donnees['day'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



		echo'</table>';
	

			}
	




		if (isset($_POST['locationdimension'])&&isset($_POST['timedimension']) ) {
			
			$location = $_POST['locationdimension'];
			$time = $_POST['timedimension'];

			$requete = $bdd->prepare('SELECT locationID FROM locationdimension WHERE locationdimension.district = ?');
			$requete->execute(array($location));

			$requete2 = $bdd->prepare('SELECT timeID FROM timedimension WHERE timedimension.day = ?');
			$requete2->execute(array($time));

			$test = true;
			$locationID = 0;
			$timeID = 0;

			while ($donnee = $requete->fetch()) {

				while($donnee2 = $requete2->fetch()){
				$test = false;

				$locationID = $donnee['locationID'];
				$timeID = $donnee2['timeID'];					
				}

			}



			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  productdimension.productName , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN productdimension      ON  productdimension.productID = sales.productID
							WHERE sales.locationID = ? AND sales.timeID = ?
							GROUP BY productdimension.productName');

			$req->execute(array($locationID,$timeID));


            echo'<table border style="margin:auto;">
	  		  <tr>
			    <th>Product Name</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
				    <td>'.$donnees['productName'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



		echo'</table>';
	

		}


}

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
  
    <p> Enter a couple of values which will use for the dice operation: </p>

	<form method="POST">
        <label>Time dimension: </label><br>
  		<input type="text" name="timedimension"><br>
  		<label>Product dimension: </label><br>
  		<input type="text" name="productdimension"><br>
        <input type="submit" name="Submit" value="Submit">
   </form><br><br>

   	<form method="POST">
        <label>Location Dimension: </label><br>
  		<input type="text" name="locationdimension"><br>
        <label>Product dimension: </label><br>
  		<input type="text" name="productdimension"><br>
        <input type="submit" name="Submit" value="Submit">
   </form><br><br>

   	<form method="POST">
        <label>Time dimension: </label><br>
  		<input type="text" name="timedimension"><br>
        <label>Location Dimension: </label><br>
  		<input type="text" name="locationdimension"><br>
        <input type="submit" name="Submit" value="Submit">
   </form><br><br>


    <footer style="text-align: right;">
	   	<a href="http://localhost/data warehouse/index.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Main Page</a><br> 
	   	<a href="http://localhost/data warehouse/rollUp.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollUp Page</a><br>
	   	<a href="http://localhost/data warehouse/rollDown.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollDown Page</a><br>
	   	<a href="http://localhost/data warehouse/slice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Slice Page</a><br>
	   	<a href="http://localhost/data warehouse/dice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Dice Page</a><br>
   </footer>
  
</body>
</html>