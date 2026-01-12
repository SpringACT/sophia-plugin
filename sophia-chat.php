<?php
/**
 * Plugin Name: Sophia Chat
 * Plugin URI: https://github.com/SpringACT/sophia-plugin
 * Description: Adds the Sophia Chat bubble to your website - providing real-time, accessible, anonymous support for individuals affected by domestic violence.
 * Version: 2.0.0
 * Author: SpringACT
 * Author URI: https://springact.org
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sophia-chat
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SOPHIA_CHAT_VERSION', '2.0.0');
define('SOPHIA_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SOPHIA_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SOPHIA_CHAT_URL', 'https://sophia.chat/secure-chat');
define('SOPHIA_CHAT_ICON_CDN', 'https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/');

/**
 * Enqueue frontend styles for the chat widget
 */
function sophia_chat_enqueue_styles() {
    if (!sophia_chat_should_display()) {
        return;
    }

    wp_enqueue_style('sophia-chat', SOPHIA_CHAT_PLUGIN_URL . 'assets/css/sophia-chat.css', array(), SOPHIA_CHAT_VERSION);

    $icon_url = sophia_chat_get_icon_url();
    if ($icon_url) {
        $inline_css = '#sophia-chat-bubble { background-image: url("' . esc_url($icon_url) . '"); }';
        wp_add_inline_style('sophia-chat', $inline_css);
    }
}
add_action('wp_enqueue_scripts', 'sophia_chat_enqueue_styles');

/**
 * Renders the Sophia Chat bubble widget in the site footer.
 *
 * Outputs the HTML, inline CSS, and onclick handler for the chat bubble.
 * Only renders if sophia_chat_should_display() returns true.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sophia_chat_add_widget() {
    if (!sophia_chat_should_display()) {
        return;
    }

    $chat_url = SOPHIA_CHAT_URL;
    $icon_url = sophia_chat_get_icon_url();
    ?>
    <!-- Sophia Chat Widget -->
    <button id="sophia-chat-bubble"
            onclick="(function(){var w=window.open('<?php echo esc_js($chat_url); ?>','SophiaChat','width=400,height=600,scrollbars=yes,resizable=yes');if(!w||w.closed)window.location.href='<?php echo esc_js($chat_url); ?>';})()"
            aria-label="<?php esc_attr_e('Chat with Sophia', 'sophia-chat'); ?>"
            title="<?php esc_attr_e('Chat with Sophia', 'sophia-chat'); ?>">
    </button>
    <?php if ($icon_url) : ?>
    <script>
    (function(){var img=new Image();img.onerror=function(){var b=document.getElementById('sophia-chat-bubble');if(b){b.style.backgroundImage='none';b.textContent='?';}};img.src='<?php echo esc_js($icon_url); ?>';})();
    </script>
    <?php endif; ?>
    <?php
}
add_action('wp_footer', 'sophia_chat_add_widget');

/**
 * Determines whether the chat widget should display on the current page.
 *
 * Checks the visibility setting and compares against the current page context.
 * Supports four modes: 'all', 'homepage', 'specific', and 'exclude'.
 *
 * @since 1.0.0
 *
 * @return bool True if widget should display, false otherwise.
 */
function sophia_chat_should_display() {
    $visibility = get_option('sophia_chat_visibility', 'all');

    if ($visibility === 'all') {
        return true;
    }

    if ($visibility === 'homepage') {
        return is_front_page() || is_home();
    }

    if ($visibility === 'specific') {
        $page_ids = get_option('sophia_chat_page_ids', '');
        if (empty($page_ids)) {
            return true;
        }

        $ids = array_map('trim', explode(',', $page_ids));
        $ids = array_map('intval', $ids);

        return is_page($ids) || is_single($ids);
    }

    if ($visibility === 'exclude') {
        $exclude_ids = get_option('sophia_chat_exclude_ids', '');
        if (empty($exclude_ids)) {
            return true;
        }

        $ids = array_map('trim', explode(',', $exclude_ids));
        $ids = array_map('intval', $ids);

        return !(is_page($ids) || is_single($ids));
    }

    return true;
}

/**
 * Returns the list of available Sophia avatar icons.
 *
 * Each icon is keyed by its numeric ID and has a translatable label.
 *
 * @since 1.0.0
 *
 * @return array Associative array of icon_id => label pairs.
 */
