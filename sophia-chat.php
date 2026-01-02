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
define('SOPHIA_CHAT_VERSION', '2.0.0');
define('SOPHIA_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SOPHIA_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SOPHIA_CHAT_DEFAULT_AGENT_ID', 'Nq3vVo-7E8qgwlPRzAn9g');

/**
 * Add the Chatbase chat widget to the footer
 */
function sophia_chat_add_widget() {
    // Check if we should display on this page
    if (!sophia_chat_should_display()) {
        return;
    }

    $chatbot_id = get_option('sophia_chat_chatbot_id', SOPHIA_CHAT_DEFAULT_AGENT_ID);

    // Don't output anything if no chatbot ID is set
    if (empty($chatbot_id)) {
        return;
    }

    $icon_url = sophia_chat_get_icon_url();
    ?>
    <!-- Chatbase Widget -->
    <script>
      window.embeddedChatbotConfig = {
        chatbotId: "<?php echo esc_js($chatbot_id); ?>",
        domain: "www.chatbase.co"
      }
    </script>
    <script src="https://www.chatbase.co/embed.min.js" chatbotId="<?php echo esc_attr($chatbot_id); ?>" domain="www.chatbase.co" defer></script>

    <?php if ($icon_url) : ?>
    <!-- Custom Sophia Icon Override -->
    <style>
      #chatbase-bubble-button {
        background-image: url('<?php echo esc_url($icon_url); ?>') !important;
        background-size: cover !important;
        background-position: center !important;
        border-radius: 50% !important;
      }
      #chatbase-bubble-button svg,
      #chatbase-bubble-button img {
        display: none !important;
      }
    </style>
    <?php endif; ?>
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
 * Get available Sophia icons
 */
function sophia_chat_get_icons() {
    return array(
        'WesternEurope'         => __('Western Europe', 'sophia-chat'),
        'CentralEurope'         => __('Central Europe', 'sophia-chat'),
        'SouthernEurope'        => __('Southern Europe', 'sophia-chat'),
        'EasternEurope'         => __('Eastern Europe', 'sophia-chat'),
        'EasternEuropeEurasia'  => __('Eastern Europe & Eurasia', 'sophia-chat'),
        'MiddleEast'            => __('Middle East', 'sophia-chat'),
        'PersianRegion'         => __('Persian Region', 'sophia-chat'),
        'NorthAmerica'          => __('North America', 'sophia-chat'),
        'LatinAmerica'          => __('Latin America', 'sophia-chat'),
        'LatinAmericaPT'        => __('Latin America (Portuguese)', 'sophia-chat'),
        'EastAfrica'            => __('East Africa', 'sophia-chat'),
        'EastAfricaAlt'         => __('East Africa (Alt)', 'sophia-chat'),
        'NorthEastAfrica'       => __('North East Africa', 'sophia-chat'),
        'WestAfrica'            => __('West Africa', 'sophia-chat'),
        'EastAsia'              => __('East Asia', 'sophia-chat'),
        'SouthAsia'             => __('South Asia', 'sophia-chat'),
        'SoutheastAsia'         => __('Southeast Asia', 'sophia-chat'),
        'AsiaPacific'           => __('Asia Pacific', 'sophia-chat'),
        'PacificIslands'        => __('Pacific Islands', 'sophia-chat'),
        'IndigenousContexts'    => __('Indigenous Contexts', 'sophia-chat'),
        'GenderInclusive'       => __('Gender Inclusive', 'sophia-chat'),
    );
}

/**
 * Get the selected icon URL
 */
function sophia_chat_get_icon_url() {
    $icon = get_option('sophia_chat_icon', 'WesternEurope');

    if ($icon === 'none') {
        return '';
    }

    if ($icon === 'custom') {
        return get_option('sophia_chat_custom_icon_url', '');
    }

    // Return built-in icon URL
    $icons = sophia_chat_get_icons();
    if (isset($icons[$icon])) {
        return SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/Sophias/Sophia_' . $icon . '.png';
    }

    return SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/Sophias/Sophia_WesternEurope.png';
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
    register_setting('sophia_chat_options', 'sophia_chat_chatbot_id', 'sanitize_text_field');
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
                <!-- Chatbot ID -->
                <tr>
                    <th scope="row">
                        <label for="sophia_chat_chatbot_id"><?php _e('Chatbot ID', 'sophia-chat'); ?></label>
                    </th>
                    <td>
                        <input type="text"
                               id="sophia_chat_chatbot_id"
                               name="sophia_chat_chatbot_id"
                               value="<?php echo esc_attr(get_option('sophia_chat_chatbot_id', SOPHIA_CHAT_DEFAULT_AGENT_ID)); ?>"
                               class="regular-text"
                               placeholder="<?php echo esc_attr(SOPHIA_CHAT_DEFAULT_AGENT_ID); ?>" />
                        <p class="description"><?php _e('The Sophia Chatbot ID. Leave as default unless instructed otherwise by SpringACT.', 'sophia-chat'); ?></p>
                    </td>
                </tr>

                <!-- Icon Selection -->
                <tr>
                    <th scope="row"><?php _e('Chat Icon', 'sophia-chat'); ?></th>
                    <td>
                        <fieldset>
                            <?php
                            $current_icon = get_option('sophia_chat_icon', 'WesternEurope');
                            $icons = sophia_chat_get_icons();
                            ?>

                            <div class="sophia-icon-options">
                                <?php foreach ($icons as $key => $label) : ?>
                                <label class="sophia-icon-option">
                                    <input type="radio" name="sophia_chat_icon" value="<?php echo esc_attr($key); ?>" <?php checked($current_icon, $key); ?> />
                                    <img src="<?php echo esc_url(SOPHIA_CHAT_PLUGIN_URL . 'assets/icons/Sophias/Sophia_' . $key . '.png'); ?>" alt="<?php echo esc_attr($label); ?>" width="48" height="48" />
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
 * Add settings link on plugins page
 */
function sophia_chat_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=sophia-chat">' . __('Settings', 'sophia-chat') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sophia_chat_settings_link');
