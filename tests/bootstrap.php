<?php
/**
 * PHPUnit bootstrap file for Sophia Chat tests.
 */

// Define minimal WordPress constants for testing
define('ABSPATH', dirname(__DIR__) . '/');

// Mock WordPress functions needed by the plugin
if (!function_exists('get_option')) {
    $GLOBALS['sophia_test_options'] = array();

    function get_option($option, $default = false) {
        return isset($GLOBALS['sophia_test_options'][$option])
            ? $GLOBALS['sophia_test_options'][$option]
            : $default;
    }

    function update_option($option, $value, $autoload = null) {
        $GLOBALS['sophia_test_options'][$option] = $value;
        return true;
    }
}

if (!function_exists('is_front_page')) {
    $GLOBALS['sophia_test_page_state'] = array(
        'is_front_page' => false,
        'is_home' => false,
        'is_page' => false,
        'is_single' => false,
        'page_ids' => array(),
    );

    function is_front_page() {
        return $GLOBALS['sophia_test_page_state']['is_front_page'];
    }

    function is_home() {
        return $GLOBALS['sophia_test_page_state']['is_home'];
    }

    function is_page($ids = '') {
        if (empty($ids)) {
            return $GLOBALS['sophia_test_page_state']['is_page'];
        }
        $ids = (array) $ids;
        return in_array($GLOBALS['sophia_test_page_state']['current_page_id'], $ids, true);
    }

    function is_single($ids = '') {
        if (empty($ids)) {
            return $GLOBALS['sophia_test_page_state']['is_single'];
        }
        $ids = (array) $ids;
        return in_array($GLOBALS['sophia_test_page_state']['current_page_id'], $ids, true);
    }
}

if (!function_exists('__')) {
    function __($text, $domain = 'default') {
        return $text;
    }
}

if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path($file) {
        return dirname($file) . '/';
    }
}

if (!function_exists('plugin_dir_url')) {
    function plugin_dir_url($file) {
        return 'https://example.com/wp-content/plugins/sophia-chat/';
    }
}

if (!function_exists('add_action')) {
    function add_action($tag, $function, $priority = 10, $accepted_args = 1) {
        // No-op for testing
    }
}

if (!function_exists('add_filter')) {
    function add_filter($tag, $function, $priority = 10, $accepted_args = 1) {
        // No-op for testing
    }
}

if (!function_exists('register_activation_hook')) {
    function register_activation_hook($file, $function) {
        // No-op for testing
    }
}

if (!function_exists('register_deactivation_hook')) {
    function register_deactivation_hook($file, $function) {
        // No-op for testing
    }
}

if (!function_exists('plugin_basename')) {
    function plugin_basename($file) {
        return basename(dirname($file)) . '/' . basename($file);
    }
}

if (!function_exists('current_time')) {
    function current_time($type) {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('get_current_user_id')) {
    function get_current_user_id() {
        return 1;
    }
}

if (!function_exists('_e')) {
    function _e($text, $domain = 'default') {
        echo $text;
    }
}

if (!function_exists('esc_attr_e')) {
    function esc_attr_e($text, $domain = 'default') {
        echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_url')) {
    function esc_url($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}

if (!function_exists('wp_enqueue_style')) {
    function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all') {
        // No-op for testing
    }
}

if (!function_exists('wp_enqueue_script')) {
    function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $args = array()) {
        // No-op for testing
    }
}

if (!function_exists('wp_add_inline_style')) {
    function wp_add_inline_style($handle, $data) {
        // No-op for testing
    }
}

if (!function_exists('add_options_page')) {
    function add_options_page($page_title, $menu_title, $capability, $menu_slug, $callback = '', $position = null) {
        // No-op for testing
    }
}

if (!function_exists('register_setting')) {
    function register_setting($option_group, $option_name, $args = array()) {
        // No-op for testing
    }
}

if (!function_exists('wp_add_privacy_policy_content')) {
    function wp_add_privacy_policy_content($plugin_name, $policy_text) {
        // No-op for testing
    }
}

// Reset test state
function sophia_test_reset() {
    $GLOBALS['sophia_test_options'] = array();
    $GLOBALS['sophia_test_page_state'] = array(
        'is_front_page' => false,
        'is_home' => false,
        'is_page' => false,
        'is_single' => false,
        'current_page_id' => 0,
    );
}

// Load the plugin file (only functions, not hooks due to mocks)
require_once dirname(__DIR__) . '/sophia-chat.php';
