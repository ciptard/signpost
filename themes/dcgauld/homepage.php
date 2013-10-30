<?php include('header.php'); ?>



<section class="container">

<section class="content">



  <?php foreach ($this->loop("posts") as $post) {
    echo '<article class="small">';
    echo '<span class="date">' . date('l, F n Y', $post->time) . '</span>';
    echo '<h1><a href="' . $post->url . '">' . $post->title . '</a></h1>';
    echo '</article>';
  } ?>
</section>

<aside>
<?php include('profile.php'); ?>
</aside>

</section>

<?php include('footer.php'); ?>
