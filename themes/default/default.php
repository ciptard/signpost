<?php include('header.php'); ?>

<div id="container">
	<?php echo $config['page_content']; ?>
  <?php $posts = $this->get_pages();
echo "hi";
foreach ($posts as $post) {
  echo '<h2><a href="' . $post->url . '">' . $post->title . '</a></h2>';
  echo '<p>' . $post->content . '</p>';
}

?>
</div>



<?php include('footer.php'); ?>
