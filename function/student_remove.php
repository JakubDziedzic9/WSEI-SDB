<?php
$PageTitle = 'Remove Student';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index_num = $_POST['index_num'] ?? '';

    if (!empty($index_num)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM students WHERE index_num = ?");
            $stmt->execute([$index_num]);

            if ($stmt->rowCount()) {
                $message = "Student with index number $index_num has been removed.";
            } else {
                $message = "No student found with index number $index_num.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please provide an index number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Student</title>
</head>
<body>
    <h1>Remove Student</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>Index Number:
            <input type="text" name="index_num" required>
        </label>
        <button type="submit">Remove Student</button>
    </form>

    <a href="student_list.php">Back to Student List</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>