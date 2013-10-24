# Signpost

Signpost is a flat file content management system, meaning there is no database required to store posts or pages. This results in a system that is faster, less error prone and requires very little time to setup.

## Installation

1. Download an extract the latest version of Signpost
2. Upload or deploy the files to your server
3. Modify the 'base_url' value within `settings.php` to reflect your installation's location
4. Sit back and enjoy the lack of installation time!

## Requirements

* PHP 5.2.4 or above
* `mod_rewrite` enabled if you are using Apache

## Documentation

### Creating Content

All pages and posts are marked up using [Markdown](http://daringfireball.net/projects/markdown/syntax); an easy to use, non-obstrusive text based formatting syntax. It is easy to pick up and widely used across many internet services (including GitHub).

Each `.md` (Markdown) file within the 'content' directory is treated as a seperate page. Therefore if, for example, your website was located at `http://example.com`, `content/products.md` could be accessed from `http://example.com/products`, whilst `content/index.md` could be accessed from `http://example.com`. URIs can be extended by creating subfolders, for instance `content/category/product.md` could be accessed from `http://example.com/category/product`.

A list of possible URIs is shown below:

* `content/index.md` --> `http://example.com`
* `content/page.md` --> `http://example.com/page`
* `content/sub/index.md` --> `http://example.com/sub` (same as above)
* `content/sub/page.md` --> `http://example.com/sub/page`
* `content/a/stupid/amount.md` --> `http://example.com/a/stupid/amount`

If a file cannot be found, `content/404.md` is used.

### Themes

The minimum requirements of a theme is to contain just one file, `default.php` (the default page template).

You can change the theme Markdown-CMS uses by altering the `$config` array from within the `settings.php` file in the root directory of your installation.

The 'Page Template' meta value within any `.md` file is used to determine which theme file to use when displaying the post/page. For example if the value is set to 'fullwidth', Markdown-CMS will use the `fullwidth.php` theme template (located in the root of the current theme's directory) to display the post/page.

### Page Meta Markup

Meta can be applied to each page by adding a block comment at the top of the `.md` file. An example of a page's meta definition is shown below:

```php
<!--
Title: Example page
Template: fullwidth
-->
```

#### Page Meta Values

Each `.md` file carries the following meta values:

* `title` - The title of the page (in the example above, 'Example page').
* `template` - The theme template to use (in the example above, 'fullwidth').
* `content` - The page's Markdown content.
* `slug` - The page's slug - if the file was named `hello.md`, the slug would be 'hello'.
* `url` - The page's URL - a combination of the site's URL and the slug (above).
* `time` - The time (in milliseconds) that the page (file) was created.

Any of these values can be accessed from within a theme's `.php` file. For example, to print the current page's title in a `<h2>` tag, you would use:

```php
<h2><?php echo $page->title; ?></h2>
```

### Blog Creation

One useful feature of Signpost is the ability to mimic a blog. It achieves this by providing a simple variable `$posts` that holds an array of `.md` files from the `content/posts` directory (with meta data for each one), which can then be iterated through. The following example shows how this can be achieved.

```php
<?php foreach ($this->loop("posts") as $post) {
  echo '<h2><a href="' . $post->url . '">' . $post->title . '</a></h2>';
  echo '<p>' . $post->content . '</p>';
} ?>
```

This would most probably be added to a `blog.php` theme template, and a blank page created specifying the template as 'blog'.

### Configuration

Markdown-CMS also includes a configuration (`$config`) array, allowing you to access options from anywhere in your installation. Four settings are already included for you, however you can add your own values by editing the `settings.php` file (located in the root of your installation). The default options available to you are:

* `$config['site_title']` - The title of your installation.
* `$config['base_url']` - The URL of your installation.
* `$config['theme']` - The name (slug) of the current theme.
* `$config['theme_url']` - The URL of the current theme.

These options can also be accessed from within any `.md` file by simply enclosing the name of the value within '&#37;' symbols. For example, if you want to access `$config['page_title']`, &#37;page\_title&#37; can be used. This same syntax can be used with any custom values.
