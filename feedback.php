<?php require_once('Connections/breakcon.php'); ?>
<?php require_once('Connections/breakcon.php'); ?>
<?php require_once('Connections/breakcon.php');
session_start(); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
  $insertSQL = sprintf("INSERT INTO feedback (regno, feedback) VALUES (%s, %s)",
                       GetSQLValueString($_POST['txtregno'], "int"),
                       GetSQLValueString($_POST['txtfeed'], "text"));

  mysql_select_db($database_breakcon, $breakcon);
  $Result1 = mysql_query($insertSQL, $breakcon) or die(mysql_error());

  $insertGoTo = "feedback.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_Recordset1 = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_breakcon, $breakcon);
$query_Recordset1 = sprintf("SELECT * FROM register WHERE regno = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $breakcon) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mechanic Service</title>
    <!-- Bootstrap -->
	<link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/indexcss.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="/js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="/js/bootstrap.js"></script>

  </head>
<?php include "header.php" ?>
<?php
mysql_free_result($Recordset1);
?>

<body>
<br>
  <div class ="row">
  <div class="col-md-2">
</div>

  <div class="col-md-8">
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Feedback
  </div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
<form action="<?php echo $editFormAction; ?>" name="frmroute" method="POST">
   <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Your Suggesstion</label>
         
      </div>
      <div class="col-md-3">
     <input type="text" class="form-control hidden" id="txtregno" name="txtregno" required value="<?php echo $row_Recordset1['regno']; ?> "     />
<textarea name="txtfeed" id="txtfeed" class="form-control"></textarea>
      </div>
      <div class="col-md-3"></div>
  </div>
    
  <br> 
      
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-4">
      <input type="submit" class="btn btn-primary" value="Post" id="btsubmit" name="btsubmit" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
    <br>
    <input type="hidden" name="MM_insert" value="frmroute">
</form> 
  
  
  
</body>
</html>