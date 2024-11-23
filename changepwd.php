<?php require_once('Connections/breakcon.php'); ?>
<?php require_once('Connections/breakcon.php'); ?>
<?php require_once('Connections/breakcon.php'); 
session_start();?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmroute")) {
  $updateSQL = sprintf("UPDATE register SET pwd=%s WHERE regno=%s",
                       GetSQLValueString($_POST['txtsrc'], "text"),
                       GetSQLValueString($_POST['txtaid'], "int"));

  mysql_select_db($database_breakcon, $breakcon);
  $Result1 = mysql_query($updateSQL, $breakcon) or die(mysql_error());

  $updateGoTo = "pwdack.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rschange = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rschange = $_SESSION['MM_UserGroup'];
}

mysql_select_db($database_breakcon, $breakcon);
$query_rschange = sprintf("SELECT * FROM register WHERE regno = %s", GetSQLValueString($colname_rschange, "int"));
$rschange = mysql_query($query_rschange, $breakcon) or die(mysql_error());
$row_rschange = mysql_fetch_assoc($rschange);
$totalRows_rschange = mysql_num_rows($rschange);
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
<link href="css/indexcss.css" rel="stylesheet">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>

</head>
<?php include 'header.php' ?>
<body>
<div class ="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#FD2C05">Change Password</div>
  </div>
  <div class="col-md-2"></div>
</div>
<br>
<form action="<?php echo $editFormAction; ?>" name="frmroute" method="POST">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-2">
      <label>Current Password*</label>
    </div>
    <div class="col-md-3">
      <input type="text" class="hidden" id="txtaid" name="txtaid" value="<?php echo $row_rschange['regno']; ?>"/>
      <input type="text" class="form-control" id="txtrcode" name="txtrcode" required autocomplete="off"   />
    </div>
    <div class="col-md-3"></div>
  </div>
  <br>
  <div class="row check">
    <div class="col-md-3"></div>
    <div class="col-md-2">
      <label>New Password*</label>
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" id="txtsrc" name="txtsrc" required disabled  autocomplete="off" />
    </div>
    <div class="col-md-2"></div>
  </div>
  <br>
  <br>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-2"> </div>
    <div class="col-md-4">
      <input type="submit" class="btn btn-primary" value="Update Password" id="btsubmit" name="btsubmit" required/>
    </div>
    <div class="col-md-2"></div>
  </div>
  <br>
  <input type="hidden" name="MM_update" value="frmroute">
</form>
<script>
  $('#txtrcode').change(function(e) {
  var pwd= document.getElementById('txtrcode').value;
  $.ajax({
							url:"pwdajax.php",
							type:'post',
							data:{pwd:pwd},
							success:function(result){
							$('.check').html(result);
				}
	});  
	
	
	
});
  
  
  
  
  </script>
</body>
</html>
<?php
mysql_free_result($rschange);
?>