function sophia_chat_get_icons() {
    return array(
        '1'  => __('Sophia 1', 'sophia-chat'),
        '2'  => __('Sophia 2', 'sophia-chat'),
        '6'  => __('Sophia 6', 'sophia-chat'),
        '7'  => __('Sophia 7', 'sophia-chat'),
        '9'  => __('Sophia 9', 'sophia-chat'),
        '10' => __('Sophia 10', 'sophia-chat'),
        '11' => __('Sophia 11', 'sophia-chat'),
        '12' => __('Sophia 12', 'sophia-chat'),
        '13' => __('Sophia 13', 'sophia-chat'),
        '14' => __('Sophia 14', 'sophia-chat'),
        '15' => __('Sophia 15', 'sophia-chat'),
        '16' => __('Sophia 16', 'sophia-chat'),
        '17' => __('Sophia 17', 'sophia-chat'),
        '18' => __('Sophia 18', 'sophia-chat'),
        '19' => __('Sophia 19', 'sophia-chat'),
        '20' => __('Sophia 20', 'sophia-chat'),
        '21' => __('Sophia 21', 'sophia-chat'),
        '23' => __('Sophia 23', 'sophia-chat'),
        '24' => __('Sophia 24', 'sophia-chat'),
        '25' => __('Sophia 25', 'sophia-chat'),
    );
}

/**
 * Returns the URL for the currently selected chat icon.
 *
 * Handles three cases: 'none' (empty), 'custom' (user-provided URL),
 * or a built-in icon ID. Falls back to Sophia_1.png for invalid keys.
 *
 * @since 1.0.0
 *
 * @return string The icon URL, or empty string if 'none' selected.
 */
function sophia_chat_get_icon_url() {
    $icon = get_option('sophia_chat_icon', '1');

    if ($icon === 'none') {
        return '';
    }

    if ($icon === 'custom') {
        return get_option('sophia_chat_custom_icon_url', '');
    }

    // Return built-in icon URL from CDN
    $icons = sophia_chat_get_icons();
    if (isset($icons[$icon])) {
        return SOPHIA_CHAT_ICON_CDN . 'Sophia_' . $icon . '.png';
    }

    return SOPHIA_CHAT_ICON_CDN . 'Sophia_1.png';
}

/**
 * Registers the Sophia Chat settings page in the WordPress admin menu.
 *
 * Adds a submenu page under Settings > Sophia Chat.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sophia_chat_menu() {
    add_options_page(
        __('Sophia Chat Settings', 'sophia-chat'),
        __('Sophia Chat', 'sophia-chat'),
        'manage_options',
        'sophia-chat',
        'sophia_chat_settings_page'
    );
}
add_action('admin_menu', 'sophia_chat_menu');

/**
 * Registers plugin settings with the WordPress Settings API.
 *
 * Registers icon, custom URL, visibility, page IDs, and exclude IDs options.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sophia_chat_register_settings() {
    register_setting('sophia_chat_options', 'sophia_chat_icon', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_custom_icon_url', 'esc_url_raw');
    register_setting('sophia_chat_options', 'sophia_chat_visibility', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_page_ids', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_exclude_ids', 'sanitize_text_field');
}
add_action('admin_init', 'sophia_chat_register_settings');

/**
 * Enqueues admin stylesheet for the settings page.
 *
 * Only loads on the Sophia Chat settings page to avoid conflicts.
 *
 * @since 1.0.0
 *
 * @param string $hook The current admin page hook suffix.
 * @return void
 */
function sophia_chat_admin_styles($hook) {
    if ($hook !== 'settings_page_sophia-chat') {
        return;
    }
    wp_enqueue_style('sophia-chat-admin', SOPHIA_CHAT_PLUGIN_URL . 'assets/css/admin.css', array(), SOPHIA_CHAT_VERSION);
}
add_action('admin_enqueue_scripts', 'sophia_chat_admin_styles');

