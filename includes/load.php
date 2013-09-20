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

            if ($_SERVER['REQUEST_URI'] != $_SERVER['PHP_SELF'])
                $url = trim(preg_replace('/' . str_replace('/', '\/', str_replace('index.php', '', $_SERVER['PHP_SELF'])) . '/', '', $_SERVER['REQUEST_URI'], 1), '/');
            
            if ($url)
                $file = CONTENT_DIR . $url;
            else
                $file = CONTENT_DIR . 'index';
            
            if (is_dir($file))
                $file = CONTENT_DIR . $url . '/index.md';
            else
                $file .= '.md';

            if (file_exists($file) && ($this->extract($file)->status == "publish")) {
                $page = $this->extract($file);
            } else {
                $page = $this->extract(CONTENT_DIR . '404.md');
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            }

            $page->content = preg_replace('/<!--[\s\S]*?-->/', '', $page->content);

            include(THEMES_DIR . $config['theme'] . '/' . $page->template . '.php');
        } else {
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

    public function extract($file) {
        global $config;
        $meta = array(
            'title'    => 'Title',
            'template' => 'Template',
            'status'   => 'Status'
        );
        $defaults = array(
            'template' => 'default',
            'status'   => 'publish'
        );
        $content = file_get_contents($file);
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

        $slug = substr(current(array_slice(explode("/", $file), -1)), 0, -3);
        $url = current(array_slice(explode("/", $file), -2));
        $info = array(
            'content'  => Markdown($content),
            'slug'     => $slug,
            'url'      => $config['base_url'] . $url . '/' . $slug,
            'time'     => filemtime($file),
        );

        $page = array_merge($info, $fields);
        return (object) $page;
    }

    /**
     * Adds the ability to loop through 'posts'. Needs to be completed.
     *
     * @since 0.1
     */
    public function get_posts() {
        return $this->loop("posts");
    }

    public function loop($location = "") {
        global $config;
        foreach (glob(CONTENT_DIR . $location . "/*.md") as $filename) {
            // TODO Remove any posts that are named index.md
            $page = $this->extract($filename);
            if ($page->status == "publish")
                $pages[] = $page;
        }
        return $pages;
    }
    
}

?>
