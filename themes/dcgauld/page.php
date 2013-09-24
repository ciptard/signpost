<?php include('header.php'); ?>

<?php include('profile.php'); ?>

<section class="container">
  <small><a href="<?php echo $config['base_url']; ?>">&larr; Back to homepage</a></small>
  <?php echo $page->content; ?>
</section>

<?php include('footer.php'); ?>
