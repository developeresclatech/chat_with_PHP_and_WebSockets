<?php
session_start();

require '../vendor/autoload.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Prepare the SQL statement with a join to get usernames
$stmt = $pdo->prepare("
    SELECT messages.id, messages.message, users.username,messages.conversation_id 
    FROM messages 
    JOIN users ON messages.sender_id = users.id
");

// Execute the statement
$stmt->execute();

// Fetch all results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dataTables.dataTables.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Message List</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">User list  List</div>
                    <div class="panel-body">
                        <table class="table table-striped" id="dataId">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Check if there are results
                                if ($results) {
                                    // Output data for each row
                                    foreach ($results as $row) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>"; // Message ID
                                        echo "<td>" . htmlspecialchars($row['username']) . "</td>"; // Username column
                                        echo "<td>" . htmlspecialchars($row['message']) . "</td>"; // Message column
                                        echo "<td><a href='chat_with_user.php?conversation_id=" . htmlspecialchars($row['conversation_id']) . "' class='btn btn-primary'>Chat</a></td>"; // Chat link
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No messages found</td></tr>"; // If no messages found
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(function() {
            new DataTable('#dataId');
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$pdo = null;
?>
