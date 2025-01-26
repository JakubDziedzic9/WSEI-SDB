<?php
$PageTitle = 'Add Student';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $address = $_POST['address'] ?? '';
    $index_num = $_POST['index_num'] ?? '';
    $pesel = $_POST['pesel'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // Validation
    if (strlen($pesel) !== 11 || !ctype_digit($pesel)) {
        $message = "Invalid PESEL number!";
    } elseif (empty($name) || empty($surname) || empty($address) || empty($index_num) || empty($gender)) {
        $message = "All fields are required!";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (name, surname, address, index_num, pesel, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $surname, $address, $index_num, $pesel, $gender]);
            $message = "Student has been successfully added!";
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
    <title>Add Student</title>
</head>
<body>
    <h1>Add a New Student</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>First Name:
            <input type="text" name="name" required>
        </label><br>

        <label>Last Name:
            <input type="text" name="surname" required>
        </label><br>

        <label>Address:
            <input type="text" name="address" required>
        </label><br>

        <label>Index Number:
            <input type="text" name="index_num" required>
        </label><br>

        <label>PESEL:
            <input type="text" name="pesel" required>
        </label><br>

        <label>Gender:
            <select name="gender" required>
                <option value="">--Select--</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="Other">Other</option>
            </select>
        </label><br>

        <button type="submit">Add Student</button>
    </form>

    <a href="student_list.php">Back to Student List</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>