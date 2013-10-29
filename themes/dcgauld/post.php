<?php include('header.php'); ?>



<section class="container">

<section class="content">



<span class="date"><?php echo date('l, F n Y', $page->time); ?></span>
  <h1><?php echo $page->title; ?></h1>
  
  <?php echo $page->content; ?>
</section>

<aside>
<?php include('profile.php'); ?>
</aside>

</section>

<?php include('footer.php'); ?>
