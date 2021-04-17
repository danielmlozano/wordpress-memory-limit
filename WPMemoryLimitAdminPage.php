<?php

class WPMemoryLimitAdminPage
{

    /**
     * The plugin's admin page slug
     *
     * @var string
     */
    public static $page_slug = 'wp-memory-limit';

    /**
     * The current memory usage
     *
     * @var int
     */
    public $memory_usage;

    public function __construct($usage)
    {
        $this->memory_usage = $usage;
    }

    /**
     * The html template path
     *
     * @var [type]
     */
    private $template_path;

    /**
     * Arguments for WP option menu
     *
     * @return void
     */
    public function getPageArguments()
    {
        return [
            'options-general.php',
            'WP Memory limit',
            'WP Memory limit',
            'manage_options',
            $this->getSlug(),
            [$this, 'renderPage']
        ];
    }

    /**
     * Get the page slug
     *
     * @return string
     */
    public function getSlug()
    {
        return WPMemoryLimitAdminPage::$page_slug;
    }

    /**
     * Render the page
     *
     * @return void
     */
    public function renderPage()
    {
        $this->template_path = rtrim('page.php', '/');
        include $this->template_path;
    }
}
