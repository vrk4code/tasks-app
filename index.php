<?php

// Connect to MySQL
$servername = "budhilsql.mysql.database.azure.com";
$username = "trainer";
$password = "Indian@1234567";
$dbname = "tasks_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add a task
if (isset($_POST['add_task'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO tasks (name) VALUES ('$name')";
    $conn->query($sql);
}

// Mark a task as completed
if (isset($_GET['task_id']) && isset($_GET['status'])) {
    $task_id = $_GET['task_id'];
    $status = $_GET['status'];
    $sql = "UPDATE tasks SET status=$status WHERE id=$task_id";
    $conn->query($sql);
}

// Delete a task
if (isset($_GET['delete_task'])) {
    $task_id = $_GET['delete_task'];
    $sql = "DELETE FROM tasks WHERE id=$task_id";
    $conn->query($sql);
}

// Retrieve all tasks
$sql = "SELECT id, name, status FROM tasks";
$result = $conn->query($sql);

// Display the tasks in an HTML table
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
</head>
<body>
    <h1>Task List</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Enter task name">
        <input type="submit" name="add_task" value="Add Task">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Task Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['status'] ? 'Completed' : 'Incomplete'; ?></td>
                <td>
                    <?php if (!$row['status']) { ?>
                        <a href="?task_id=<?php echo $row['id']; ?>&status=1">Mark as Completed</a>
                    <?php } ?>
                    <a href="?delete_task=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>