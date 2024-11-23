<?php
$hostname_breakcon = "localhost";
$database_breakcon = "breakdown";
$username_breakcon = "root";
$password_breakcon = "";

// Create connection
$breakcon = new mysqli($hostname_breakcon, $username_breakcon, $password_breakcon, $database_breakcon);

// Check connection
if ($breakcon->connect_error) {
    die("Connection failed: " . $breakcon->connect_error);
} else {
    echo "Connection successful!";
}

// Function to escape SQL values and protect against SQL injection
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
    global $breakcon;
    $theValue = $breakcon->real_escape_string($theValue);

    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;    
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

// Check if the 'hspt_id' parameter is set and not empty
if (isset($_GET['hid']) && $_GET['hid'] != "") {
    $hspt_id = GetSQLValueString($_GET['hid'], "int");

    // Perform the delete operation
    $deleteSQL = "DELETE FROM hospital WHERE hspt_id=$hspt_id";
    $Result1 = $breakcon->query($deleteSQL);

    if (!$Result1) {
        die('Error: ' . $breakcon->error);
    }

    $deleteGoTo = "hspt_list.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
        $deleteGoTo .= $_SERVER['QUERY_STRING'];
    }
    header("Location: $deleteGoTo");
    exit();
}

// Fetch data from the area table
$colname_Recordset1 = "-1";
if (isset($_GET['aid'])) {
    $colname_Recordset1 = GetSQLValueString($_GET['aid'], "int");
}

$query_Recordset1 = "SELECT * FROM area WHERE areaid = $colname_Recordset1";
$Recordset1 = $breakcon->query($query_Recordset1);

if (!$Recordset1) {
    die('Error: ' . $breakcon->error);
}

$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;

$Recordset1->free();
$breakcon->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Service</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/indexcss.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="../js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="../js/bootstrap.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php include "header.php" ?>

</body>
</html>
