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

// Validate hotel ID
if (isset($_GET['hot_id']) && is_numeric($_GET['hot_id'])) {
    $hot_id = intval($_GET['hot_id']);
} else {
    die('Invalid hotel ID.');
}

// Fetch hotel details
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

if (!$row_Recordset1) {
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

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Hotel Details</title>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
    <h2>Edit Hotel Details</h2>
    <form method="post" action="hot_edit.php?hot_id=<?php echo htmlspecialchars($hot_id); ?>">
        <div>
            <label for="hot_code">Hotel Code:</label>
            <input type="text" name="hot_code" id="hot_code" value="<?php echo htmlspecialchars($row_Recordset1['hot_code']); ?>" required>
        </div>

        <div>
            <label for="hot_name">Hotel Name:</label>
            <input type="text" name="hot_name" id="hot_name" value="<?php echo htmlspecialchars($row_Recordset1['hot_name']); ?>" required>
        </div>

        <div>
            <label for="aname">Area Name:</label>
            <input type="text" name="aname" id="aname" value="<?php echo htmlspecialchars($row_Recordset1['aname']); ?>" required>
        </div>

        <div>
            <label for="addr">Address:</label>
            <input type="text" name="addr" id="addr" value="<?php echo htmlspecialchars($row_Recordset1['addr']); ?>" required>
        </div>

        <div>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($row_Recordset1['city']); ?>" required>
        </div>

        <div>
            <label for="land">Landmark:</label>
            <input type="text" name="land" id="land" value="<?php echo htmlspecialchars($row_Recordset1['land']); ?>" required>
        </div>

        <div>
            <label for="contact">Contact:</label>
            <input type="text" name="contact" id="contact" value="<?php echo htmlspecialchars($row_Recordset1['contact']); ?>" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($row_Recordset1['email']); ?>" required>
        </div>

        <div>
            <button type="submit">Update Hotel</button>
        </div>
    </form>
</div>

</body>
</html>
