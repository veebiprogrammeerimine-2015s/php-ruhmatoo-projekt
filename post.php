<?php
  require_once 'includes/config.php';
  include 'header.php';

  $post = new Post($db,htmlspecialchars($_GET["id"]));
?>
<?php if($post->get()) : ?>
  <div card z-1 style="width: calc(100% - 18px); padding: 0;">
      <h1 style="margin: 0;text-indent:1em" <?= $post->_color?>><?= $post->_postTitle?></h1>
      <br>
      <h5 style="text-indent:1em"><button raised <?= $post->_color?> onclick="history.go(-1);">Back</button>
        Date: <?= $post->_postDate?> Category: <?= $post->_postTag?> </h5>
      <hr>
      <div style="padding: 18px; margin-top: -24px;">
        <?= $post->_postCont?>
        <div id="disqus_thread"></div>
        <script>
        /**
        * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
        */
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');

        s.src = '//<?= $disqus?>.disqus.com/embed.js';

        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
      </div>
  </div>
<?php else : ?>
    <div card z-1 style="width: calc(100% - 18px); padding: 0;">
      <h1 centered>Sorry, no such post exists!</h1>
    </div>
<?php endif; ?>
<?php include 'footer.php'; ?>
