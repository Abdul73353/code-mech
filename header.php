<?php require_once('Connections/breakcon.php'); ?>
<?php require_once('Connections/breakcon.php'); ?>
<?php if (!isset($_SESSION)) {
  session_start();
}
require_once('Connections/breakcon.php'); ?>
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

$colname_rs_user = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rs_user = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_breakcon, $breakcon);
$query_rs_user = sprintf("SELECT * FROM register WHERE regno = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $breakcon) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);$colname_rs_user = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rs_user = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_breakcon, $breakcon);
$query_rs_user = sprintf("SELECT * FROM register WHERE regno = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $breakcon) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mechanic Service</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">
        <script src="/js/jquery-1.11.3.min.js"></script>
<script src="/js/bootstrap.js"></script>
  </head>
<body>
<div class="well" style="background-color:#ABA2FF;color:#000132;font-family: Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif;letter-spacing:2px;font-size:25px">SMART SERVICE NAVIGATION SYSTEM</div>
<div class="container-fluid" style="margin-top:-21px">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#inverseNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        <a class="navbar-brand" href="home.php"><span class="glyphicon glyphicon-home"></span>	</a></div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="inverseNavbar1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="Home.php">Nearby Workshops<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="Home1.php">Nearby Hospitals<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="Home2.php">Nearby Hotels<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="service_book.php">Service Booking</a></li>
           <li class="active"><a href="prev_book.php">My Previous Bookings</a></li>
           <li class="active"><a href="vhspt.php">VHospital</a></li>
           <li class="active"><a href="vhot.php">VHotel</a></li>
          <li class="active"><a href="feedback.php">Feedback</a></li>
        
   
        </ul>
     
        <ul class="nav navbar-nav navbar-right">
          
          <li><a href="changepwd.php">Change Password</a></li>
          <li><a href="index.php">Logout</a></li>
          <li><a href="#">Welcome <?php echo $row_rs_user['name']; ?>!</a></li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</div>
</body>
</html>
<?php
mysql_free_result($rs_user);
?>
