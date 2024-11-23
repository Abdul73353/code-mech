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
    if (isset($_POST['hot_code'], $_POST['aname'], $_POST['hot_name'], $_POST['addr'], $_POST['land'], $_POST['contact'], $_POST['email'])) {
        $hot_code = $_POST['hot_code'];
        $aname = $_POST['aname'];
        $hot_name = $_POST['hot_name'];
        $addr = $_POST['addr'];
        $land = $_POST['land'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];

        $updateSQL = "UPDATE hotel SET 
            hot_code = ?, 
            aname = ?, 
            hot_name = ?, 
            addr = ?, 
            land = ?, 
            contact = ?, 
            email = ? 
            WHERE hot_id = ?";

        $stmt = $mysqli->prepare($updateSQL);

        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        $stmt->bind_param('sssssssi', $hot_code, $aname, $hot_name, $addr, $land, $contact, $email, $hot_id);
        $stmt->execute();

        if ($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }

        // Redirect after successful update
        header('Location: hot_list.php');
        exit();
    } else {
        die("Missing form data.");
    }
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
    <title>Edit Hotel</title>
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
                Update Hotel Details
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <br>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?hot_id=$hot_id"; ?>">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hot_code">Hotel Code:</label>
                    <input type="text" class="form-control" id="hot_code" name="hot_code" value="<?php echo htmlspecialchars($row_Recordset1['hot_code']); ?>" required>
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
                    <label for="hot_name">Hotel Name:</label>
                    <input type="text" class="form-control" id="hot_name" name="hot_name" value="<?php echo htmlspecialchars($row_Recordset1['hot_name']); ?>" required>
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
                <a href="hot_list.php" class="btn btn-default">Cancel</a>
            </div>
            <div class="col-md-3"></div>
        </div>
    </form>
</div>

</body>
</html>
