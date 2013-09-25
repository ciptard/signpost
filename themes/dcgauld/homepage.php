<?php include('header.php'); ?>



  <?php include('profile.php'); ?>
<section class="container">

  <?php foreach ($this->loop("posts") as $post) {
    echo '<article>';
    echo '<h2><a href="' . $post->url . '">' . $post->title . '</a></h2>';
    echo '<span class="date">' . date('l, F n Y', $post->time) . '</span>';
    echo $post->content;
    echo '</article>';
  } ?>
</section>

<?php include('footer.php'); ?>
