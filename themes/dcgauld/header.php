<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (!$page->is_front_page) { ?><?php echo $page->title; ?> | <?php } ?><?php echo $config['site_title'] ?></title>
  <link rel="stylesheet" href="<?php echo $config['theme_url']; ?>/css/normalize.css" />
	<link rel="stylesheet" href="<?php echo $config['theme_url']; ?>/css/style.css" />
  <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,700,300italic,700italic' rel='stylesheet' type='text/css'>
  <script src="<?php echo $config['theme_url']; ?>/js/rainbow-custom.min.js"></script>
</head>
<body>
<header>
<section class="container">
<a href="<?php echo $config['base_url']; ?>" class="noline"><img src="https://0.gravatar.com/avatar/8488f27004816f33291f55d3abc97044?s=160" class="avatar" /></a>
</section>
</header>