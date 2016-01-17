<?php if (isset($_SESSION['login']) != true) {
    exit("Forbidden");
} ?>
<?php include(__DIR__ . '/_partials/header.php'); ?>
    <div class="row">
        <h4>Pood: <?= ucfirst($_SESSION['owner_name']) ?></h4>
        <hr/>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Töötajad</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                        /**
                         * @var $this App\App
                         */
                        $stmt = $this->pdo->prepare("SELECT e.name, e.profession FROM employee as e LEFT JOIN store s " .
                            "ON(s.id = e.store_id) LEFT JOIN owner o ON(o.id = s.owner_id) WHERE o.id =:owner_id");
                        $stmt->execute([':owner_id' => $_SESSION['owner']]);
                        $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (count($workers) > 0) {
                            foreach ($workers as $worker) {
                                ?>
                                <li class="list-group-item">
                                    <span class="badge"><?= ucfirst($worker['profession']) ?></span>
                                    <?= $worker['name'] ?>
                                </li>
                                <?php
                            }

                        } else {
                            ?>
                            <li class="list-group-item">
                                Töötajaid ei ole
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Tooted</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                        /**
                         * @var $this App\App
                         */
                        $stmt = $this->pdo->prepare("SELECT p.name as 'product_name', p.price as 'product_price' FROM " .
                            "product AS p LEFT JOIN store s ON(s.id = p.store_id) LEFT JOIN owner o ON(o.id = s.owner_id) WHERE o.id = :owner_id");
                        $stmt->execute([':owner_id' => $_SESSION['owner']]);
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (count($products) > 0) {
                            foreach ($products as $product) {
                                ?>
                                <li class="list-group-item">
                                    <span class="badge"><?= ($product['product_price']) ?> €</span>
                                    <?= $product['product_name'] ?>
                                </li>
                                <?php
                            }

                        } else {
                            ?>
                            <li class="list-group-item">
                                Tooteid ei ole
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Kliendid</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                        /**
                         * @var $this App\App
                         */
                        $stmt = $this->pdo->prepare("SELECT DISTINCT(c.name), COUNT(DISTINCT(c.name)) as 'count' FROM product AS p LEFT JOIN store s " .
                            "ON(s.id = p.store_id) LEFT JOIN owner o ON(o.id = s.owner_id) LEFT JOIN invoice i " .
                            "ON(i.product_id = p.id) LEFT JOIN client c ON (c.id = i.client_id) WHERE o.id = :owner_id");
                        $stmt->execute([':owner_id' => $_SESSION['owner']]);
                        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($clients[0]['count'] > 0) {
                            foreach ($clients as $client) {
                                ?>
                                <li class="list-group-item">
                                    <?= $client['name'] ?>
                                </li>
                                <?php
                            }

                        } else {
                            ?>
                            <li class="list-group-item">
                                Kliente ei ole
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	
	<div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">Töötaja sisestamine</h4>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
	<form method="post"><input name="add_worker"placeholder="töötaja nimi"/> 
	<input name="profession" placeholder="eriala"/>
	<input name="store_id" placeholder="kauplus"/>
	<input type="submit" value="Lisa" /></form>
<?php
$add_worker ="";
$profession = "";
$store_id ="";
$stmt = $this->pdo->prepare("INSERT INTO employee (id, name, profession, store_id) VALUES(NULL, :name, :profession, :store_id)");
$stmt->execute([
':name' => $add_worker,
':profession' => $profession,
':store_id' => (int)$store_id
]);
?>
                  </ul>
                </div>
            </div>
        </div>
    </div>
<div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">Toote sisestamine</h4>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
	<form method="post"><input name="add_product"placeholder="toode"/> 
	<input name="name" placeholder="toote nimi"/>
	<input name="price" placeholder="toote hind"/>
	<input type="submit" value="Lisa" /></form>
<?php
$add_product ="";
$name = "";
$price ="";
$stmt = $this->pdo->prepare("INSERT INTO product (id, store_id, name, price) VALUES(NULL, :name, :price)");
$stmt->execute([
':name' => $add_product,
':name' => $name,
':price' => (int)$price
]);
?>
                  </ul>
                </div>
            </div>
        </div>
    </div>
	
<?php include(__DIR__ . '/_partials/footer.php'); ?>