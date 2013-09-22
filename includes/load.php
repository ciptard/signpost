<?php

/**
 * The Markdown-CMS class.
 *
 * @version 0.1
 */
class MarkdownCMS {

    /**
     * Constructor.
     *
     * Gathers URL and retrieves .md file accordingly. Passes through to the
     * Markdown class and includes the relevant page template.
     *
     * @since 0.1
     */
    public function __construct() {
        global $config;
        if (isset($config['base_url']) && $config['base_url']) {
            $this->apply_default_settings();
            // Gets the full URI of the current location.
            $uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            // Find segment of URL relavant to the page's filename.
            if ($_SERVER['REQUEST_URI'] != $_SERVER['PHP_SELF'])
                $url = trim(preg_replace('/' . str_replace('/', '\/', str_replace('index.php', '', $_SERVER['PHP_SELF'])) . '/', '', $_SERVER['REQUEST_URI'], 1), '/');
            // Detect whether the URL is the homepage.
            if ($url)
                $file = CONTENT_DIR . $url;
            else
                $file = CONTENT_DIR . 'index';
            // Detect whether the URL is directory name.
            if (is_dir($file))
                $file = CONTENT_DIR . $url . '/index.md';
            else
                $file .= '.md';
            // Send a 404 error if a page isn't found or it is unpublished.
            if (file_exists($file) && ($this->extract($file)->status == "publish")) {
                $page = $this->extract($file);
            } else {
                $page = $this->extract(CONTENT_DIR . '404.md');
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            }
            // Detect if the page is the front page.
            $page->is_front_page = ($uri == $config['base_url']) ? true : false;
            // Include relevant theme template (specified within the page meta).
            include(THEMES_DIR . $config['theme'] . '/' . $page->template . '.php');
        } else {
            // Prevent the installation from running if the base_url variable isn't set.
            die('\'base_url\' value does not exist. Please add the desired URL of your installation in \'settings.php\'');
        }
    }

    /**
     * Extracts variables from a .md page file. If the user types %hello%,
     * this will look in $config[hello] to find the required value (settings.php).
     *
     * @since 0.1
     */
    public function extract_vars() {
        global $config;
        foreach ($config as $field => $value) {
            if ($field != 'page_content')
                $config['page_content'] = str_replace('%' . $field . '%', $value, $config['page_content']);
        }
    }

    /**
     * Ensures that the 3 required options (site_title, base_url and theme) are
     * never left blank by adding default values if this is the case.
     *
     * @since 0.1
     */
    public function apply_default_settings() {
        global $config;
        $defaults = array(
            'site_title' => 'Markdown-CMS',
            'theme'      => 'default'
        );
        foreach ($defaults as $field => $value) {
            if (!array_key_exists($field, $config)) {
                $config[$field] = $value;
            }
        }
        $config['theme_url'] = $config['base_url'] . 'themes/' . $config['theme'];
    }
    
    /**
     * Extracts information (meta etc.) from a page's .md file.
     * 
     * @param string $file The location of the .md file.
     * @return object An object representing the page.
     * @since 0.1
     */
    public function extract($file) {
        global $config;
        $meta = array(
            'title'    => 'Title',
            'template' => 'Template',
            'status'   => 'Status'
        );
        $defaults = array(
            'template' => 'page',
            'status'   => 'publish'
        );
        $content = file_get_contents($file);
        // Check through header comment to find meta values.
        foreach ($meta as $field => $value) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($value, '/') . ':(.*)$/mi', $content, $match) && $match[1]) {
                $fields[$field] = trim(preg_replace('/\s*(?:\*\/|\?>).*/', '', $match[1]));
            } else {
                if ($defaults[$field] != "") {
                    $fields[$field] = $defaults[$field];
                } else {
                    $fields[$field] = "";
                }
            }
        }
        // Populate object's fields with page information.
        $slug = substr(current(array_slice(explode("/", $file), -1)), 0, -3);
        $url = current(array_slice(explode("/", $file), -2));
        $info = array(
            'content'  => Markdown(preg_replace('/<!--[\s\S]*?-->/', '', $content)),
            'slug'     => $slug,
            'url'      => $config['base_url'] . $url . '/' . $slug,
            'time'     => filemtime($file),
        );
        // Merge information about the file with the meta values within it.
        $page = array_merge($fields, $info);
        return (object) $page;
    }

    /**
     * Adds the ability to iterate through files (for blogs etc).
     *
     * @param string $location Where the .md files to loop through are located.
     * @return object[] An array of located page objects.
     * @since 0.1
     */
    public function loop($location = "") {
        global $config;
        foreach (glob(CONTENT_DIR . $location . "/*.md") as $filename) {
            $slug = substr(current(array_slice(explode("/", $filename), -1)), 0, -3);
            // TODO Remove any posts that are named index.md
            if ($slug != "index") {
                $page = $this->extract($filename);
                if ($page->status == "publish")
                    $pages[] = $page;
            }
        }
        return $pages;
    }
    
}

?>
