<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Delete a record</title>
</head>

<body>

<?php include("header.php"); ?>  

<h2>Delete a record</h2>

<?php  
// Ensure you have a valid connection before proceeding
if (!$connect) {
    die('<p class="error">Database connection failed.</p>');
}

// Look for a valid user ID, either through GET or POST  
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['sure'] == 'Yes') { 
        // Delete the record
        $q = "DELETE FROM doctor WHERE ID='$id' LIMIT 1";  
        $result = mysqli_query($connect, $q);
        
        if (mysqli_affected_rows($connect) == 1) {
            // If the record was successfully deleted
            echo '<h3>The record has been deleted.</h3>';
        } else {
            // Display an error message if the deletion failed
            echo '<p class="error">The record could not be deleted.<br>It might not exist or there was a system error.</p>';
            echo '<p>' . mysqli_error($connect) . '<br>Query: ' . $q . '</p>';
        }
    } else {
        echo '<h3>The user has NOT been deleted.</h3>';
    }
} else {
    // Retrieve the user's data  
    $q = "SELECT FirstName FROM doctor WHERE ID = '$id'";  
    $result = mysqli_query($connect, $q);

    // Check if the query executed successfully
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Get the member's data  
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo '<h3>Are you sure you want to permanently delete ' . $row[0] . '?</h3>';
            echo '<form action="delete_doktor.php" method="post">';
            echo '<input id="submit-yes" type="submit" name="sure" value="Yes">';
            echo '<input id="submit-no" type="submit" name="sure" value="No">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '</form>';
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
        }
    } else {
        // Display an error if the query failed
        echo '<p class="error">Query failed: ' . mysqli_error($connect) . '</p>';
    }
}

mysqli_close($connect);
?>

</body>
</html>
