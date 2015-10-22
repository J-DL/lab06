<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		if(!isset($_POST["nom"]) || !isset($_POST["membershipNumber"]) || 
		!isset($_POST["fruit"]) || !isset($_POST["quantity"]) || 
		!isset($_POST["cardnumber"]) || !isset($_POST["creditcard"]) ||
		(!isset($_POST["organic"]) && !isset($_POST["domestically_produced"]) && 
		!isset($_POST["genetically_modified"]) && !isset($_POST["newly_harvested"])) || 
		$_POST["nom"]==="")
		{?>
			<!-- Ex 4 : 
			Display the below error message :--> 
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. <a href="http://localhost/lab6/fruitstore.html">Try again?</a></p>

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		}
		elseif(!ctype_alpha($_POST["nom"]) || preg_match("/.*(  |--).*/", $_POST["nom"])) 
		{ 
		?>

		<!-- Ex 5 : 
			Display the below error message : -->
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="http://localhost/lab6/fruitstore.html">Try again?</a></p>
		 

		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		} 
		elseif(!ctype_digit($_POST["cardnumber"]) || strlen($_POST["cardnumber"])!=16 || 
		($_POST["creditcard"]=="visa" && $_POST["cardnumber"][0]!=4) || ($_POST["creditcard"]=="mastercard" && $_POST["cardnumber"][0]!=5))
		{
		?>

		<!-- Ex 5 : 
			Display the below error message : -->
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="http://localhost/lab6/fruitstore.html">Try again?</a></p>
		 
		<?php
		# if all the validation and check are passed 
		} 
		else 
		{
			?>

			<h1>Thanks!</h1>
			<p>Your information has been recorded.</p>
			
			<!-- Ex 2: display submitted data -->
			<ul> 
				<li>Name: <?= $_POST["nom"] ?></li>
				<li>Membership Number: <?= $_POST["membershipNumber"] ?></li>
				<li>Options: 
				<?php 
				$options = "";
				if(isset($_POST["organic"]))
				{
					$options = "organic";
				}
				if(isset($_POST["domestically_produced"]))
				{
					if($options!="")
					{
						$options = $options.", ";
					}
					$options = $options."domestically produced";
				}
				if(isset($_POST["genetically_modified"]))
				{
					if($options!="")
					{
						$options = $options.", ";
					}
					$options = $options."genetically modified";
				}
				if(isset($_POST["newly_harvested"]))
				{
					if($options!="")
					{
						$options = $options.", ";
					}
					$options = $options."newly harvested";
				}
				 ?><?= $options ?>
				
				</li>
				<li>Fruits: <?= $_POST["fruit"] ?> - <?= $_POST["quantity"] ?></li>
				<li>Credit <?= $_POST["cardnumber"] ?> (<?= $_POST["creditcard"] ?>)</li>
				
			</ul>
			
			<!-- Ex 3 : 
				<p>This is the sold fruits count list:</p> -->
			<?php
				$filename = "customers.txt";
				/* Ex 3: 
				 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
				 * For example, "Scott Lee;20110115238;apple;3"
				 */
				 $file = fopen($filename, "a");
				 
				if(!filesize($filename)==0)
				{
					fwrite($file,"\n");
				}
				 fwrite($file, $_POST["nom"].";".$_POST["cardnumber"].";".$_POST["fruit"].";".$_POST["quantity"]);
				fclose($file);
			?>
			
			<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
				Create unordered list to show the number of fruit sold -->
			<ul>
			<?php 
			$fruitcounts = soldFruitCount($filename);
			foreach($fruitcounts as $key => $value) 
			{
			?>
			<li><?= $key?>:<?=$value ?></li>
			<?php
			}
			?>
			</ul>
			
			<?php
			# }
			?>
			
			<?php
				/* Ex 3 :
				* Get the fruits species and the number from "customers.txt"
				* 
				* The function parses the content in the file, find the species of fruits and count them.
				* The return value should be an key-value array
				* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
				*/
				
		}?>
		
		<?php
		function soldFruitCount($filename) 
		{
			$file = fopen($filename, "r");
			$fruitsList = Array();
			
			if($file)
			{
				while (($line = fgets($file)) !== false) 
				{
					$splitedLine = explode(";", $line);
					
					if(isset($fruitsList[$splitedLine[2]]))
					{
						$fruitsList[$splitedLine[2]] = $fruitsList[$splitedLine[2]]+$splitedLine[3];
					}
					else
					{
						$fruitsList[$splitedLine[2]] = $splitedLine[3];
					}
				}
			}
			
			fclose($file);
			
			return $fruitsList;
		}?>
		
	</body>
</html>
