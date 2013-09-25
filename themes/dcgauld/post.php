<?php include('header.php'); ?>

<?php include('profile.php'); ?>

<section class="container">
<article>
  <small><a href="<?php echo $config['base_url']; ?>">&larr; Back to homepage</a></small>
  <h2><?php echo $page->title; ?></h2>
  <span class="date"><?php echo date('l, F n Y', $page->time); ?></span>
  <?php echo $page->content; ?>
  </article>
</section>

<?php include('footer.php'); ?>
