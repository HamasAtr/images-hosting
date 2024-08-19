<?php
// Establish database connection
$servername = "mysql-cluster-1-mysql-master.database.svc.cluster.local:3306";
$username = "linkagelearning-bf83d0";
$password = "NKxbkRp8sbjw-f7ROu52";
$dbname = "772826_3962a1db35f6393404478807c6eed879";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data sent from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Extract the values
// Retrieve the data fields
$canvas = $data['canvas'];
$webGL = $data['webGL'];
$device = $data['device'];
$browser = $data['browser'];
$timezone = $data['timezone'];
$screenResolution = $data['screenResolution'];
$userLanguage = $data['language'];

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO `fingerprints_of_user` (canvas, webgl, device, browser, timezone, screenResolution, userlanguage) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $canvas, $webGL, $device, $browser, $timezone, $screenResolution, $userLanguage);
$stmt->execute();

// Check if the insertion was successful
if ($stmt->affected_rows > 0) {
    echo "Data inserted successfully!";
} else {
    echo "Failed to insert data: " . $conn->error;
}



// Close the database connection
$stmt->close();
$conn->close();
?>
