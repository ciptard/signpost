<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (!$page->is_front_page) { ?><?php echo $page->title; ?> | <?php } ?><?php echo $config['site_title'] ?></title>
  <link rel="stylesheet" href="<?php echo $config['theme_url']; ?>/css/normalize.css" />
	<link rel="stylesheet" href="<?php echo $config['theme_url']; ?>/css/style.css" />
  <script src="//use.typekit.net/yoi6rpo.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>
  <script src="<?php echo $config['theme_url']; ?>/js/rainbow-custom.min.js"></script>
</head>
<body>
