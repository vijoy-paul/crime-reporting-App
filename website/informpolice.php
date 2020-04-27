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
            $lat = $row['lat'];
            $lon = $row['lon'];
            $landmark = $row['landmark'];
            $des = $row['description'];

            
        }
    }
    $sql = "INSERT INTO police (uniqueId,dateTime,lat,lon,landmark,description,status)
            VALUES ($uniqId, '$dT','$lat', '$lon', '$landmark', '$des', 'UNATTENDED')";

            if ($conn->query($sql) === TRUE)
            {
                $updateStatus1 = "UPDATE emergency SET np=1 WHERE uniqueId=$emergencyId";
                mysqli_query($conn,$updateStatus1);
                echo "Police notified successfully. Please wait till we redirect you back to the emergency page.";
                $goto = 'emergency.php?uniqId='.$emergencyId;
                header( "refresh:5; url=$goto" );
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
?>