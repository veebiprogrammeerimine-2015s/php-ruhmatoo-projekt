<?php if (isset($_SESSION['login']) != true) {
    exit("Forbidden");
} ?>
<?php include(__DIR__ . '/_partials/header.php'); ?>

<?php include(__DIR__ . '/_partials/footer.php'); ?>