<?php require_once('/Connections/breakcon.php'); ?>
<?php
session_start();
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
  $insertSQL = sprintf("INSERT INTO service_book (regno, mech_code, veh_regno, complaint) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtregno'], "int"),
                       GetSQLValueString($_POST['txtmcode'], "text"),
                       GetSQLValueString($_POST['txtvregno'], "text"),
                       GetSQLValueString($_POST['txtcomplaint'], "text"));

  mysql_select_db($database_breakcon, $breakcon);
  $Result1 = mysql_query($insertSQL, $breakcon) or die(mysql_error());

  $insertGoTo = "book_ack.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_breakcon, $breakcon);
$query_rs_area = "SELECT * FROM area";
$rs_area = mysql_query($query_rs_area, $breakcon) or die(mysql_error());
$row_rs_area = mysql_fetch_assoc($rs_area);
$totalRows_rs_area = mysql_num_rows($rs_area);
$query_rs_area = "SELECT * FROM area";
$rs_area = mysql_query($query_rs_area, $breakcon) or die(mysql_error());
$row_rs_area = mysql_fetch_assoc($rs_area);
$totalRows_rs_area = mysql_num_rows($rs_area);

$colname_Recordset2 = "-1";
if (isset($_GET['sid'])) {
  $colname_Recordset2 = $_GET['sid'];
}
mysql_select_db($database_breakcon, $breakcon);
$query_Recordset2 = sprintf("SELECT * FROM mechanic,area WHERE mech_id = %s and mechanic.acode=area.acode", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $breakcon) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
  </head>
<?php include "header.php" ?>

<body>
<br>
  <div class ="row">
  <div class="col-md-2">
</div>

  <div class="col-md-8">
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Service Booking</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
<form action="<?php echo $editFormAction; ?>" name="frmroute" method="POST">
   <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Mechanic Code</label>
         
      </div>
      <div class="col-md-3">
     <input type="text" class="form-control hidden" id="txtmid" name="txtmid" required   value="<?php echo $row_Recordset2['mech_id']; ?>"  />
     <input type="text" class="form-control" id="txtmcode" name="txtmcode" required   value="<?php echo $row_Recordset2['mech_code']; ?>"  />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
      <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Mechanic Name</label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtmname" name="txtmname" required   value="<?php echo $row_Recordset2['mech_name']; ?>" />
     <input type="text" class="hidden" id="txtregno" name="txtregno" required   value="<?php echo $_SESSION['MM_UserGroup']?>" />
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
      
       <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Location Name</label> </div>
      <div class="col-md-3">
      <select class="form-control" id="selarea" name="selarea" required  autocomplete="off">
      <option value="<?php echo $row_Recordset2['acode']; ?>"><?php echo $row_Recordset2['aname']; ?></option>
	  <?php  do {?>
      <option value="<?php echo $row_rs_area['acode']; ?>"><?php echo $row_rs_area['aname']; ?></option>
     <?php }while($row_rs_area = mysql_fetch_assoc($rs_area)); ?>
      </select>
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
       <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Workshop Name</label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtwname" name="txtwname" required  autocomplete="off" value="<?php echo $row_Recordset2['wrk_name']; ?>" />
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
       <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Vehicle Registration No. </label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtvregno" name="txtvregno" required />
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
       <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Complaint</label> </div>
      <div class="col-md-3">
    <textarea name="txtcomplaint" id="txtcomplaint" class="form-control" rows="4"></textarea>
      </div>
      <div class="col-md-2"></div>
      </div>
      <br> 
      
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-4">
      <input type="submit" class="btn btn-primary" value="Book Complaint" id="btsubmit" name="btsubmit" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
    <br>
    <input type="hidden" name="MM_update" value="frmroute">
    <input type="hidden" name="MM_insert" value="frmroute">
</form> 
  
  
  
</body>
<?php
mysql_free_result($rs_area);

mysql_free_result($Recordset2);
?>

</html>