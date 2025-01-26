<footer>
    <p>&copy; <?php echo date('Y'); ?> WSEI University.</p>
    Jakub Dziedzic. 
</footer>
    </div>
    <?php
    $isInSubfolder = strpos($_SERVER['PHP_SELF'], '/function/') !== false;
    $basePath = $isInSubfolder ? '../' : '';
    ?>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
