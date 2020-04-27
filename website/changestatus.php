<?php 
	include('db_config.php');
	$emergencyId = $_GET['uniqId'];
	$conn = new mysqli($host, $user, $password, $db);
	$redir = 0;

	if ($conn->connect_error)
	{
		$redir = 0;
		die("Connection error: " . $conn->connect_error);
	}

	$updateStatus = "UPDATE emergency SET status='CLOSED' WHERE uniqueId=$emergencyId";
	
	mysqli_query($conn,$updateStatus);
	
?>
	
	<h1 style="font-size:8vw;word-wrap: break-word;">Report successfully closed!</h1>
	<h3 style="font-size:2vw;word-wrap: break-word;">To go back to the home page <a href="index.php">click here...</a></h3>