/**
 * Renders the plugin settings page HTML.
 *
 * Displays icon selector, visibility options, and page ID inputs.
 * Includes inline JavaScript for show/hide field interactions.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sophia_chat_settings_page() {
    ?>
    <div class="wrap sophia-chat-settings">
        <h1><?php _e('Sophia Chat Settings', 'sophia-chat'); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('sophia_chat_options'); ?>

            <table class="form-table">
                <!-- Icon Selection -->
                <tr>
                    <th scope="row"><?php _e('Chat Icon', 'sophia-chat'); ?></th>
                    <td>
                        <fieldset>
                            <?php
                            $current_icon = get_option('sophia_chat_icon', '1');
                            $icons = sophia_chat_get_icons();
                            ?>

                            <div class="sophia-icon-options">
                                <?php foreach ($icons as $key => $label) : ?>
                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="<?php echo esc_attr($key); ?>" <?php checked($current_icon, $key); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_ICON_CDN . 'Sophia_' . $key . '.png'); ?>" alt="<?php echo esc_attr($label); ?>" width="48" height="48" onerror="this.onerror=null;this.style.background='#65758e';this.alt='<?php echo esc_attr($label); ?> (unavailable)'" />
                                    <span><?php echo esc_html($label); ?></span>
                                </label>
                                <?php endforeach; ?>

                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="custom" <?php checked($current_icon, 'custom'); ?> />
                                    <div class="sophia-custom-icon-placeholder">?</div>
                                    <span><?php _e('Custom', 'sophia-chat'); ?></span>
                                </label>
                            </div>

                            <div class="sophia-custom-icon-url" style="<?php echo $current_icon !== 'custom' ? 'display:none;' : ''; ?>">
                                <input type="url"
                                       id="sophia_chat_custom_icon_url"
                                       name="sophia_chat_custom_icon_url"
                                       value="<?php echo esc_url(get_option('sophia_chat_custom_icon_url')); ?>"
                                       class="regular-text"
                                       placeholder="https://example.com/icon.png" />
                                <p class="description"><?php _e('Enter the URL of your custom icon (recommended: 200x200px PNG).', 'sophia-chat'); ?></p>
                            </div>
                        </fieldset>
                    </td>
                </tr>

                <!-- Page Visibility -->
                <tr>
                    <th scope="row">
                        <label for="sophia_chat_visibility"><?php _e('Show Chat On', 'sophia-chat'); ?></label>
                    </th>
                    <td>
                        <?php $visibility = get_option('sophia_chat_visibility', 'all'); ?>
                        <select id="sophia_chat_visibility" name="sophia_chat_visibility">
                            <option value="all" <?php selected($visibility, 'all'); ?>><?php _e('All Pages', 'sophia-chat'); ?></option>
                            <option value="homepage" <?php selected($visibility, 'homepage'); ?>><?php _e('Homepage Only', 'sophia-chat'); ?></option>
                            <option value="specific" <?php selected($visibility, 'specific'); ?>><?php _e('Specific Pages Only', 'sophia-chat'); ?></option>
                            <option value="exclude" <?php selected($visibility, 'exclude'); ?>><?php _e('All Pages Except...', 'sophia-chat'); ?></option>
                        </select>

                        <div class="sophia-page-ids" style="<?php echo $visibility !== 'specific' ? 'display:none;' : ''; ?>">
                            <input type="text"
                                   id="sophia_chat_page_ids"
                                   name="sophia_chat_page_ids"
                                   value="<?php echo esc_attr(get_option('sophia_chat_page_ids')); ?>"
                                   class="regular-text"
                                   placeholder="1, 42, 156" />
                            <p class="description"><?php _e('Enter page/post IDs separated by commas.', 'sophia-chat'); ?></p>
                        </div>

                        <div class="sophia-exclude-ids" style="<?php echo $visibility !== 'exclude' ? 'display:none;' : ''; ?>">
                            <input type="text"
                                   id="sophia_chat_exclude_ids"
                                   name="sophia_chat_exclude_ids"
                                   value="<?php echo esc_attr(get_option('sophia_chat_exclude_ids')); ?>"
                                   class="regular-text"
                                   placeholder="1, 42, 156" />
                            <p class="description"><?php _e('Enter page/post IDs to exclude, separated by commas.', 'sophia-chat'); ?></p>
                        </div>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Show/hide custom icon URL field
        $('input[name="sophia_chat_icon"]').on('change', function() {
            if ($(this).val() === 'custom') {
                $('.sophia-custom-icon-url').show();
            } else {
                $('.sophia-custom-icon-url').hide();
            }
        });

        // Show/hide page ID fields based on visibility selection
        $('#sophia_chat_visibility').on('change', function() {
            var val = $(this).val();
            $('.sophia-page-ids, .sophia-exclude-ids').hide();
            if (val === 'specific') {
                $('.sophia-page-ids').show();
            } else if (val === 'exclude') {
                $('.sophia-exclude-ids').show();
            }
        });
    });
    </script>
    <?php
}

/**
 * Adds a 'Settings' link to the plugin row on the Plugins page.
 *
 * @since 1.0.0
 *
 * @param array $links Existing plugin action links.
 * @return array Modified links array with Settings link prepended.
 */
