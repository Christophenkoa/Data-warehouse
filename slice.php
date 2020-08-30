<?php 

try {
		$bdd = new PDO('mysql:host=localhost;dbname=datawarehouse;charset=utf8', 'root', '');
	}catch(Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

		echo '<h1 style="text-align:center; text-decoration: underline; font-weight:normal; color: blue;">SLICE PAGE</h1>';

	if(isset($_POST['Submit'])) {

		if (isset($_POST['timedimension'])) {
			
			$time = $_POST['timedimension'];

			$requete = $bdd->prepare('SELECT day , timeID FROM timedimension WHERE timedimension.day = ?');
			$requete->execute(array($time));

			$test = true;
			$dayf = 0;
			$timef = 0;

			while ($donnee = $requete->fetch()) {

				$test = false;

				$dayf = $donnee['day'];
				$timef = $donnee['timeID'];
			}


			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  locationdimension.district , productdimension.productName , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN locationdimension   ON  locationdimension.locationID = sales.locationID
							JOIN productdimension    ON  productdimension.productID = sales.productID
							WHERE sales.timeID = ?
							GROUP BY locationdimension.district , productdimension.productName');

			$req->execute(array($timef));


            echo'<table border style="margin:auto;">
	  		  <tr>
	  		  	<th>Product Name</th>
			    <th>District</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
					<td>'.$donnees['productName'].'</td>
				    <td>'.$donnees['district'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



	echo'</table>';
	

			}

		if (isset($_POST['locationdimension'])) {
			
			$location = $_POST['locationdimension'];

			$requete = $bdd->prepare('SELECT district , locationID FROM locationdimension WHERE locationdimension.district = ?');
			$requete->execute(array($location));

			$test = true;
			$locationf = 0;
			$districtf = 0;

			while ($donnee = $requete->fetch()) {

				$test = false;

				$locationf = $donnee['locationID'];
				$districtf = $donnee['district'];
			}


			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  timedimension.day , productdimension.productName , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN timedimension       ON  timedimension.timeID = sales.timeID
							JOIN productdimension    ON  productdimension.productID = sales.productID
							WHERE sales.locationID = ?
							GROUP BY timedimension.day , productdimension.productName');

			$req->execute(array($locationf));


            echo'<table border style="margin:auto;">
	  		  <tr>
	  		  	<th>Product Name</th>
			    <th>Day</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
					<td>'.$donnees['productName'].'</td>
				    <td>'.$donnees['day'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



	echo'</table>';
	

			}



		if (isset($_POST['productdimension'])) {
			
			$product = $_POST['productdimension'];

			$requete = $bdd->prepare('SELECT productName , productID FROM productdimension WHERE productdimension.productName = ?');
			$requete->execute(array($product));

			$test = true;
			$productID = 0;
			$productName = 0;

			while ($donnee = $requete->fetch()) {

				$test = false;

				$productID = $donnee['productID'];
				$productName = $donnee['productName'];
			}


			if($test) {
				exit("no found value");
			}

			$req = $bdd->prepare('SELECT  timedimension.day , locationdimension.district , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN timedimension        ON  timedimension.timeID = sales.timeID
							JOIN locationdimension    ON  locationdimension.locationID = sales.locationID
							WHERE sales.productID = ?
							GROUP BY timedimension.day , locationdimension.district');

			$req->execute(array($productID));


            echo'<table border style="margin:auto;">
	  		  <tr>
	  		  	<th>District</th>
			    <th>Day</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $req->fetch()) {

			echo'<tr>
					<td>'.$donnees['district'].'</td>
				    <td>'.$donnees['day'].'</td>
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
  
    <p> Enter the value of the row that you want to slice : </p>

	<form method="POST">
        <label>Time dimension: </label><br>
  		<input type="text" name="timedimension"><br>
        <input type="submit" name="Submit" value="Submit">
   </form><br><br>

   	<form method="POST">
        <label>Location Dimension: </label><br>
  		<input type="text" name="locationdimension"><br>
        <input type="submit" name="Submit" value="Submit">
   </form><br><br>

   	<form method="POST">
        <label>Product dimension: </label><br>
  		<input type="text" name="productdimension"><br>
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


