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
            
            if ($url) {
                $file = CONTENT_DIR . $url;
            } else {
                $file = CONTENT_DIR . 'index';
            }
            
            if (is_dir($file)) {
                $file = CONTENT_DIR . $url . '/index.md';
            } else {
                $file .= '.md';
            }

            if (file_exists($file)) {
                $config['page_content'] = file_get_contents($file);
            } else {
                $config['page_content'] = file_get_contents(CONTENT_DIR . '404.md');
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            }

            $this->extract_page_meta($config['page_content']);
            $config['page_content'] = preg_replace('/<!--[\s\S]*?-->/', '', $config['page_content']);
            $this->extract_vars();
            $config['page_content'] = Markdown($config['page_content']);
            
            extract($config);
            include(THEMES_DIR . $config['theme'] . '/' . $config['page_template'] . '.php');
        } else {
            die('\'base_url\' value does not exist. Please add the desired URL of your installation in \'settings.php\'');
        }
    }
    
    /**
     * Retrieves the meta information from a .md page file and adds the fields
     * to the global $config array.
     *
     * @since 0.1
     */
    public function extract_page_meta($content = "") {
        global $config;
        $meta = array(
            'page_title'	=> 'Page Title',
            'page_template'	=> 'Page Template'
        );
        $defaults = array(
            'page_title'	=> $config['site_title'],
            'page_template'	=> 'default'
        );
        foreach ($meta as $field => $value) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($value, '/') . ':(.*)$/mi', $content, $match) && $match[1]) {
                $config[$field] = trim(preg_replace('/\s*(?:\*\/|\?>).*/', '', $match[1]));
            } else {
                $config[$field] = $defaults[$field];
            }
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
            'theme'      => 'default',
        );
        foreach ($defaults as $field => $value) {
            if (!array_key_exists($field, $config)) {
                $config[$field] = $value;
            }
        }
        $config['theme_url'] = $config['base_url'] . 'themes/' . $config['theme'];
    }

    /**
     * Adds the ability to loop through 'posts'. Needs to be completed.
     *
     * @since 0.1
     */
    public function get_pages() {
        global $config;
        foreach (glob("content/posts/*.md") as $filename) {
            $slug = substr($filename, 0, -3);
            $content = file_get_contents($filename);
            $this->extract_page_meta($content);
            $post = (object) array(
                'title'    => $config['page_title'],
                'content'  => $content,
                'slug'     => $slug,
                'url'      => $config['base_url'] . $slug,
                'time'     => filemtime($filename),
                'template' => $config['page_template']
            );
            $config['posts'][] = $post;
        }
        return $config['posts'];
    }
    
}

?>
