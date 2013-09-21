<?php include('header.php'); ?>

<section class="container">
  <small><a href="<?php echo $config['base_url']; ?>">&larr; Back to homepage</a></small>
  <h2><?php echo $page->title; ?></h2>
  <?php echo $page->content; ?>
</section>

<?php include('footer.php'); ?>
