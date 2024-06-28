<?php
// 1. Create a PHP file named view_feedback.php.

// 2. Establish a connection to the campaign_feedback database.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campaign_feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Data</title>
    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Feedback Data</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Feedback</th>
            <th>Rating</th>
            <th>Submission Date</th>
        </tr>
        <?php
        // Display the data in the table
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"]. "</td>";
                echo "<td>" . $row["name"]. "</td>";
                echo "<td>" . $row["email"]. "</td>";
                echo "<td>" . $row["feedback"]. "</td>";
                echo "<td>" . $row["rating"]. "</td>";
                echo "<td>" . $row["submission_date"]. "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No feedback data available.</td></tr>";
        }
        ?>
    </table>

    
    <?php
    
    $total_records = $result->num_rows;
    $records_per_page = 10;
    $total_pages = ceil($total_records / $records_per_page);

    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
    } else {
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $records_per_page;

    // Modify the SQL query to include pagination
    $sql = "SELECT * FROM feedback LIMIT $offset, $records_per_page";
    $result = $conn->query($sql);
    ?>

    <div style="text-align: center; margin-top: 20px;">
        <?php
        // Display the pagination links
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo "<a href='?page=$i' style='font-weight: bold; text-decoration: none;'>$i</a> ";
            } else {
                echo "<a href='?page=$i' style='text-decoration: none;'>$i</a> ";
            }
        }
        ?>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
