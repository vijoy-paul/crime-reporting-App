<style type="text/css">
table {
margin: 8px;
}

#info {
font-family: Arial, Helvetica, sans-serif;
font-size: 1.7em;
background: #666;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
width: 35%;
height: 90%;
display: inline-block;
vertical-align:top;
}

#head {
	font-family: Arial, Helvetica, sans-serif;
font-size: 1.7em;
background: #666;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
width: 95.3%;
height: 6%;
}

#map {
width: 60%;
height: 90%;
vertical-align:top;
display: inline-block;
}

#btnViewMap {

}

#drpStat
{
	width: 25%;
	height: 5%;
}

table, td, th {
  border: 0px solid black;
  color: white;
}

table {
  border-collapse: collapse;
  width: 80%;
  height: 40%;
  text-align: left;
  vertical-align: 20%;


}

</style>

<div id="head">
	DRS - Emergency Viewer
</div>

<?php 
	include('db_config.php');
	$emergencyId = $_GET['uniqId'];
	$conn = new mysqli($host, $user, $password, $db);
	
	if ($conn->connect_error)
	{
		die("Connection error: " . $conn->connect_error);
	}
	
	$updateStatus = "UPDATE emergency SET status='ATTENDED' WHERE uniqueId=$emergencyId";
	
	mysqli_query($conn,$updateStatus);

	$result = $conn->query("SELECT * FROM emergency where uniqueId=$emergencyId");

	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$lati = $row['lat'];
			$long = $row['lon'];
?>
			<div id="map">
				<iframe width="100%" height="100%" frameborder="5" style="border:50"
				src="https://www.google.com/maps/embed/v1/place?q=<?php echo $lati?>,<?php echo $long?>&key=AIzaSyA_CwqDu6XvWNuT7U-V7NbukxnSPyi0mxk" allowfullscreen>
				</iframe>

			</div>


			<div id = info>
			<table>
			<tr><td>Emergency ID</td><td><?php echo $row['uniqueId']?></td></tr>
			<tr><td>Date and Time</td><td><?php echo $row['dateTime']?></td></tr>
			
			<tr><td>Description</td><td><?php echo $row['description']?></td></tr>
			<tr><td>Current Status</td><td><?php echo $row['status']?></td></tr>
			</table>
			<table>
			<tr><td>Units Required:</td></tr>
			<tr><td>Police</td><td><?php echo $row['police']?></td><td>
<?php
			if($row['police'] == 'YES')
			{
				if($row['np'] == 0)
				{
					
?>
					<form method="get" action="informpolice.php">
			    		<input type="hidden" name="uniqId" value="<?php echo $row['uniqueId']?>">
			    		<input type="submit" value="Notify Police">
					</form>
<?php
//AMBULANCE FUNCTIONS FROM HERE
				}
				else
				{
					echo "Already Notified";
				}
			}
?>
</td></tr>
<tr><td>Ambulance</td><td><?php echo $row['ambulance']?></td><td>
<?php
			if($row['ambulance'] == 'YES')
			{
				if($row['na'] == 0)
				{
					
?>
					<form method="get" action="informparamedics.php">
			    		<input type="hidden" name="uniqId" value="<?php echo $row['uniqueId']?>">
			    		<input type="submit" value="Notify Police">
					</form>
<?php
//AMBULANCE FUNCTIONS FROM HERE
				}
				else
				{
					echo "Already Notified";
				}
			}
?>
</td></tr>
<tr><td>Fire department</td><td><?php echo $row['firebrigade']?></td><td>
<?php
			if($row['firebrigade'] == 'YES')
			{
				if($row['nf'] == 0)
				{
					
?>
					<form method="get" action="informfiredepartment.php">
			    		<input type="hidden" name="uniqId" value="<?php echo $row['uniqueId']?>">
			    		<input type="submit" value="Notify Police">
					</form>
<?php
//AMBULANCE FUNCTIONS FROM HERE
				}
				else
				{
					echo "Already Notified";
				}
			}
?>
</td></tr>
</table>
<?php
			echo "Mark report Solved and Close the report:";
?>	
			<form method="get" action="changestatus.php">
	    		<input type="hidden" name="uniqId" value="<?php echo $row['uniqueId']?>">
	    		<input type="submit" value="Click Here">
			</form>

			</div>

<?php 
			

		}
		
	}
?>

<div id="btnViewMap">
Note: If somehow map is not visible, please click this button to view location on map.</br>
<button onclick="window.location.href = 'http://maps.google.com/maps?q=<?php echo $lati?>,<?php echo $long?>';">View Map</button>
</div>