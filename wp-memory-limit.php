<?php
/*
 * Plugin Name: WP Memory Limit
 * Description: Ever faced an error of type "allowed memory size of 33554432 bytes exhausted"? This plugin allows you to change your Wordpress installation memory limit to bypass these errors.
 * Version: 1.0
 * Author: Danielmlozano
 * Author URI: https://danielmlozano.com
 */
require("WPMemoryLimit.php");
(new WPMemoryLimit)->init();
