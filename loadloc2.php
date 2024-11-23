<?php 
require_once('Connections/breakcon.php'); 

// Make sure database connection is selected
mysql_select_db($database_breakcon);

// Initialize the acode variable
$acode = isset($_REQUEST['acode']) ? $_REQUEST['acode'] : "";

// Check if acode is not empty before running the query
if(!empty($acode)){
    // Prepare the query to fetch hospital and area details based on the selected location
    $query = "SELECT * FROM hospital, area WHERE hospital.acode = '" . mysql_real_escape_string($acode) . "' AND hospital.acode = area.acode";
    
    // Execute the query
    $rsmat = mysql_query($query, $breakcon) or die("Error: " . mysql_error());
    
    // Fetch the first row of results
    $row_rsmat = mysql_fetch_assoc($rsmat);
    
    // Get the total number of rows returned
    $totalRows_rsmat = mysql_num_rows($rsmat);
    
    // If there are no results, you may want to show a message
    if ($totalRows_rsmat > 0) {
?>
    <div class="fillres">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <thead> 
                        <tr style="background-color:#DC0002;color:#FFFFFF">
                            <th>Hospital Code</th>
                            <th>Doctor Name</th>
                            <th>Location Id</th>
                            <th>Hospital Name</th>
                            <th>Address</th>
                                 <th>Landmark</th>
                            <th>Contact</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    // Loop through all the records and display them
                    do { ?>
                        <tr>
                            <td><?php echo $row_rsmat['hspt_code']; ?></td>
                            <td><?php echo $row_rsmat['doc_name']; ?></td>
                            <td><?php echo $row_rsmat['acode']; ?></td>
                            <td><?php echo $row_rsmat['hspt_name']; ?></td>
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
<?php 
    } else {
        echo "<div class='alert alert-warning'>No records found for the selected location.</div>";
    }
}
?>
