<?php if (isset($_SESSION['login']) != true) {
    exit("Forbidden");
} ?>
<?php include(__DIR__ . '/_partials/header.php'); ?>
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

                        print_r($workers);

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
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge">14</span>
                    Cras justo odio
                </li>
                <li class="list-group-item">
                    <span class="badge">2</span>
                    Dapibus ac facilisis in
                </li>
                <li class="list-group-item">
                    <span class="badge">1</span>
                    Morbi leo risus
                </li>
            </ul>
        </div>

        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge">14</span>
                    Cras justo odio
                </li>
                <li class="list-group-item">
                    <span class="badge">2</span>
                    Dapibus ac facilisis in
                </li>
                <li class="list-group-item">
                    <span class="badge">1</span>
                    Morbi leo risus
                </li>
            </ul>
        </div>

    </div>

<?php include(__DIR__ . '/_partials/footer.php'); ?>