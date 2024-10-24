<?php
include 'db_conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $month = $_POST['month'];
    $sales_amount = $_POST['sales_amount'];

    // Calculate commission based on sales amount
    if ($sales_amount >= 1 && $sales_amount <= 2000) {
        $commission_rate = 3;
    } elseif ($sales_amount >= 2001 && $sales_amount <= 5000) {
        $commission_rate = 4;
    } elseif ($sales_amount >= 5001 && $sales_amount <= 7000) {
        $commission_rate = 7;
    } elseif ($sales_amount > 7000) {
        $commission_rate = 10;
    } else {
        $commission_rate = 0;
    }

    // Calculate commission
    $commission = ($sales_amount * $commission_rate) / 100;

    // Insert data into the database
    $sql = "INSERT INTO sales_data (name, month, sales_amount, commission) VALUES ('$name', '$month', '$sales_amount', '$commission')";
    if ($conn->query($sql) === TRUE) {
        // Display the commission summary
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Sales Commission Summary</title>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<div class='card'>";
        echo "<h2><u>Sales Commission Summary</u></h2>"; // Underline the heading
        echo "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
        echo "<p><strong>Month:</strong> " . htmlspecialchars($month) . "</p>";
        echo "<p><strong>Sales Amount:</strong> RM " . number_format($sales_amount, 2) . "</p>";
        echo "<p><strong>Sales Commission:</strong> <strong>RM " . number_format($commission, 2) . "</strong></p>"; 
        echo "<button onclick='window.history.back()'>Back to Form</button>";
        echo "</div>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "<div class='container error'><p>Error: " . $sql . "<br>" . $conn->error . "</p></div>";
    }
} else {
    echo "<div class='container error'><p>Invalid request.</p></div>";
}

$conn->close();
?>
