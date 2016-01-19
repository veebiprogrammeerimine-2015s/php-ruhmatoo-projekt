<?php

	$page_title = "Uudised";
	$page_file = "news.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");
?>
<?php

  $categories = $Misc->getCategories();

  $cat = 0;
	if (isset($_GET["category"])) {
		$cat = cleanInput($_GET["category"]);

		$news = $Misc->getNews($cat);
	} else {
		$news = $Misc->getNews();
	}


?>


<div class="col-xs-12 col-sm-8">
  <?php if(!isset($_GET['id'])): ?>
    <h3 id="statbar">
      <a href="news.php" style="color: #333;">Uudised</a>
      <?php
      if(isset($_SESSION['logged_in_user_id'])):
        if($_SESSION['logged_in_user_group'] == 3):
      ?>
      <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#addnews">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Uus
      </button>
      <?php
        endif;
      endif;
      ?>
    </h3>
    <?php
        for($i = 0; $i < count($news); $i++) {
          echo '<div class="media">
                  <div class="media-body">
                    <h4 class="media-heading">'.$news[$i]->subject.'</h4>';
          if (strlen($news[$i]->text) > 500) {
            $str = $news[$i]->text;
            $str = explode( "\n", wordwrap( $news[$i]->text, 500));
            $str = $str[0] . ' <a href="?id='.$news[$i]->id.'">Loe edasi... </a>';
            echo $str;
          }
          echo '</div>
                </div>';
          /*echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
          echo '<p>'.$news[$i]->text.'</p>';*/
      }
    ?>
  <?php else:?>
    <h3 id="statbar"><a href="news.php" style="color: #333;">Uudised</a></h3>
    <?php
        for($i = 0; $i < count($news); $i++) {
          if($_GET['id'] == $news[$i]->id) {
            echo '<div class="media">
                    <div class="media-body">
                      <h4 class="media-heading">'.$news[$i]->subject.'</h4>';

            echo $news[$i]->text;

            echo '</div>
                  </div>';
            /*echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
            echo '<p>'.$news[$i]->text.'</p>';*/
        }
      }

    ?>

  <?php endif; ?>
</div>

<?php if(!isset($_GET['id'])): ?>

  <div class="col-xs-12 col-sm-4">
    <h3>Kategooriad</h3>
    <?php
        for($i = 0; $i < count($categories); $i++) {
          echo '<p>';
          echo '<a href="?category='.$categories[$i]->id.'">'.$categories[$i]->name.' ('.$categories[$i]->count.')</a>';
          echo '</p>';
          /*echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
          echo '<p>'.$news[$i]->text.'</p>';*/
      }
    ?>
  </div>

<?php else:?>

  <div class="col-xs-12 col-sm-4">
    <h3>Viimased uudised</h3>
    <?php
        for($i = 0; $i < 5; $i++) {
          echo '<div class="media">
                  <div class="media-body">
                    <h4 class="media-heading">'.$news[$i]->subject.'</h4>';
          if (strlen($news[$i]->text) > 300) {
            $str = $news[$i]->text;
            $str = explode( "\n", wordwrap( $news[$i]->text, 300));
            $str = $str[0] . '<a href="?id='.$news[$i]->id.'"> Loe edasi... </a>';
            echo $str;
          }
          echo '</div>
                </div>';
          /*echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
          echo '<p>'.$news[$i]->text.'</p>';*/
      }
    ?>
  </div>

<?php endif; ?>
<?php
if(isset($_SESSION['logged_in_user_id'])):
  if($_SESSION['logged_in_user_group'] == 3):
?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <!-- Modal -->
    <div class="modal fade" id="addnews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Lisa uus uudis</h4>
          </div>
          <div class="modal-body" style="height: 250px;">

            <div class="col-sm-6">
              <label for="subject">Pealkiri</label>
              <input class="form-control" type="text" name="subject">
            </div>

            <div class="col-sm-6">
              <label for="category">Kategooria</label>
              <select class="form-control" name="category">
                <option selected>----</option>
                <option value="">Uudis</option>
                <option value="">Uuendus</option>
              </select>
            </div>

            <div class="col-sm-12">
              <label for="text">Sisu</label>
          		<textarea class="form-control" rows="5" name="text" type="text"></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Sulge</button>
            <button type="submit" name="add_news" class="btn btn-success">Salvesta</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php
  endif;
endif;
?>

<?php require_once("../footer.php"); ?>
