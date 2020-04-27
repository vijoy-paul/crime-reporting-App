<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 
    include('db_config.php');
    $police = $_GET['POL'];
    $ambulance = $_GET['AMBU'];
    $fire = $_GET['FIR'];
    $lat = $_GET['LAT'];
    $lon = $_GET['LONG'];
    $landmark = $_GET['LAND'];
    $des = $_GET['DES'];
    $imei = $_GET['imei'];

    $conn = new mysqli($host, $user, $password, $db);
    
    if ($conn->connect_error)
    {
        die("Connection error: " . $conn->connect_error);
    }

    $sql = "INSERT INTO emergency (police,ambulance,firebrigade,lat,lon,landmark,description,status,np,na,nf,imei)
    VALUES ($police, $ambulance, $fire, $lat, $lon, $landmark, $des, 'UNATTENDED',0,0,0,$imei)";

    if ($conn->query($sql) === TRUE)
    {
?>
        <body><h1 style="font-size:20vw;word-wrap: break-word;">Your report has been submitted successfully!</h1></body>
<?php
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>
</html>