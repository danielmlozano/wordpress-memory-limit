<?php

require("WPMemoryLimitAdminPage.php");

class WPMemoryLimit
{
    /**
     * The minimum memory limit in MB
     *
     * @var integer
     */
    public $min_limit = 32;

    /**
     * The default installation memory limit in MB
     *
     * @var integer
     */
    public $install_limit = 64;

    /**
     * Error prop
     *
     * @var string|null
     */
    public $error = null;

    /**
     * Whether show a successful message
     *
     * @var boolean
     */
    public $success = false;

    /**
     * The plugin's admin page slug
     *
     * @var string
     */
    public $page_slug = '';

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [
        'unable' => 'There was a problem while changing your memory limit. 
                    Seems that this actions is not supported by your server. 
                    Contact to your server administrator or technical support.',
        'minimum' => 'Please set the memory limit to at least %limit%Mb.',
    ];

    /**
     * Initializes a new class instance
     */
    public function __construct()
    {
        $this->page_slug = WPMemoryLimitAdminPage::$page_slug;
        $this->setMemoryLimit();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function init()
    {
        if ($redirect = get_option('wp_mem_redirect')) {
            delete_option('wp_mem_redirect');
            header("Location: " . $redirect);
            exit();
        }

        register_activation_hook(__FILE__, [&$this, 'installPlugin']);

        add_action('admin_menu', [&$this, 'addMenuPage']);
        
        if (isset($_GET['page']) && $_GET['page'] == $this->page_slug) {
            add_action('admin_enqueue_scripts', [&$this,'appendCss']);
            add_action('admin_init', [&$this, 'processAction']);
            add_action('admin_notices', [&$this, 'showError']);
            add_action('admin_notices', [&$this, 'showSuccess']);
        }
    }

    /**
     * Add the plugin option to the admin menu panel
     *
     * @return void
     */
    public function addMenuPage()
    {
        $admin_page = new WPMemoryLimitAdminPage($this->getUsage() ? $this->getUsage(1) : 'unknown');
        call_user_func_array('add_submenu_page', $admin_page->getPageArguments());
    }
   

    /**
     * Install the plugin in the admin area
     *
     * @return void
     */
    public function installPlugin()
    {
        if (!get_option('wp_mem_limit')) {
            $limit = defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : 32;
            $limit = $limit > $this->install_limit ? $limit : $this->install_limit;
            update_option('wp_mem_limit', $limit);
        }
        update_option('wp_mem_redirect', 'options-general.php?page=' . $this->page_slug);
    }
    
    /**
     * Append css file for admin page
     *
     * @param $hook
     * @return void
     */
    public function appendCss($hook)
    {
        $current_screen = get_current_screen();

        if (strpos($current_screen->base, $this->page_slug) === false) {
            return;
        } else {
            wp_enqueue_style('boot_css', 'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css');
        }
    }


    /**
     * Get the current aprox memory usage
     *
     * @param integer $decimal_places
     * @return string
     */
    public function getUsage($decimal_places = 2)
    {
        $usage = "There was a problem trying to get your current memory usage.";
        
        if (function_exists('memory_get_usage')) {
            $usage = memory_get_usage();
            $usage = $usage / (1024 * 1024);
            $usage = number_format($usage, $decimal_places, '.', '');
        }
        
        return $usage;
    }

    /**
     * Get the current limit.
     *
     * @return mixed
     */
    public function getLimit()
    {
        $limit = null;
        if (function_exists('ini_get')) {
            $limit = (int) ini_get('memory_limit');
        }
        return $limit;
    }

    /**
     * Set the memory limit
     *
     * @param int $limit
     * @return bool
     */
    public function setMemoryLimit($limit = null)
    {
        if (!function_exists('ini_set')) {
            $this->error = $this->errors['unable'];
            return;
        }
        
        $old = $this->getLimit();

        $limit = $limit ? $limit : get_option('wp_mem_limit');

        $admin_area = (bool) (isset($_GET['page']) && $_GET['page'] == $this->page_slug);
        
        if ($limit > 0 && $old != $limit && ($admin_area || $limit > $old)) {
            //change setting
            @ini_set('memory_limit', $limit . 'M');
            
            $new = $this->getLimit();
            
            if (!$new || $new == $old) {
                $this->error = $this->errors['unable'];
            }
            return true;
        }
        return false;
    }

    /**
     * Process the request to change the memory limit
     *
     * @return void
     */
    public function processAction()
    {
        if (isset($_POST['process']) && $_POST['process'] == $this->page_slug) {
            $limit = (int) $_POST['mem_limit'];
        
            if ($limit < $this->min_limit) {
                $this->error = str_replace('%limit%', $this->min_limit, $this->errors['minimum']);
                return;
            }
            update_option('wp_mem_limit', $limit);
            $this->success = $this->setMemoryLimit($limit);
        }
    }

    /**
     * Show the error in the plugin's admin page
     *
     * @return void
     */
    public function showError()
    {
        if ($this->error) {
            echo '<div class="error"><p>' . $this->error . '</p></div>';
        }
    }

    /**
     * Show the successful feedbac notice
     *
     * @return void
     */
    public function showSuccess()
    {
        if ($this->success) {
            echo '<div class="notice notice-success">Memory limit changed succesfully</div>';
        }
    }
}
