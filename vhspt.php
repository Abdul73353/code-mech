<?php
include "header.php";
// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "breakdown"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch all records from the hospital table
$sql = "SELECT * FROM hospital";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo "<h2>View Hospitals</h2>";
    echo "<div class='table-container'>
            <table>
                <tr>
                    <th>HSPT ID</th>
                    <th>HSPT Code</th>
                    <th>Location id</th>
                    <th>Doctor Name</th>
                    <th>Hospital Name</th>
                    <th>Address</th>

                    <th>Landmark</th>
                    <th>Contact</th>
                    <th>Email</th>
                </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["hspt_id"] . "</td>
                <td>" . $row["hspt_code"] . "</td>
                <td>" . $row["acode"] . "</td>
                <td>" . $row["doc_name"] . "</td>
                <td>" . $row["hspt_name"] . "</td>
                <td>" . $row["addr"] . "</td>
               
                <td>" . $row["land"] . "</td>
                <td>" . $row["contact"] . "</td>
                <td>" . $row["email"] . "</td>
              </tr>";
    }

    echo "</table></div>";
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>
<style>
    /* Center the table container */
    .table-container {
        width: 80%;
        margin: 0 auto; /* Centers the div horizontally */
        padding: 2px;
        text-align: center;
    }

    /* Style the table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #f9f9f9; /* Light background color */
    }

    th, td {
        border: 1px solid #ddd; /* Light gray border */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #e8170c; /* Green background for headers */
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2; /* Zebra striping */
    }

    tr:hover {
        background-color: #ddd; /* Highlight on hover */
    }
    h2{
        text-align: center;

    }
</style>
