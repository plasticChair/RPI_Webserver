<?php 


$numData = $_GET["numData"];
$type = $_GET["type"];


$config = parse_ini_file('/var/www/db.ini');
// Create connection
$conn = new mysqli("localhost",$config['username'],$config['password'], $config['db']);

// Check connection
if ($conn->connect_error) {
    die($conn->connect_error);
} 




$result = $conn->query("SELECT * 
							FROM ( 
									SELECT * 
									FROM mystation 
									ORDER BY 
										ID DESC 
									LIMIT $numData 
									) q 
									ORDER BY 
                                    ID ASC" );
                                    



 
if (mysqli_num_rows($result) > 0) {
  
    if ($type == "wind"){
        $data = array("Date, Wind Speed\n");
    }
    //$data = "_";
   //echo "ID	 	DateTime		TempOutCur		HumidityCur		PressOutCur		WindOutCur    WindDirOutCur<br>";
    while($row = mysqli_fetch_assoc($result)) {
    //   echo $row["ID"] . "," . $row["DateTime"] . "," . $row["TempOutCur"] . "," . $row["HumOutCur"] ."," . $row["PressOutCur"] ."," . $row["WindOutCur"] ."," . $row["WindDirOutCur"] . " <br>";
        if ($type == "wind")
        {
            //$data = $data . (string)row["WindOutCur"]."\n"; // + "," + implode("",$row["WindOutCur"]) + "\n";
            $data = implode("",array("", str_replace("-","/",(string)$row['DateTime']),",", (string)$row['WindOutCur'],"\n"));
            echo $data;
            //$data[]
           // .echo (string)$row['DateTime'];
           // echo "<br>";

        }
    
        //$data['ID'][] = $row["ID"];
        //$data['DateTime'][] = $row["DateTime"];
       // $data['Temp'][] = $row["TempOutCur"];
        //$data['Hum'][] = $row["HumOutCur"];
        //$data['Press'][] = $row["PressOutCur"];
        //$data['Wind'][] = $row["WindOutCur"];
        //$data['WindDir'][] = $row["WindDirOutCur"];
       //echo "".$row['ID']."," <br>";

    }
 }

//$json = json_encode($data);
echo implode(",",$data);

//echo $data;

//print_r($data);

$result->close();
$conn->close();

?>