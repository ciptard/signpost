Markdown-CMS
=============

Markdown-CMS is a flat file content management system, meaning there is no database required to store posts or pages. This results in a system that is faster, less error prone and requires very little time to setup.

URI routes can easily be added for 

Installation
------------

1. Download an extract the latest version of Markdown-CMS
2. Upload or deploy the files to your server
3. Modify the 'base_url' value within `settings.php` to reflect your installation's location
4. Sit back and enjoy the lack of installation time!

Requirements
------------

Coming soon.

Documentation
-------------

###Creating Content

All pages and posts are marked up using [Markdown](http://daringfireball.net/projects/markdown/syntax); an easy to use, non-obstrusive text based formatting syntax. It is easy to pick up and widely used across many internet services (including GitHub).

Each `.md` (Markdown) file within the 'pages' directory is treated as a seperate page. Therefore if, for example, your website was located at `http://example.com`, `pages/products.md` could be accessed from `http://example.com/products`, whilst `pages/index.md` could be accessed from `http://example.com`. URIs can be extended by creating subfolders, for instance `pages/category/product.md` could be accessed from `http://example.com/category/product`.

A list of possible URIs is shown below:

* `pages/index.md` --> `http://example.com`
* `pages/page.md` --> `http://example.com/page`
* `pages/sub/index.md` --> `http://example.com/sub` (same as above)
* `pages/sub/page.md` --> `http://example.com/sub/page`
* `pages/a/stupid/amount.md` --> `http://example.com/a/stupid/amount`

If a file cannot be found, `pages/404.md` is used.

###Page Markup

Meta can be applied to each page by adding a block comment at the top of the `.md` file. A 'Page Title' can be added to add the name of the page in the browser's title bar, and 'Page Template' can be used to determine a specific theme file to use. An example of a page's meta is shown below:

```php
<!--
Page Title: Example page
Page Template: fullwidth
-->
```

These meta values are also added to an array called `$config` (more about this later) which can be accessed from within any `.php` or `.md` file.

###Themes

The minimum requirements of a theme is to contain just one file, `default.php` (the default page template).

You can change the theme Markdown-CMS uses by altering the `$config` array from within the `settings.php` file in the root directory of your installation.

The 'Page Template' meta value within any `.md` file is used to determine which theme file to use when displaying the post/page. For example if the value is set to 'fullwidth', Markdown-CMS will use the `fullwidth.php` theme template (located in the root of the current theme's directory) to display the post/page.

###Configuration

The `$config` array is an set of values used throughout Markdown-CMS. These values can be used from within any theme file. A selection of available values are shown below:

* `$config['site_title']` - The title of your installation.
* `$config['base_url']` - The URL of your installation.
* `$config['theme']` - The name (slug) of the current theme.
* `$config['theme_url']` - The URL of the current theme.
* `$config['page_title']` - The current page's title.
* `$config['page_template']` - The current page's template.
* `$config['page_content']` - The current page's content.

Custom values can be added from within the `settings.php` file in the root directory of your installation.

**All of the above values (except for 'page\_content') can also be accessed from within any `.md` file; simply enclose the name of the value within '&#37;' symbols. For example, if you want to access `$config['page_title']`, &#37;page\_title&#37; must be used. This same syntax can be used with any custom values.**
