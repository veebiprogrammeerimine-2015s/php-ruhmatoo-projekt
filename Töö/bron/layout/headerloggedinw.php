  <?php
  require_once("../../../config.php");
    if(!isset($_SESSION["logged_in_userW_username"])){
    header("Location: index.php");
  }
  ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>HarriRuttas</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-144x144-precomposed.png">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

  <link rel="stylesheet" href="css/normalize.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
  <script src="js/vendor/jquery.hashchange.min.js"></script>
  <script src="js/vendor/jquery.easytabs.min.js"></script>

  <script src="js/main.js"></script>
</head>
  <body class="bg-fixed bg-1">
   <div class="main-container">
    <div class="main wrapper clearfix">
      <!-- Header Start -->
        <header id="header">
            <div id="logo">
                <h2>
                    Bowling
                </h2>
                <h4>
                   
                    <p>Tere, <?=$_SESSION["logged_in_userW_username"];?>
                      <a href="?logout=1"> Logi välja </a>
                </h4>
            </div>
        </header>
        <!-- Header End -->
