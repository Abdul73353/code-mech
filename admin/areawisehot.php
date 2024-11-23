
<?php require_once('../Connections/breakcon.php'); 
session_start();
?>
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
$query_Recordset2 = "SELECT * FROM hotel,register where hotel.acode=register.acode";
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
    <div class="well" >
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-3">
          <label>Select Your Location</label>
        </div>
        <div class="col-md-5">
        <select id="selectlocation" name="selectlocation" class="form-control">  
		
		<option value="<?php $row_rs_regis['acode']?>" >Selected location is - <?php echo $row_rs_regis['aname']; ?></option>
		
		<?php do { ?>
        <option value="<?php echo $row_rs_area['acode']; ?>"><?php echo $row_rs_area['aname']; ?></option>
        <?php }while($row_rs_area = mysql_fetch_assoc($rs_area));?>
       </select>
        </div>
        <div class="col-md-3"></div>
      </div>
      <br>
       </div>
  
  <div class="fillres">
   

    <div class="row">
    

    <div class="col-md-12">
      <table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
         
          <th>Hotel Code</th>
                                    <th>Location Id</th>
                                    <th>Hospital Name</th>
                                    <th>Address</th>
                                    <th>Landmark</th>
                                    <th>Contact</th>
                                    <th>Email</th>
           
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
          <td><?php echo htmlspecialchars($row_Recordset2['hot_code']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['aname']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['hot_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['addr']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['land']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['contact']); ?></td>
                                        <td><?php echo htmlspecialchars($row_Recordset2['email']); ?></td>
          <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
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
  
        url:"../loadloc3.php",
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
?>
