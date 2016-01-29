<?php
  require_once 'includes/config.php';
  include 'header.php';

  try {
    $result = $db->query("SELECT * FROM blog_posts
      LEFT JOIN blog_tag_color
      ON blog_posts.postTag=blog_tag_color.postTag");
    $html = " ";
    foreach ($result as $row) {
      $html .= '<div '.$row["color"].' card z-1 class="blog-card">';
        $html .= '<div class="card-info" '.$row["color"].'>'.date('F/j/Y',strtotime($row["postDate"]));
        $html .= ' | '.$row["postTag"].'</div>';
        $html .= '<img src="http://lorempixel.com/960/480/sports/" alt="">';
        $html .= '<h3 '.$row["color"].'>'.$row["postTitle"].'</h3>';
        $html .= '<div class="card-body">'.$row["postDesc"];
          $html .= '<a button fg-black href="post.php?id='.$row["postID"].'">read more</a>';
        $html .= '</div>';
      $html .= '</div>';
    }
    echo $html;
  } catch (PDOexception $e) {
    echo "Error is: " . $e-> etmessage();
  }

  include 'footer.php';
?>
