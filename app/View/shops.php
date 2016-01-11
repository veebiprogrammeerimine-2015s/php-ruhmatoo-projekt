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
    foreach ($results as $store => $result) {
        ?>
        <div class="row">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= ucfirst($store) ?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                        foreach ($result as $store => $row) {
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
            </div>
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