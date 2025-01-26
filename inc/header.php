<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PageTitle; ?></title>
    <?php
    $isInSubfolder = strpos($_SERVER['PHP_SELF'], '/function/') !== false;
    $basePath = $isInSubfolder ? '../' : '';
    ?>
    <link rel="stylesheet" href="<?php echo $basePath; ?>style.css">
</head>
<body>
    <div class="container">
    <header>
    <div class="header-content">
        <div class="logo-container">
            <img src="<?php echo $basePath; ?>images/logo.png" alt="Logo" class="logo">
        </div>
        <div class="title-container">
            <h1>Student Database</h1>
            <p>WSEI University</p>
            <nav>
                <a href="<?php echo $basePath; ?>index.php" class="link">Home</a>
                <a href="<?php echo $basePath; ?>function/student_add.php" class="link">Add Student</a>
                <a href="<?php echo $basePath; ?>function/student_list.php" class="link">Student List</a>
                <a href="<?php echo $basePath; ?>function/student_search.php" class="link">Search</a>
                <a href="<?php echo $basePath; ?>function/student_remove.php" class="link">Remove by Index</a>
            </nav>
        </div>
    </div>
</header>
