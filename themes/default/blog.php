<?php include('header.php'); ?>

<div id="container">
  <?php foreach ($this->loop("posts") as $post) {
    echo '<h2><a href="' . $post->url . '">' . $post->title . '</a></h2>';
    echo '<p>' . $post->content . '</p>';
  } ?>
</div>

<?php include('footer.php'); ?>
