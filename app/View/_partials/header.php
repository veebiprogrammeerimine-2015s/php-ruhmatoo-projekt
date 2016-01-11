<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kaubamaja</title>
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
    <!-- Kaubamaja stiil -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?page=index">Kaubamaja</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?= $page == 'index' ? 'active' : null ?>"><a href="index.php?page=index">Avaleht</a></li>
                <li class="<?= $page == 'shops' ? 'active' : null ?>"><a href="index.php?page=shops">Kauplused</a></li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true): ?>
                    <li class="<?= $page == 'login' ? 'active' : null ?>">
                        <a href="index.php?page=logout">Logi välja</a>
                    </li>
                    <li class="<?= $page == 'data' ? 'active' : null ?>">
                        <a href="index.php?page=data">Andmed (Töötajad/tooted)</a>
                    </li>
                <?php else: ?>
                    <li class="<?= $page == 'login' ? 'active' : null ?>">
                        <a href="index.php?page=login">Logi sisse</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<div class="container" id="main">