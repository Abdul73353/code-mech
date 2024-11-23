<?php require_once('../Connections/breakcon.php'); ?>
<?php require_once('../Connections/breakcon.php'); ?>
<?php require_once('../Connections/breakcon.php'); 
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

mysql_select_db($database_breakcon, $breakcon);
$query_rs_area = "SELECT * FROM area";
$rs_area = mysql_query($query_rs_area, $breakcon) or die(mysql_error());
$row_rs_area = mysql_fetch_assoc($rs_area);
$totalRows_rs_area = mysql_num_rows($rs_area);

$colname_rs_regis = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rs_regis = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_breakcon, $breakcon);
$query_rs_regis = sprintf("SELECT * FROM register,area WHERE regno = %s and register.acode=area.acode", GetSQLValueString($colname_rs_regis, "int"));
$rs_regis = mysql_query($query_rs_regis, $breakcon) or die(mysql_error());
$row_rs_regis = mysql_fetch_assoc($rs_regis);
$totalRows_rs_regis = mysql_num_rows($rs_regis);

mysql_select_db($database_breakcon, $breakcon);
$query_Recordset2 = "SELECT * FROM mechanic,register where mechanic.acode=register.acode";
$Recordset2 = mysql_query($query_Recordset2, $breakcon) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_breakcon, $breakcon);
$query_rs_prev = "SELECT * FROM service_book, service_response,register WHERE service_book.bookno=service_response.bno and service_book.regno=register.regno";
$rs_prev = mysql_query($query_rs_prev, $breakcon) or die(mysql_error());
$row_rs_prev = mysql_fetch_assoc($rs_prev);
$totalRows_rs_prev = mysql_num_rows($rs_prev);
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
  
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Response Details</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
   
  
    <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
            <th>Response No</th>
            <th>Date</th>
            <th>Booking No.</th>
            <th>Customer Name</th>
            <th>Service Description</th>
            <th>Service Cost</th>

          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_rs_prev['resno']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($row_rs_prev['serdate'])); ?></td>
            <td><?php echo $row_rs_prev['bno']; ?></td>
            <td><?php echo $row_rs_prev['uname']; ?></td>
            <td><?php echo $row_rs_prev['ser_desc']; ?></td>
            <td><?php echo $row_rs_prev['ser_cost']; ?></td>


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
<script>
$('#selectlocation').change(function(e) {
    
	var acode=document.getElementById('selectlocation').value;

$.ajax({

			url:"loadloc1.php",
			type:'post',
			data:{acode:acode},
			success:function(result){
			$('.fillres').html(result);
			}


});

	
	
});



</script>





</body>
</html>
<?php
mysql_free_result($rs_area);

mysql_free_result($rs_regis);

mysql_free_result($Recordset2);

mysql_free_result($rs_prev);
?>
