<?php

echo "<form action=\"queryResult.php\" method=\"get\">
	  MySQL Command: <input type = \"Text\" Name = \"phpQuery\" style= \"width: 80%\">
	  <input type=\"submit\" value=\"Query\">";

$servername = "mysql.eecs.ku.edu";
$username = "dconway";
$password = "michael";
$dbname = "dconway";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 

$sql = $_GET["phpQuery"];
$result = $conn->query($sql);
$numCols = $result->field_count;

echo "<br><br>" . $sql . "<br>-------------------------------------------------------<br>";


if ($result->num_rows > 0) {
	echo "<head>
		  <style>
		  table, th, td {
			  border: 1px solid black;
			  border-collapse: collapse;
		  }
		  th, td {
			  padding: 5px;
		  }
		  </style>
		  </head>";

	echo "<table style=\"width:auto\">";

	$colHeader = array();
    // output data of each row
	echo "<tr>";
	for($i = 0; $i < $numCols; $i++)
	{
		array_push($colHeader, $result->fetch_field_direct($i)->name);
		echo "<th>" . $colHeader[$i] . "</th>";
	}
	echo "</tr>";
	echo "<br>";
    while($row = $result->fetch_assoc()) 
	{
		echo "<tr>";
		for($i = 0; $i < $numCols; $i++)
		{
			$colInfo = $result->fetch_field_direct($i);
			$colName = $colInfo->name;
			echo "<td>" . $row[$colName] . "</td>";
		}
		echo "</tr>";
    }
} else {
    echo "0 results";
}

?>
