<?php require_once('Connections/breakcon.php'); 
mysql_select_db($database_breakcon);?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "register")) {
  $insertSQL = sprintf("INSERT INTO register (name, acode, addr, contact, email, uname, pwd) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtname'], "text"),
                       GetSQLValueString($_POST['selarea'], "text"),
                       GetSQLValueString($_POST['txtaddr'], "text"),
                       GetSQLValueString($_POST['txtcont'], "text"),
                       GetSQLValueString($_POST['txtemail'], "text"),
                       GetSQLValueString($_POST['txtuname'], "text"),
                       GetSQLValueString($_POST['txtpwd'], "text"));

  mysql_select_db($database_breakcon, $breakcon);
  $Result1 = mysql_query($insertSQL, $breakcon) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_breakcon, $breakcon);
$query_Recordset1 = "SELECT * FROM area";
$Recordset1 = mysql_query($query_Recordset1, $breakcon) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
  $MM_fldUserAuthorization = "regno";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_breakcon, $breakcon);
  	
  $LoginRS__query=sprintf("SELECT uname, pwd, regno FROM register WHERE uname=%s AND pwd=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $breakcon) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'regno');
    
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
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>

</head>
  <body>
<div class="well" style="background-color:#ABA2FF;color:#000132;font-family: Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif;letter-spacing:2px;font-size:25px">SMART SERVICE NAVIGATION SYSTEM </div>
<div class="container-fluid" style="margin-top:-21px">
</div>
<br>

<div class="container-fluid">
 
 
  <div class="row">
    <div class="col-md-6" >
     <form action="<?php echo $editFormAction; ?>" method="POST" name="register" id="register">
<br>
<br>
     <div class="row">
     <div class="col-md-2"></div>
      <div class="col-md-6"><h1> Create My Account</h1><br></div></div>
    <br>
    
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Name</label>
         
      </div>
      <div class="col-md-5">
     <input type="text" class="form-control" id="txtname" name="txtname" required placeholder="Enter your Name" autocomplete="off" pattern=".{1,20}" title="Name should not exceed 20 characters." maxlength="20" />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>

     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Location</label>
         
      </div>
      <div class="col-md-5">
    <select class="form-control" id="selarea" name="selarea" required  autocomplete="off">
    <?php do {?>
      <option value="<?php echo $row_Recordset1['acode']; ?>"><?php echo $row_Recordset1['aname']; ?></option>
      <?php } while($row_Recordset1 = mysql_fetch_assoc($Recordset1));?>
    </select>
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
  
 
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Address</label>
         
      </div>
      <div class="col-md-5">
     <textarea class="form-control" name="txtaddr" id="txtaddr" placeholder="Enter Address"></textarea>
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
 
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Contact</label>
         
      </div>
      <div class="col-md-5">
      <input type="text" class="form-control" id="txtcont" name="txtcont" placeholder="Enter your Contact" required autocomplete="off" pattern="^\+91\d{10}$" title="Contact number must start with +91 and be followed by exactly 10 digits" maxlength="13" />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
 
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Email</label>
         
      </div>
      <div class="col-md-5">
      <input type="text" class="form-control" id="txtemail" name="txtemail" required autocomplete="off" placeholder="Enter your Email"  />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>

       <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Username</label>
         
      </div>
      <div class="col-md-5">
      <input type="text" class="form-control" id="txtuname" name="txtuname" required autocomplete="off" placeholder="Enter your Username" pattern=".{1,8}" title="Username must not exceed 8 characters" maxlength="8" />


      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
       <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Password</label>
         
      </div>
      <div class="col-md-5">
     <input type="password" class="form-control" id="txtpwd" name="txtpwd" required autocomplete="off" placeholder="Enter your Password" pattern=".{1,12}" title="Password must be between 1 and 12 characters" maxlength="12" />

      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
      
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-5">
      <input type="submit" class="btn btn-primary" value="Register" id="btsubmit" name="btsubmit" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
     <input type="hidden" name="MM_insert" value="register">
     </form>
    </div>
    <div class="col-md-6">
   
    <br>
<br>
 <br>
<br>
 <br>
<br>
<br>
 <br>
<br>
 <div class="well" id="we" name="we">
 <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="signin" id="signin">
     <div class="row">
     <div class="col-md-1"></div>
      <div class="col-md-8"><h1> Already have an Account</h1><br></div></div>
    <br>
    
      <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>User Name</label>
         
      </div>
      <div class="col-md-5">
      <input type="text" class="form-control" id="txtuname" name="txtuname" required autocomplete="off" placeholder="Enter your Username" pattern=".{1,8}" title="Username must not exceed 8 characters" maxlength="8" />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
        <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">
      <label>Password</label>
         
      </div>
      <div class="col-md-5">
       <input type="password" class="form-control" id="txtpwd" name="txtpwd" required autocomplete="off" placeholder="Enter your Password" pattern=".{1,12}" title="Password must not exceed 12 characters" maxlength="12" />
      </div>
      <div class="col-md-3"></div>
  </div>
      <br>
     <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-2">  
      </div>
      <div class="col-md-5">
      <input type="submit" class="btn btn-warning" value="Signin" id="btsubmit" name="btsubmit" required/>
      </div>
      <div class="col-md-2"></div>
      </div>
    </form>
   </div>
    </div>
  </div>
</div>

    
    
    

    
    
    
    
    
    
    
    
        
</body>
    
</html>
<?php
mysql_free_result($Recordset1);
?>
