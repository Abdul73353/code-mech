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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtuname'])) {
  $loginUsername=$_POST['txtuname'];
  $password=$_POST['txtpwd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "header.php";
  $MM_redirectLoginFailed = "adminlogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_breakcon, $breakcon);
  
  $LoginRS__query=sprintf("SELECT uname, pwd FROM adminlogin WHERE uname=%s AND pwd=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $breakcon) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
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

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
  </head>
<body>
<br>
<br><br><br><br><br><br>
<div class="container">
  <div class="row">
    <div class="col-md-12" style="background-color:#FCE5C7;border-radius:10px">
    <h2 align="center"> Admin Login </h2><br>
    <br>
    <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="frmlogin" id="frmlogin" >
   <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Username</label>
      
      </div>
      <div class="col-md-4">
      <input type="text" class="form-control" id="txtuname" name="txtuname" autocomplete="off" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
      <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>Password</label></div>
      <div class="col-md-4">
      <input type="password" class="form-control" id="txtpwd" name="txtpwd" required autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
      </div>
      <br>
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-4" >
      <input type="submit" class="btn btn-primary" value="Login" id="btsubmit" name="btsubmit"  autocomplete="off" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
</form>
    
    <br>
<br><br><br>
    
    
    
    </div>
  
  </div>
</div>




</body>
</html>