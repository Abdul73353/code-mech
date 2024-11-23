<?php
error_reporting(E_ALL & ~E_NOTICE); // Suppress NOTICE level errors

// Database connection using MySQLi
$hostname_breakcon = "localhost"; // Replace with your database host
$database_breakcon = "breakdown"; // Replace with your database name
$username_breakcon = "root"; // Replace with your database username
$password_breakcon = ""; // Replace with your database password

$breakcon = new mysqli($hostname_breakcon, $username_breakcon, $password_breakcon, $database_breakcon);

// Check connection
if ($breakcon->connect_error) {
    die("Connection failed: " . $breakcon->connect_error);
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
        // Escape special characters in a string for use in an SQL statement
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmroute")) {
    $insertSQL = sprintf(
        "INSERT INTO hospital (hspt_code, acode, doc_name, hspt_name, addr,land, contact, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['txthcode'], "text"),
        GetSQLValueString($_POST['selarea'], "text"),
        GetSQLValueString($_POST['txtdname'], "text"),
        GetSQLValueString($_POST['txthname'], "text"),
        GetSQLValueString($_POST['txtaddr'], "text"),
        GetSQLValueString($_POST['txtland'], "text"),
        GetSQLValueString($_POST['txtcont'], "text"),
        GetSQLValueString($_POST['txtemail'], "text")
    );

    if ($breakcon->query($insertSQL) === TRUE) {
        $insertGoTo = "hspt_list.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
        exit;
    } else {
        die("Error: " . $breakcon->error);
    }
}

$query_Recordset1 = "SELECT * FROM area";
$Recordset1 = $breakcon->query($query_Recordset1);

if (!$Recordset1) {
    die("Query failed: " . $breakcon->error);
}
$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;
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
<?php include "header.php"; ?>

<body>
<br>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Add Hospital Details</div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <br>
  <form action="<?php echo $editFormAction; ?>" name="frmroute" method="POST">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Hospital Code</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txthcode" name="txthcode" required autocomplete="off" />
      </div>
      <div class="col-md-3"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Doctor Name</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txtdname" name="txtdname" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Location</label>
      </div>
      <div class="col-md-3">
        <select class="form-control" id="selarea" name="selarea" required autocomplete="off">
          <?php
          while ($row_Recordset1) {
              echo "<option value=\"" . $row_Recordset1['acode'] . "\">" . $row_Recordset1['aname'] . "</option>";
              $row_Recordset1 = $Recordset1->fetch_assoc();
          }
          ?>
        </select>
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Hospital Name</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txthname" name="txthname" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Address</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txtaddr" name="txtaddr" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Landmark</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txtland" name="txtland" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Contact</label>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control" id="txtcont" name="txtcont" required autocomplete="off" maxlength="13" oninput="validateInput(this)" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
        <label>Email</label>
      </div>
      <div class="col-md-3">
        <input type="email" class="form-control" id="txtemail" name="txtemail" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2"></div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <div class="col-md-2"></div>
    </div>
    <input type="hidden" name="MM_insert" value="frmroute" />
  </form>
  <br>
  <br>
</body>
</html>

<?php
// Close the database connection
$breakcon->close();
?>
