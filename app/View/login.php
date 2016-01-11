<?php include(__DIR__ . '/_partials/header.php'); ?>
<?php
if (isset($username, $password)) {
    /**
     * @var $this App\App
     */
    $stmt = $this->pdo->prepare('SELECT * FROM owner WHERE username = :username AND password = :password');
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if (isset($result->username) && $result->username == $username) {

        //login = true tähendab, et kasutaja on nüüd sisse logitud
        $_SESSION['login'] = true;
        $_SESSION['owner'] = $result->id;
        //Refreshime headeriga
        header('Location: index.php?page=index');
    }
}

?>
    <form class="form-horizontal" method="post">
        <fieldset>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="username">Kasutaja</label>

                <div class="col-md-5">
                    <input id="username" name="username" placeholder="Mari445" class="form-control input-md" required=""
                           type="text">
                </div>
            </div>
            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Parool</label>

                <div class="col-md-5">
                    <input id="password" name="password" placeholder="***********" class="form-control input-md"
                           type="password">
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>

                <div class="col-md-4">
                    <button id="singlebutton" name="singlebutton" class="btn btn-info">Logi sisse!</button>
                </div>
            </div>
        </fieldset>
    </form>
<?php include(__DIR__ . '/_partials/footer.php'); ?>