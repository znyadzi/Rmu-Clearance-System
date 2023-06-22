<?php
// Check if the table_id parameter is set
if (isset($_GET['table_id'])) {
    // Retrieve the table_id value
    $tableId = $_GET['table_id'];

    // Perform necessary input validation and security checks before executing the query

    // Connect to your database
    include "datacon.php";

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM departmental_logs WHERE table_id = '$tableId'";
    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        echo "Departmental log entry deleted successfully";
    } else {
        // Deletion failed
        echo "Error deleting departmental log entry: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case when the table_id parameter is not set
    echo "Invalid request";
}
?>
