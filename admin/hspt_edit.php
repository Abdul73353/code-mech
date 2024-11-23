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
if (isset($_GET['hid']) && is_numeric($_GET['hid'])) {
    $hspt_id = intval($_GET['hid']);
} else {
    die('Invalid hospital ID.');
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

if (!$row_Recordset1) {
    die("No hospital found with ID $hspt_id.");
}

// Fetch areas
$query_areas = "SELECT * FROM area ORDER BY aname ASC";
$areas = $mysqli->query($query_areas);

if ($areas === false) {
    die("Query failed: " . $mysqli->error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hspt_code = $_POST['hspt_code'];
    $doc_name = $_POST['doc_name'];
    $aname = $_POST['aname']; // Ensure this is the correct column name
    $hspt_name = $_POST['hspt_name'];
    $addr = $_POST['addr'];
    $land = $_POST['land'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $updateSQL = "UPDATE hospital SET 
        hspt_code = ?, 
        doc_name = ?, 
        aname = ?, 
        hspt_name = ?, 
        addr = ?, 
        land = ?, 
        contact = ?, 
        email = ? 
        WHERE hspt_id = ?";

    $stmt = $mysqli->prepare($updateSQL);

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Correct number of parameters
    $stmt->bind_param('ssssssssi', $hspt_code, $doc_name, $aname, $hspt_name, $addr, $land, $contact, $email, $hspt_id);
    $stmt->execute();

    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }

    // Redirect after successful update
    header('Location: hspt_list.php');
    exit();
}

// Close statement and connection
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Hospital</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/indexcss.css" rel="stylesheet">
    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/bootstrap.js"></script>
</head>
<body>
<?php include "header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="well well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">
                Update Hospital Details
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <br>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?hid=$hspt_id"; ?>">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
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
            </div>
            <div class="col-md-3"></div>
        </div>
    </form>
</div>

</body>
</html>
