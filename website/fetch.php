<style>
#head {
	font-family: Arial, Helvetica, sans-serif;
font-size: 1.7em;
background: #666;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
width: 99%;
height: 6%;
text-align: center;
}
</style>
<div id="head">DIGITAL REPORTING SYSTEM: CONTROL ROOM</div>
<center><h1>UNATTENDED EMERGENCY REPORTS</h1></center>
<?php 
	include('db_config.php');
	$conn = new mysqli($host, $user, $password, $db);
	
	if ($conn->connect_error)
	{
		die("Connection error: " . $conn->connect_error);
	}

	$result = $conn->query("SELECT * FROM emergency WHERE status='UNATTENDED'");
	
	if ($result->num_rows > 0)
	{
		echo "<center><table border='8'>
		<tr>
		<th style=word-wrap:break-word;width:25px;>ID</th>
		<th style=word-wrap:break-word;width:80px;>Timestamp</th>
		<th style=word-wrap:break-word;width:500px;>Description</th>
		<th style=word-wrap:break-word;width:200px;>Location/Landmark</th>
		<th style=word-wrap:break-word;width:200px;></th>
		</tr>
		</table>";
		
		while ($row = $result->fetch_assoc())
		{
			echo "<table border='8'>";
			echo "<tr>";
			echo "<td style=word-wrap:break-word;width:25px;>" . $row['uniqueId'] . "</td>";
			echo "<td style=word-wrap:break-word;width:80px;>" . $row['dateTime'] . "</td>";
			echo "<td style=word-wrap:break-word;width:500px;>" . $row['description'] . "</td>";
			echo "<td style=word-wrap:break-word;width:200px;>" . $row['landmark'] . "</td>";
			
?>
			
			<td style=word-wrap:break-word;width:200px;>
				<center>
					<form method="get" action="emergency.php">
	    				<input type="hidden" name="uniqId" value="<?php echo $row['uniqueId']?>">
	    				<input type="submit" value="Attend">
					</form>
				</center>
	  		</td>
	  

<?php 
			echo "</tr>";
			echo "</table>";

		}
		
	}
?>