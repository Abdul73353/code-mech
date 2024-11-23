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
$query_Recordset1 = "SELECT * FROM hospital,area where hospital.acode=area.acode";
$Recordset1 = mysql_query($query_Recordset1, $breakcon) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hospital Service</title>
</head>
<?php include "header.php" ?>



<body>
  <br>
  <br>
  <div class ="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
  
  <div class="well-sm" align="center" style="font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;font-size:18px; color:#F8F8FE;background-color:#F55BFF">Hospital Details</div>
  </div>
    <div class="col-md-2"></div></div>
    <br>
    
    <div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-2"><a href="hspt_add.php" ><span class="glyphicon glyphicon-plus"></span>Add Hospital </a></div>
    </div>
    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
     
      <table class="table table-bordered table-hover">
    
       <thead> 
          <tr style="background-color:#DC0002;color:#FFFFFF">
            <td>Hospital Code</td>
            <td>Doctor Name</td>
            <td>Location </td>
            <td>Hospital Name</td>
            <td>Address</td>
            <td>Landmark</td>
           <td>Contact</td>
           <td>Email</td>
            

            <td>&nbsp;</td>
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_Recordset1['hspt_code']; ?></td>
            <td><?php echo $row_Recordset1['doc_name']; ?></td>
            <td><?php echo $row_Recordset1['aname']; ?></td>
            <td><?php echo $row_Recordset1['hspt_name']; ?></td>
            <td><?php echo $row_Recordset1['addr']; ?></td>
            <td><?php echo $row_Recordset1['land']; ?></td>
            <td><?php echo $row_Recordset1['contact']; ?></td>            
            <td><?php echo $row_Recordset1['email']; ?></td>
            <td align="center"><a href="hspt_edit.php?hid=<?php echo $row_Recordset1['hspt_id']; ?>"> Edit</a> | 
            <a href="hspt_delete.php?hid=<?php echo $row_Recordset1['hspt_id']; ?>"> Delete </a></td>
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