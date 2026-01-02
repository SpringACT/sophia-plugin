<?php
/**
 * Plugin Name: Sophia Chat
 * Plugin URI: https://github.com/SpringACT/sophia-plugin
 * Description: Adds the Sophia Chat bubble to your website - providing real-time, accessible, anonymous support for individuals affected by domestic violence.
 * Version: 1.0.0
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
define('SOPHIA_CHAT_VERSION', '1.0.0');
define('SOPHIA_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SOPHIA_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Add the Sunshine Conversations chat widget to the footer
 */
function sophia_chat_add_widget() {
    // Check if we should display on this page
    if (!sophia_chat_should_display()) {
        return;
    }

    $integration_id = get_option('sophia_chat_integration_id', '');

    // Don't output anything if no integration ID is set
    if (empty($integration_id)) {
        return;
    }

    $region = get_option('sophia_chat_region', 'app');
    $icon_url = sophia_chat_get_icon_url();
    ?>
    <script>
      !function(e,n,t,r){
        function o(){try{var e;if((e="string"==typeof this.response?JSON.parse(this.response):this.response).url){var t=n.getElementsByTagName("script")[0],r=n.createElement("script");r.async=!0,r.src=e.url,t.parentNode.insertBefore(r,t)}}catch(e){}}var s,p,a,i=[],c=[];e[t]={init:function(){s=arguments;var e={then:function(n){return c.push({type:"t",next:n}),e},catch:function(n){return c.push({type:"c",next:n}),e}};return e},on:function(){i.push(arguments)},render:function(){p=arguments},destroy:function(){a=!0}},e.__onWebMessengerHostReady__=function(n){if(a)n.destroy();else{for(var t=0;t<i.length;t++)n.on.apply(n,i[t]);for(t=0;t<c.length;t++){var r=c[t];"t"===r.type?n.then(r.next):n.catch(r.next)}p&&n.render.apply(n,p),n.init.apply(n,s)}},function(){var e=new XMLHttpRequest;e.addEventListener("load",o),e.open("GET","https://<?php echo esc_js($region); ?>.smooch.io/loader.json",!0),e.responseType="json",e.send()}()
      }(window,document,"Smooch");

      Smooch.init({
        integrationId: '<?php echo esc_js($integration_id); ?>',
        <?php if ($icon_url) : ?>
        customColors: {
          brandColor: '65758e',
        },
        businessIconUrl: '<?php echo esc_js($icon_url); ?>',
        <?php endif; ?>
      }).then(function() {
        console.log('Sophia Chat initialized');
      });
    </script>
    <?php
}
add_action('wp_footer', 'sophia_chat_add_widget');

/**
 * Check if chat should display on current page
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
 * Get the selected icon URL
 */
function sophia_chat_get_icon_url() {
    $icon = get_option('sophia_chat_icon', 'default');

    if ($icon === 'none') {
        return '';
    }

    if ($icon === 'custom') {
        return get_option('sophia_chat_custom_icon_url', '');
    }

    // Return built-in icon URL
    $icons = array(
        'default' => SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-default.png',
        'purple'  => SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-purple.png',
        'blue'    => SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-blue.png',
        'green'   => SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-green.png',
    );

    return isset($icons[$icon]) ? $icons[$icon] : $icons['default'];
}

/**
 * Add settings page to admin menu
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
 * Register plugin settings
 */
function sophia_chat_register_settings() {
    register_setting('sophia_chat_options', 'sophia_chat_integration_id', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_region', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_icon', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_custom_icon_url', 'esc_url_raw');
    register_setting('sophia_chat_options', 'sophia_chat_visibility', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_page_ids', 'sanitize_text_field');
    register_setting('sophia_chat_options', 'sophia_chat_exclude_ids', 'sanitize_text_field');
}
add_action('admin_init', 'sophia_chat_register_settings');

/**
 * Enqueue admin styles
 */
function sophia_chat_admin_styles($hook) {
    if ($hook !== 'settings_page_sophia-chat') {
        return;
    }
    wp_enqueue_style('sophia-chat-admin', SOPHIA_CHAT_PLUGIN_URL . 'assets/css/admin.css', array(), SOPHIA_CHAT_VERSION);
}
add_action('admin_enqueue_scripts', 'sophia_chat_admin_styles');

/**
 * Settings page HTML
 */
function sophia_chat_settings_page() {
    ?>
    <div class="wrap sophia-chat-settings">
        <h1><?php _e('Sophia Chat Settings', 'sophia-chat'); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('sophia_chat_options'); ?>

            <table class="form-table">
                <!-- Integration ID -->
                <tr>
                    <th scope="row">
                        <label for="sophia_chat_integration_id"><?php _e('Integration ID', 'sophia-chat'); ?></label>
                    </th>
                    <td>
                        <input type="text"
                               id="sophia_chat_integration_id"
                               name="sophia_chat_integration_id"
                               value="<?php echo esc_attr(get_option('sophia_chat_integration_id')); ?>"
                               class="regular-text"
                               required />
                        <p class="description"><?php _e('Your Sophia Chat Integration ID. Contact SpringACT if you don\'t have one.', 'sophia-chat'); ?></p>
                    </td>
                </tr>

                <!-- Region -->
                <tr>
                    <th scope="row">
                        <label for="sophia_chat_region"><?php _e('Region', 'sophia-chat'); ?></label>
                    </th>
                    <td>
                        <select id="sophia_chat_region" name="sophia_chat_region">
                            <option value="app" <?php selected(get_option('sophia_chat_region'), 'app'); ?>><?php _e('US (Default)', 'sophia-chat'); ?></option>
                            <option value="app-eu-1" <?php selected(get_option('sophia_chat_region'), 'app-eu-1'); ?>><?php _e('EU', 'sophia-chat'); ?></option>
                        </select>
                        <p class="description"><?php _e('Select the region closest to your users.', 'sophia-chat'); ?></p>
                    </td>
                </tr>

                <!-- Icon Selection -->
                <tr>
                    <th scope="row"><?php _e('Chat Icon', 'sophia-chat'); ?></th>
                    <td>
                        <fieldset>
                            <?php $current_icon = get_option('sophia_chat_icon', 'default'); ?>

                            <div class="sophia-icon-options">
                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="default" <?php checked($current_icon, 'default'); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-default.png'); ?>" alt="Default" width="48" height="48" />
                                    <span><?php _e('Default', 'sophia-chat'); ?></span>
                                </label>

                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="purple" <?php checked($current_icon, 'purple'); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-purple.png'); ?>" alt="Purple" width="48" height="48" />
                                    <span><?php _e('Purple', 'sophia-chat'); ?></span>
                                </label>

                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="blue" <?php checked($current_icon, 'blue'); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-blue.png'); ?>" alt="Blue" width="48" height="48" />
                                    <span><?php _e('Blue', 'sophia-chat'); ?></span>
                                </label>

                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="green" <?php checked($current_icon, 'green'); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/sophia-green.png'); ?>" alt="Green" width="48" height="48" />
                                    <span><?php _e('Green', 'sophia-chat'); ?></span>
                                </label>

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
 * Add settings link on plugins page
 */
function sophia_chat_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=sophia-chat">' . __('Settings', 'sophia-chat') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sophia_chat_settings_link');
