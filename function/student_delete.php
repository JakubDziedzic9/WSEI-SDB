<?php
$PageTitle = 'Delete Student';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

$message = "";

if (isset($_GET['index_num'])) {
    $index_num = $_GET['index_num'];

    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE index_num = ?");
        $stmt->execute([$index_num]);

        if ($stmt->rowCount()) {
            $message = "Student with index number $index_num has been deleted.";
        } else {
            $message = "No student found with index number $index_num.";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Index number not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
</head>
<body>
    <h1>Delete Student</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <a href="student_list.php">Back to Student List</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>