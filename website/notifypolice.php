<?php 
    include('db_config.php');
    $emergencyId = $_GET['uniqId'];

    $conn = new mysqli($host, $user, $password, $db);
    
    if ($conn->connect_error)
    {
        die("Connection error: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM emergency where uniqueId=$emergencyId");

    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $uniqId = $row['uniqueId'];
            $dT = $row['dateTime'];
            $lat = $row['LAT'];
            $lon = $row['LONG'];
            $landmark = $row['LAND'];
            $des = $row['DES'];

            $sql = "INSERT INTO police (uniqueId,dateTime,lat,lon,landmark,description,status)
            VALUES ($uniqId, $dT, $lat, $lon, $landmark, $des, 'UNATTENDED')";

            if ($conn->query($sql) === TRUE)
            {
                $goto = 'emergency.php?uniqId=$emergencyId';
                header( "refresh:5; url=$goto" );
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }
?>