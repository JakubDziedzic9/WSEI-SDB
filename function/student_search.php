<?php
$PageTitle = 'Search Students';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? '';
$address = $_GET['address'] ?? '';
$pesel_min = $_GET['pesel_min'] ?? '';
$pesel_max = $_GET['pesel_max'] ?? '';

$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "(surname LIKE ? OR pesel = ?)";
    $params[] = "%$search%";
    $params[] = $search;
}

if (!empty($gender)) {
    $conditions[] = "gender = ?";
    $params[] = $gender;
}

if (!empty($address)) {
    $conditions[] = "address LIKE ?";
    $params[] = "%$address%";
}

if (!empty($pesel_min)) {
    $conditions[] = "pesel >= ?";
    $params[] = $pesel_min;
}

if (!empty($pesel_max)) {
    $conditions[] = "pesel <= ?";
    $params[] = $pesel_max;
}

$sql = "SELECT * FROM students";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students</title>
</head>
<body>
    <h1>Search Students</h1>

    <form action="" method="get">
        <label>Search (Last Name or PESEL):
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>">
        </label><br>

        <label>Gender:
            <select name="gender">
                <option value="">--Select--</option>
                <option value="M" <?= $gender === 'M' ? 'selected' : '' ?>>Male</option>
                <option value="F" <?= $gender === 'F' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $gender === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </label><br>

        <label>Address contains:
            <input type="text" name="address" value="<?= htmlspecialchars($address) ?>">
        </label><br>

        <label>PESEL Range:</label>
        <input type="text" name="pesel_min" placeholder="From" value="<?= htmlspecialchars($pesel_min) ?>">
        -
        <input type="text" name="pesel_max" placeholder="To" value="<?= htmlspecialchars($pesel_max) ?>">
        <br>

        <button type="submit">Search</button>
    </form>

    <?php if (!empty($students)): ?>
        <h2>Search Results:</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Index Number</th>
                    <th>PESEL</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['surname']) ?></td>
                        <td><?= htmlspecialchars($student['address']) ?></td>
                        <td><?= htmlspecialchars($student['index_num']) ?></td>
                        <td><?= htmlspecialchars($student['pesel']) ?></td>
                        <td><?= htmlspecialchars($student['gender']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>

    <a href="student_list.php">Back to Student List</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>

?>
