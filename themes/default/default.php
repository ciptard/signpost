<?php include('header.php'); ?>

<div id="container">
	<?php echo $page->content; ?>
  <?php foreach ($posts as $post) {
  echo '<h2><a href="' . $post->url . '">' . $post->title . '</a></h2>';
  echo '<p>' . $post->content . '</p>';
}

?>
</div>



<?php include('footer.php'); ?>
