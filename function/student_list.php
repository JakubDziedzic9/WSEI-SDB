<?php
$PageTitle = 'Student List';
require_once(__DIR__ . '/../inc/header.php');
require_once __DIR__ . '/../includes/db.php';

$sort = $_GET['sort'] ?? 'id';

$allowedSortColumns = ['id', 'pesel', 'surname'];
if (!in_array($sort, $allowedSortColumns)) {
    $sort = 'id';
}

$stmt = $pdo->query("SELECT * FROM students ORDER BY $sort ASC");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>
<body>
    <h1>Student List</h1>

    <div class="sort-options">
        <a href="?sort=id" class="sort-button <?= $sort === 'id' ? 'active' : '' ?>">Sort by ID</a>
        <a href="?sort=pesel" class="sort-button <?= $sort === 'pesel' ? 'active' : '' ?>">Sort by PESEL</a>
        <a href="?sort=surname" class="sort-button <?= $sort === 'surname' ? 'active' : '' ?>">Sort by Last Name</a>
    </div>

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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?= htmlspecialchars($student['id']) ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['surname']) ?></td>
                    <td><?= htmlspecialchars($student['address']) ?></td>
                    <td><?= htmlspecialchars($student['index_num']) ?></td>
                    <td><?= htmlspecialchars($student['pesel']) ?></td>
                    <td><?= htmlspecialchars($student['gender']) ?></td>
                    <td class="action-links">
                        <a href="student_edit.php?id=<?= htmlspecialchars($student['id']) ?>" class="edit-link">Edit</a>
                        <a href="student_delete.php?index_num=<?= htmlspecialchars($student['index_num']) ?>" 
                           class="delete-link"
                           onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="student_add.php">Add New Student</a>
</body>
</html>
<?php require_once(__DIR__ . '/../inc/footer.php'); ?>