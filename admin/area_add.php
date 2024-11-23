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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmroute")) {
  $insertSQL = sprintf("INSERT INTO area (acode, aname) VALUES (%s, %s)",
                       GetSQLValueString($_POST['txtacode'], "text"),
                       GetSQLValueString($_POST['txtarea'], "text"));

  mysql_select_db($database_breakcon, $breakcon);
  $Result1 = mysql_query($insertSQL, $breakcon) or die(mysql_error());

  $insertGoTo = "area_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mechanic Service</title>
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
  <?php include "header.php" ?><body>
<br><br><br><br>
  <div class ="row">
  <div class="col-md-2">
</div>

  <div class="col-md-8">
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Add Location Details</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
<form action="<?php echo $editFormAction; ?>" name="frmroute" method="POST">
   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-1">
      <label>Location Id</label>
         
      </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtacode" name="txtacode" required autocomplete="off"   />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-1">
      <label>Location Name</label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtarea" name="txtarea" required  autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
     
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-4">
      <input type="submit" class="btn btn-primary" value="Add Area" id="btsubmit" name="btsubmit" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
    <br>
    <input type="hidden" name="MM_insert" value="frmroute">
</form> 
  
  
  
</body>
</html>