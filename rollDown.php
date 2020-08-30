<?php 

try {
		$bdd = new PDO('mysql:host=localhost;dbname=datawarehouse;charset=utf8', 'root', '');
	}catch(Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

		echo '<h1 style="text-align:center; text-decoration: underline; font-weight:normal; color: blue;">ROLLDOWN PAGE</h1>';


	if (isset($_POST['rollupValue'])) {

		$rollupValue = $_POST['rollupValue'];

		if ($rollupValue == "locationdimension.district") {
			
			$requete = $bdd->query('SELECT  locationdimension.district , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN locationdimension   ON  locationdimension.locationID = sales.locationID
							GROUP BY locationdimension.district');	

            echo'	<table border style="margin:auto;">
	  		  <tr>
			    <th>district</th>
			    <th>Product Quantity</th>
			    <th>Total</th>
			  </tr>';

			
	       	while($donnees = $requete->fetch()) {

			echo'<tr>
				    <td>'.$donnees['district'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



	echo'</table>';
	
		}

		if ($rollupValue == "timedimension.month") {
			
			$requete = $bdd->query('SELECT  timedimension.month ,SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN timedimension   ON  timedimension.timeID = sales.timeID
							GROUP BY timedimension.month');	

            echo'	<table border style="margin:auto;">
	  		  <tr>
			    <th>district</th>
			    <th>Product Quantity</th>
			    <th>Total Sum</th>
			  </tr>';

			
	       	while($donnees = $requete->fetch()) {

			echo'<tr>
				    <td>'.$donnees['month'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



	echo'</table>';
	
		}

		if ($rollupValue == "timedimension.day") {
			
			$requete = $bdd->query('SELECT timedimension.day  , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN timedimension  ON  timedimension.timeID = sales.timeID
                            GROUP BY timedimension.day');	

            echo'	<table border style="margin:auto;">
	  		  <tr>
			    <th>Day</th>
			    <th>Product Quantity</th>
			    <th>Total sale</th>
			  </tr>';

			
	       	while($donnees = $requete->fetch()) {

			echo'<tr>
				    <td>'.$donnees['day'].'</td>
				    <td>'.$donnees['totalQuantity'].'</td>
				    <td>'.$donnees['totalSum'].'</td>
				</tr>';

			 }



	echo'</table>';
	
		}

		if ($rollupValue == "productdimension.productName") {
			
			$requete = $bdd->query('SELECT productdimension.productName , SUM(quantity) as totalQuantity, SUM(total) as totalSum
							FROM sales
							JOIN productdimension  ON  productdimension.productID = sales.productID
                            GROUP BY productdimension.productName');	

            echo'<table border style="margin:auto;">
	  		  <tr>
			    <th>Product Name</th>
			    <th>Product Quantity</th>
			    <th>Total sale</th>
			  </tr>';

			
	       	while($donnees = $requete->fetch()) {

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
  
	<form  method="POST">
       <p> In which table using which criteria do you want to perform roll down operation? </p>
       <input type="radio" name ="rollupValue" value="locationdimension.district"> location(districts) </br>
       <input type="radio" name ="rollupValue" value="timedimension.month"> Time Dimension(month) </br>
       <input type="radio" name ="rollupValue" value="timedimension.day" > Time Dimension(day) </br>
       <input type="radio" name ="rollupValue" value="productdimension.productName" > Poduct Dimension(Product Name) </br> </br>
       <input type="submit" name="Submit" value="Submit">
   </form>

    <footer style="text-align: right;">
	   	<a href="http://localhost/data warehouse/index.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Main Page</a><br> 
	   	<a href="http://localhost/data warehouse/rollUp.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollUp Page</a><br>
	   	<a href="http://localhost/data warehouse/rollDown.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">RollDown Page</a><br>
	   	<a href="http://localhost/data warehouse/slice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Slice Page</a><br>
	   	<a href="http://localhost/data warehouse/dice.php" style="	font-weight:normal;color:black;text-decoration: none;font-style: italic;">Dice Page</a><br>
   </footer>
  
</body>
</html>
