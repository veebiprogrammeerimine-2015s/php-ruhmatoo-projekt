<?php include(__DIR__ . '/_partials/header.php'); ?>

<?php
/**
 * @var $this App\App
 */
$stmt = $this->pdo->prepare("SELECT p.name AS 'product_name', p.price AS 'product_price', s.name " .
    "AS 'store' FROM `product`AS p LEFT JOIN store s ON(s.id = p.store_id)");

$stmt->execute();

$rawResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
$results = [];
if (count($rawResults) > 0) {
    //Mapime andmed eraldi massiivi, et neid saaks sealt poodide kaupa välja lugeda
    foreach ($rawResults as $result) {
        $results[$result['store']][] = $result;
    }

    foreach ($results as $result) {
        ?>
        <div class="row">
            <ul class="list-group">
                <?php
                foreach ($result as $row) {
                    ?>
                    <li class="list-group-item">
                        <span class="badge"><?= $row['product_price'] ?></span>
                        <?= $row['product_name'] ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }

} else {
    ?>

    <div class="alert alert-danger">
        <p>Mitte midagi ei leitud..</p>
    </div>

    <?php
}


?>

<?php include(__DIR__ . '/_partials/footer.php'); ?>