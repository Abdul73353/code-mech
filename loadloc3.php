<?php require_once('Connections/breakcon.php'); 
mysql_select_db($database_breakcon);
$acode="";
$acode= isset($_REQUEST['acode'])?$_REQUEST['acode']:"";


	//if(!empty($acode)){
		 $query = "select * from hotel,area  where hotel.acode = '" . $acode ."' and hotel.acode=area.acode";
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
            <th>Hotel Code</th>
            <th>Location Id</th>
            <th>Hotel Name</th>
            <th>Address</th>
            <th>Landmark</th>
           <th>Contact</th>
           <th>Email</th>
           
          </tr>
        </thead>
        <tbody>
         <?php do { ?>
          <tr>
            <td><?php echo $row_rsmat['hot_code']; ?></td>
            <td><?php echo $row_rsmat['acode']; ?></td>
            <td><?php echo $row_rsmat['hot_name']; ?></td>
            <td><?php echo $row_rsmat['addr']; ?></td>

            <td><?php echo $row_rsmat['land']; ?></td>
            <td><?php echo $row_rsmat['contact']; ?></td>            
            <td><?php echo $row_rsmat['email']; ?></td>
         
          </tr>
          <?php } while ($row_rsmat = mysql_fetch_assoc($rsmat)); ?>
        </tbody>
      </table>
    </div>
  
    </div>
 </div>
  


