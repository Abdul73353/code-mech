<?php require_once('Connections/breakcon.php'); 
  mysql_select_db($database_breakcon, $breakcon);?>

<?php

$pwd="";
$pwd= isset($_REQUEST['pwd'])?$_REQUEST['pwd']:"";


	if(!empty($pwd)){
		 $query = "select * from register where pwd = '" . $pwd ."'";
		 $rsmat = mysql_query($query,$breakcon) or die("Error : ".mysql_error());
		 $row_rsmat = mysql_fetch_assoc($rsmat);
		} 
	 
		 
		 if($row_rsmat>0)
		 {
		 ?>
         
	   <div class="row check">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>New Password*</label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtsrc" name="txtsrc" required   autocomplete="off" />
      </div>
      <div class="col-md-2"></div>
      </div><?php }
	  else
	  {?>
      <div class="row check">
      <div class="col-md-3"></div>
      <div class="col-md-2">
      <label>New Password*</label> </div>
      <div class="col-md-3">
      <input type="text" class="form-control" id="txtsrc" name="txtsrc" required  disabled autocomplete="off"  />
      </div>
      <script>
	  alert("Invalid Password... Please enter Correct Password");
	  </script>
      <div class="col-md-2"></div>
      </div>
      <?php
	  }?>
		  
  

