<?php include(__DIR__ . '/_partials/header.php'); ?>
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