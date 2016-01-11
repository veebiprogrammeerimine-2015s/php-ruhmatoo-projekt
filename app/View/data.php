<?php if (isset($_SESSION['login']) != true) {
    exit("Forbidden");
} ?>
<?php include(__DIR__ . '/_partials/header.php'); ?>

<?php
/**
 * @var $this App\App
 */
    $stmt = $this->pdo->prepare('SELECT * FROM')

?>

<?php include(__DIR__ . '/_partials/footer.php'); ?>