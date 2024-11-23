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
$query_rs_prev = "SELECT * FROM service_book,mechanic,area WHERE service_book.mech_code=mechanic.mech_code and mechanic.acode=area.acode";
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
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
        <script src="js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>
  </head>
<body>
<?php include 'header.php' ?>
<br>
<br>
<div class="container">
  <form name="frmloc" id="frmloc">

   <div class="col-md-12"><h3 align="center"> Previous Bookings</h3></div>
    <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
            <th>Booking No</th>
            <th>Date</th>
            <th>Mechanic Name</th>
            <th>Workshop Name</th>
            <th>Location</th>
            <th>Registration Number</th>
            <th>Complaint</th>
           <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_rs_prev['bookno']; ?></td>
            <td><?php echo $row_rs_prev['bookdate']; ?></td>
            <td><?php echo $row_rs_prev['mech_name']; ?></td>
            <td><?php echo $row_rs_prev['wrk_name']; ?></td>
            <td><?php echo $row_rs_prev['aname']; ?></td>
            <td><?php echo $row_rs_prev['veh_regno']; ?></td>
            <td><?php echo $row_rs_prev['complaint'];?></td>
           <td><a href="response_list.php?bno=<?php echo $row_rs_prev['bookno']; ?>">Service Response
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
mysql_free_result($rs_regis);

mysql_free_result($Recordset2);

mysql_free_result($rs_prev);
?>
