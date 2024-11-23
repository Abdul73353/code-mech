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
$query_Recordset1 = "SELECT * FROM area";
$Recordset1 = mysql_query($query_Recordset1, $breakcon) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mechanic Service</title>
</head>
<?php include "header.php" ?>



<body>
  <br>
  <br>
  <div class ="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
  
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Location Details</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
    
    <div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-2"><a href="area_add.php" ><span class="glyphicon glyphicon-plus"></span>Add Location </a></div>
    </div>
    <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
<table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
           <td>Location Id</td>
            <td>Location Name</td>

            <td>&nbsp;</td>
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_Recordset1['acode']; ?></td>
            <td><?php echo $row_Recordset1['aname']; ?></td>
            <td align="center"><a href="area_edit.php?aid=<?php echo $row_Recordset1['areaid']; ?>"> Edit</a> | <a href="area_delete.php?aid=<?php echo $row_Recordset1['areaid']; ?>"> Delete </a></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-2"></div>
    </div>
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>