function sophia_chat_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=sophia-chat">' . __('Settings', 'sophia-chat') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sophia_chat_settings_link');

/**
 * Logs settings changes to the audit trail.
 *
 * Records option name, old value, new value, timestamp, and user ID.
 * Only logs changes to sophia_chat_* options. Keeps last 100 entries.
 *
 * @since 2.1.0
 *
 * @param string $option_name Name of the option being updated.
 * @param mixed  $old_value   Previous option value.
 * @param mixed  $new_value   New option value.
 * @return void
 */
function sophia_chat_log_change($option_name, $old_value, $new_value) {
    if (strpos($option_name, 'sophia_chat_') !== 0) {
        return;
    }

    if ($old_value === $new_value) {
        return;
    }

    $log = get_option('sophia_chat_audit_log', array());

    $log[] = array(
        'timestamp' => current_time('mysql'),
        'user_id'   => get_current_user_id(),
        'option'    => $option_name,
        'old_value' => $old_value,
        'new_value' => $new_value,
    );

    // Keep only the last 100 entries
    if (count($log) > 100) {
        $log = array_slice($log, -100);
    }

    update_option('sophia_chat_audit_log', $log, false);
}
add_action('updated_option', 'sophia_chat_log_change', 10, 3);

/**
 * Logs when a new sophia_chat_* option is added.
 *
 * Records option name, value, timestamp, and user ID to audit log.
 * Skips logging for the audit log option itself to prevent recursion.
 *
 * @since 2.1.0
 *
 * @param string $option_name Name of the option being added.
 * @param mixed  $value       The option value.
 * @return void
 */
function sophia_chat_log_add($option_name, $value) {
    if (strpos($option_name, 'sophia_chat_') !== 0) {
        return;
    }

    if ($option_name === 'sophia_chat_audit_log') {
        return;
    }

    $log = get_option('sophia_chat_audit_log', array());

    $log[] = array(
        'timestamp' => current_time('mysql'),
        'user_id'   => get_current_user_id(),
        'option'    => $option_name,
        'old_value' => null,
        'new_value' => $value,
    );

    if (count($log) > 100) {
        $log = array_slice($log, -100);
    }

    update_option('sophia_chat_audit_log', $log, false);
}
add_action('added_option', 'sophia_chat_log_add', 10, 2);

/**
 * Logs plugin activation to the audit trail.
 *
 * Records timestamp and user ID when the plugin is activated.
 *
 * @since 2.1.0
 *
 * @return void
 */
function sophia_chat_log_activation() {
    $log = get_option('sophia_chat_audit_log', array());

    $log[] = array(
        'timestamp' => current_time('mysql'),
        'user_id'   => get_current_user_id(),
        'option'    => 'plugin_status',
        'old_value' => 'inactive',
        'new_value' => 'active',
    );

    update_option('sophia_chat_audit_log', $log, false);
}
register_activation_hook(__FILE__, 'sophia_chat_log_activation');

/**
 * Logs plugin deactivation to the audit trail.
 *
 * Records timestamp and user ID when the plugin is deactivated.
 *
 * @since 2.1.0
 *
 * @return void
 */
function sophia_chat_log_deactivation() {
    $log = get_option('sophia_chat_audit_log', array());

    $log[] = array(
        'timestamp' => current_time('mysql'),
        'user_id'   => get_current_user_id(),
        'option'    => 'plugin_status',
        'old_value' => 'active',
        'new_value' => 'inactive',
    );

    update_option('sophia_chat_audit_log', $log, false);
}
register_deactivation_hook(__FILE__, 'sophia_chat_log_deactivation');
