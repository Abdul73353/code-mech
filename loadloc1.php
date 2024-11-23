<?php require_once('Connections/breakcon.php'); 
mysql_select_db($database_breakcon);
$acode="";
$acode= isset($_REQUEST['acode'])?$_REQUEST['acode']:"";


	//if(!empty($acode)){
		 $query = "select * from mechanic,area  where mechanic.acode = '" . $acode ."' and mechanic.acode=area.acode";
		 $rsmat = mysql_query($query,$breakcon) or die("Error : ".mysql_error());
		 $row_rsmat = mysql_fetch_assoc($rsmat);
		 $totalRows_rsmat = mysql_num_rows($rsmat);
		//} 
	 
		 ?>
	     <div class="fillres">
   

    <div class="row">
    

    <div class="col-md-12">
      <table class="table table-bordered table-hover">
    
       <thead> 
           <tr style="background-color:#DC0002;color:#FFFFFF">
            <th>Mechanic Code</th>
            <th>Mechanic Name</th>
            <th>Location Id </th>
            <th>Workshop Name</th>
            <th>Address</th>
            <th>Landmark</th>
           <th>Contact</th>
           <th>Email</th>
           <th>&nbsp;</th>
           
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_rsmat['mech_code']; ?></td>
            <td><?php echo $row_rsmat['mech_name']; ?></td>
            <td><?php echo $row_rsmat['acode']; ?></td>
            <td><?php echo $row_rsmat['wrk_name']; ?></td>
            <td><?php echo $row_rsmat['addr']; ?></td>
 
            <td><?php echo $row_rsmat['land']; ?></td>
            <td><?php echo $row_rsmat['contact']; ?></td>            
            <td><?php echo $row_rsmat['email']; ?></td>
            <td><a href="service.php?sid=<?php echo $row_rsmat['mech_id']; ?>">Service Booking</a></td>
         
          </tr>
          <?php } while ($row_rsmat = mysql_fetch_assoc($rsmat)); ?>
        </tbody>
      </table>
    </div>
  
    </div>
 </div>
  


