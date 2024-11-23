<?php require_once('../Connections/breakcon.php'); ?>
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

mysql_select_db($database_breakcon, $breakcon);
$query_rs_prev = "SELECT * FROM feedback,register where feedback.regno=register.regno ";
$rs_prev = mysql_query($query_rs_prev, $breakcon) or die(mysql_error());
$row_rs_prev = mysql_fetch_assoc($rs_prev);
$totalRows_rs_prev = mysql_num_rows($rs_prev);
?>
<?php require_once('../Connections/breakcon.php'); 
session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mechanic Service</title>
    <!-- Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
        <script src="../js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="../js/bootstrap.js"></script>
  </head>
<body>
<?php include 'header.php' ?>
<br>
<br>
<div class="container">
  <form name="frmloc" id="frmloc">


  <div class ="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
  
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Feedback Details</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
   
  
    <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
            <th>Feedback No</th>
            <th>Suggestion</th>
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_rs_prev['fno']; ?></td>
            <td><?php echo $row_rs_prev['feedback']; ?></td>


           </a></td>
         
          </tr>
          <?php } while ($row_rs_prev = mysql_fetch_assoc($rs_prev)); ?>
        </tbody>
      </table>
    </div>
   
    </div>

    
    
 </div>
  
  </form>
</div>
</body>
<?php
mysql_free_result($rs_prev);
?>

</html>