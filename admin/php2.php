<?php
require_once('../Connections/breakcon.php');

// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'breakdown');

// Establishing database connection
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Turn on error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validate hospital ID
if (isset($_GET['hot_id']) && is_numeric($_GET['hot_id'])) {
    $hot_id = intval($_GET['hot_id']);
    echo "Hotel ID: " . htmlspecialchars($hot_id) . "<br>";
} else {
    die('Invalid hotel ID.');
}

// Fetch hospital details
$query_Recordset1 = "SELECT * FROM hotel WHERE hot_id = ?";
$stmt = $mysqli->prepare($query_Recordset1);

if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param('i', $hot_id);
$stmt->execute();
$Recordset1 = $stmt->get_result();

if ($Recordset1 === false) {
    die("Get result failed: " . $stmt->error);
}

$row_Recordset1 = $Recordset1->fetch_assoc();

// Debug: Print the fetched record
if ($row_Recordset1) {
    echo "Fetched Record: <br>";
    print_r($row_Recordset1);
} else {
    die("No hotel found with ID " . htmlspecialchars($hot_id) . ".");
}

// Fetch areas
$query_areas = "SELECT * FROM area ORDER BY aname ASC";
$areas = $mysqli->query($query_areas);

if ($areas === false) {
    die("Query failed: " . $mysqli->error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hot_code = $_POST['hot_code'];
    $aname = $_POST['aname'];
    $hot_name = $_POST['hot_name'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $land = $_POST['land'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $updateSQL = "UPDATE hotel SET 
        hot_code = ?, 
        aname = ?, 
        hot_name = ?, 
        addr = ?, 
        city = ?, 
        land = ?, 
        contact = ?, 
        email = ? 
        WHERE hot_id = ?";
    
    $stmt = $mysqli->prepare($updateSQL);

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param('ssssssssi', $hot_code, $aname, $hot_name, $addr, $city, $land, $contact, $email, $hot_id);
    $stmt->execute();

    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }

    // Redirect after successful update
    header('Location: hot_list.php');
    exit();
}

// Close statement and connection
$stmt->close();
$mysqli->close();
?>
