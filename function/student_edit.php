<?php
$PageTitle = 'Edit Student';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("Student ID not provided!");
}

$id = $_GET['id'];
$message = "";

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    die("Student with the provided ID does not exist.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $address = $_POST['address'] ?? '';
    $index_num = $_POST['index_num'] ?? '';
    $pesel = $_POST['pesel'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (strlen($pesel) !== 11 || !ctype_digit($pesel)) {
        $message = "Invalid PESEL number!";
    } elseif (empty($name) || empty($surname) || empty($address) || empty($index_num) || empty($gender)) {
        $message = "All fields are required!";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE students SET name = ?, surname = ?, address = ?, index_num = ?, pesel = ?, gender = ? WHERE id = ?");
            $stmt->execute([$name, $surname, $address, $index_num, $pesel, $gender, $id]);
            $message = "Student data has been successfully updated!";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student Information</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>First Name:
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        </label><br>

        <label>Last Name:
            <input type="text" name="surname" value="<?= htmlspecialchars($student['surname']) ?>" required>
        </label><br>

        <label>Address:
            <input type="text" name="address" value="<?= htmlspecialchars($student['address']) ?>" required>
        </label><br>

        <label>Index Number:
            <input type="text" name="index_num" value="<?= htmlspecialchars($student['index_num']) ?>" required>
        </label><br>

        <label>PESEL:
            <input type="text" name="pesel" value="<?= htmlspecialchars($student['pesel']) ?>" required>
        </label><br>

        <label>Gender:
            <select name="gender" required>
                <option value="M" <?= $student['gender'] == 'M' ? 'selected' : '' ?>>Male</option>
                <option value="F" <?= $student['gender'] == 'F' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $student['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </label><br>

        <button type="submit">Update Student</button>
    </form>

    <a href="student_list.php">Back to Student List</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>