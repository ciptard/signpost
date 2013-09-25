<?php include('header.php'); ?>

<?php include('profile.php'); ?>

<section class="container">
<article>
  <small><a href="<?php echo $config['base_url']; ?>">&larr; Back to homepage</a></small>
  <?php echo $page->content; ?>
</article>
</section>

<?php include('footer.php'); ?>
