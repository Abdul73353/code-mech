<?php
require_once('../Connections/breakcon.php');
?>
<?php
// Database configuration
define('DB_SERVER', 'localhost'); // or your server name
define('DB_USERNAME', 'root');    // or your database username
define('DB_PASSWORD', '');        // or your database password
define('DB_DATABASE', 'breakdown'); // your database name
?>

<?php
// Check if 'hid' parameter is set and valid
if (isset($_GET['hid']) && is_numeric($_GET['hid'])) {
    $hspt_id = intval($_GET['hid']);
} else {
    die('Invalid hospital ID.');
}

// Connect to database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch hospital details
$query_Recordset1 = "SELECT * FROM hospital WHERE hspt_id = ?";
$stmt = $mysqli->prepare($query_Recordset1);

if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param('i', $hspt_id);
$stmt->execute();
$Recordset1 = $stmt->get_result();

if ($Recordset1 === false) {
    die("Get result failed: " . $stmt->error);
}

$row_Recordset1 = $Recordset1->fetch_assoc();

// Fetch area details for dropdown
$query_areas = "SELECT * FROM area ORDER BY aname ASC";
$areas = $mysqli->query($query_areas);

if ($areas === false) {
    die("Query failed: " . $mysqli->error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hspt_code = $_POST['hspt_code'];
    $doc_name = $_POST['doc_name'];
    $aname = $_POST['aname'];
    $hspt_name = $_POST['hspt_name'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $land = $_POST['land'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Update hospital details
    $updateSQL = "UPDATE hospital SET 
        hspt_code = ?, 
        doc_name = ?, 
        aname = ?, 
        hspt_name = ?, 
        addr = ?, 
        city = ?, 
        land = ?, 
        contact = ?, 
        email = ? 
        WHERE hspt_id = ?";
    
    $stmt = $mysqli->prepare($updateSQL);

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param('ssssssssi', $hspt_code, $doc_name, $aname, $hspt_name, $addr, $city, $land, $contact, $email, $hspt_id);
    $stmt->execute();

    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }

    header('Location: hspt_list.php');
    exit();
}

// Close connections
$stmt->close();
$mysqli->close();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Hospital</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<?php include "header.php"; ?>
<div class="container">
    <h2>Edit Hospital Details</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?hid=$hspt_id"; ?>">
        <div class="form-group">
            <label for="hspt_code">Hospital Code:</label>
            <input type="text" class="form-control" id="hspt_code" name="hspt_code" value="<?php echo htmlspecialchars($row_Recordset1['hspt_code']); ?>" required>
        </div>
        <div class="form-group">
            <label for="doc_name">Doctor Name:</label>
            <input type="text" class="form-control" id="doc_name" name="doc_name" value="<?php echo htmlspecialchars($row_Recordset1['doc_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="aname">Location:</label>
            <select class="form-control" id="aname" name="aname" required>
                <option value="">Select Location</option>
                <?php 
                while ($row_areas = $areas->fetch_assoc()) { 
                    $selected = ($row_Recordset1['aname'] == $row_areas['aname']) ? 'selected' : '';
                ?>
                    <option value="<?php echo htmlspecialchars($row_areas['aname']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($row_areas['aname']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="hspt_name">Hospital Name:</label>
            <input type="text" class="form-control" id="hspt_name" name="hspt_name" value="<?php echo htmlspecialchars($row_Recordset1['hspt_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="addr">Address:</label>
            <input type="text" class="form-control" id="addr" name="addr" value="<?php echo htmlspecialchars($row_Recordset1['addr']); ?>" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($row_Recordset1['city']); ?>" required>
        </div>
        <div class="form-group">
            <label for="land">Landmark:</label>
            <input type="text" class="form-control" id="land" name="land" value="<?php echo htmlspecialchars($row_Recordset1['land']); ?>" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($row_Recordset1['contact']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row_Recordset1['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="hspt_list.php" class="btn btn-default">Cancel</a>
    </form>
</div>
</body>
</html>

<?php
// Free results
$Recordset1->free();
$areas->free();
?>
