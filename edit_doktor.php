<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit a record</title>
</head>
<body>

<?php include ("header.php"); ?>

<h2>Edit a record</h2>

<?php
// Look for a valid user ID, either through GET or POST
if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();

    // Validate FirstName
    if (empty($_POST['FirstName'])) {
        $error[] = 'You forgot to enter the First Name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
    }

    // Validate LastName
    if (empty($_POST['LastName'])) {
        $error[] = 'You forgot to enter the Last Name.';
    } else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
    }

    // Validate Specialization
    if (empty($_POST['Specialization'])) {
        $error[] = 'You forgot to enter the Specialization.';
    } else {
        $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
    }

    // Validate Password
    if (empty($_POST['Password'])) {
        $error[] = 'You forgot to enter the Password.';
    } else {
        $p = mysqli_real_escape_string($connect, trim($_POST['Password']));
    }

    // If no errors occurred
    if (empty($error)) {
        $q = "SELECT ID FROM doctor WHERE Specialization ='$s' AND ID != $id";
        $result = @mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 0) {
            $q = "UPDATE doctor SET FirstName='$n', LastName='$l', Specialization='$s', Password='$p' WHERE ID='$id' LIMIT 1";
            $result = @mysqli_query($connect, $q);

            if (mysqli_affected_rows($connect) == 1) {
                echo '<h3>The user has been edited.</h3>';
            } else {
                echo '<p class="error">The user has not been edited due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>' . mysqli_error($connect) . '<br>Query: ' . $q . '</p>';
            }
        } else {
            echo '<p class="error">The specialization has already been registered.</p>';
        }
    } else {
        // Display errors if validation fails
        echo '<p class="error">The following error(s) occurred:<br/>';
        foreach ($error as $msg) {
            echo '- ' . $msg . '<br />';
        }
        echo '</p><p>Please try again.</p>';
    }
}

// Get the doctor's information from the database
$q = "SELECT FirstName, LastName, Specialization, Password FROM doctor WHERE ID=$id";
$result = @mysqli_query($connect, $q);

if (mysqli_num_rows($result) == 1) {
    // Fetch doctor data
    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    // Create the form with the existing data
    echo '<form action="edit_doktor.php" method="post">
    <p><label class="label" for="FirstName">First Name: </label>
    <input id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="' . $row[0] . '"></p>

    <p><label class="label" for="LastName">Last Name: </label>
    <input id="LastName" type="text" name="LastName" size="30" maxlength="30" value="' . $row[1] . '"></p>

    <p><label class="label" for="Specialization">Specialization: </label>
    <input id="Specialization" type="text" name="Specialization" size="30" maxlength="30" value="' . $row[2] . '"></p>

    <p><label class="label" for="Password">Password: </label>
    <input id="Password" type="text" name="Password" size="30" maxlength="30" value="' . $row[3] . '"></p>

    <p><input id="submit" type="submit" name="submit" value="Edit"></p>
    <input type="hidden" name="id" value="' . $id . '">
    </form>';
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($connect);
?>

</body>
</html>
