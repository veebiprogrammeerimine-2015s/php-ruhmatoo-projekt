<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
		<!--<link href="styles/style.css" rel="stylesheet">-->
    <!-- Bootstrap -->

      <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/php-ruhmatoo-projekt/css/bootstrap.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!--<link href="css/bootstrap-theme.css" rel="stylesheet">-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
	<body>
	<?php require_once ("inc/functions.php"); ?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <?php if ($page_file == "index.php"): ?>
	   <script type="text/javascript" src="js/bootstrap.js"></script>
  <?php else: ?>
     <script type="text/javascript" src="../js/bootstrap.js"></script>
  <?php endif; ?>
  <div id="header">
  <div class="logoback">
    <a href="<?=$myurl; ?>index.php">
      <?php if ($page_file == "index.php"): ?>
        <img src="images/logo.png" alt="logo">
      <?php else: ?>
        <img src="../images/logo.png" alt="logo">
      <?php endif; ?>
    </a>
  </div>

  <!--<div id="adresponsive">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-7">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-3787642905048568"
         data-ad-slot="3786857934"
         data-ad-format="auto"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
  <div class="col-sm-1">
  </div>
</div>-->

	<nav class="navbar navbar-default" style="box-shadow: 1px 0px 5px 0px #000; border: 0px;">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button id="toggledrop" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!--<div class="col-xs-8 col-md-3">
					<a class="navbar-brand">
            <div class="logoback">
              <a href="<?=$myurl; ?>index.php">
                <?php if ($page_file == "index.php"): ?>
                  <img src="images/logo.png" alt="logo">
                <?php else: ?>
                  <img src="../images/logo.png" alt="logo">
                <?php endif; ?>
              </a>
            </div>-->
				</div>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!--<div class="navbar-right col-sm-7 col-md-8"><?php require_once("content/login.php"); ?></div>-->
				<div class="col-sm-12"><?php require_once("menu.php"); ?>
				</div>
			</div><!-- /.navbar-collapse -->
		<!--</div> /.container-fluid -->
	</nav>
  <div id="ad">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- test728 -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-3787642905048568"
         data-ad-slot="5263591130"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

</div>
<script>

  $(document).ready(function(){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

    if(width > 767) {

      $('#toggledrop').click( function() {

          if($("#movingit").hasClass("isDown")) {
            $("#movingit").animate({marginTop: "0px"}, 300, "linear");
            $("#movingit").toggleClass("isDown");
          } else {
            $("#movingit").animate({marginTop: "315px"}, 250, "linear");
            $("#movingit").toggleClass("isDown");
          }

        });

    }

  });


</script>
	<div id="movingit" class="container">
