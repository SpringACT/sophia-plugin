# Sophia Chat Plugin - AI Coding Assistant Instructions

## Project Overview
Sophia Chat is a WordPress plugin that integrates Chatbase chatbot for domestic violence support. The plugin embeds a chat widget on WordPress sites with region/language-specific avatar customization (via CSS injection) and granular page visibility controls.

## Architecture & Key Components

### Plugin Structure
- **[sophia-chat.php](../sophia-chat.php)** - Single monolithic file containing all plugin logic
  - Hooks into `wp_footer` to inject Chatbase JavaScript embed and custom CSS
  - Admin settings page registered via WordPress Settings API
  - 7 main functions handling widget rendering, settings, and icon management

### Core Hooks & Filters
- `wp_footer` - Renders the Chatbase embed script and icon override CSS
- `admin_menu` - Registers settings page under Settings menu
- `admin_init` - Registers all settings with sanitization callbacks
- `admin_enqueue_scripts` - Loads admin CSS only on settings page
- `plugin_action_links_*` - Adds "Settings" link on plugins list

### Configuration Model
Plugin uses WordPress Options API (get_option/update_option) with these keys:
- `sophia_chat_chatbot_id` - Chatbase chatbot identifier (default: `Nq3vVo-7E8qgwlPRzAn9g`)
- `sophia_chat_icon` - Selected avatar key from 21 regional options
- `sophia_chat_custom_icon_url` - Custom icon fallback (if icon='custom')
- `sophia_chat_visibility` - Display strategy: `all`, `homepage`, `specific`, `exclude`
- `sophia_chat_page_ids` / `sophia_chat_exclude_ids` - Comma-separated post/page IDs

## Developer Patterns

### Security Practice
- **Sanitization**: All options sanitized on save (sanitize_text_field, esc_url_raw)
- **Escaping**: Admin panel uses esc_attr/esc_html/esc_js; frontend uses esc_js/esc_url for output
- **Capability Check**: Settings page restricted to 'manage_options' capability

### WordPress Conventions
- Inline JavaScript within PHP (no separate .js files for widget initialization)
- Admin CSS in [assets/css/admin.css](../assets/css/admin.css) with no dependencies
- Icon assets in [assets/icons/Sophias/](../assets/icons/Sophias/) following pattern: `Sophia_[RegionKey].png`
- Localization strings wrapped with `__()` and `_e()` (text domain: 'sophia-chat')

### Icon System
21 regional avatar icons organized by geography with inclusive variants:
- **Europe**: WesternEurope, CentralEurope, SouthernEurope, EasternEurope
- **Africa**: EastAfrica, EastAfricaAlt, NorthEastAfrica, WestAfrica
- **Americas**: LatinAmerica, LatinAmericaAlt
- **Asia**: EastAsia, SouthAsia, SoutheastAsia, AsiaPacific, PersianRegion, MiddleEast, PacificIslands
- **Inclusive**: IndigenousContexts, GenderInclusive
- **Default**: Standard

Icons are applied via CSS injection that overrides the Chatbase bubble button:
```css
#chatbase-bubble-button {
  background-image: url('icon-url') !important;
  background-size: cover !important;
}
#chatbase-bubble-button svg,
#chatbase-bubble-button img {
  display: none !important;
}
```

## Common Workflows

### Adding a New Setting
1. Register in `sophia_chat_register_settings()` with sanitization callback
2. Add form field in `sophia_chat_settings_page()` HTML
3. Access via `get_option('sophia_chat_[setting_name]')`
4. For conditional fields, use inline JavaScript in settings page (see custom icon/page ID patterns)

### Modifying Widget Output
Edit the inline `<script>` and `<style>` blocks in `sophia_chat_add_widget()`:
- Chatbase config via `window.embeddedChatbotConfig`
- Icon override via injected CSS targeting `#chatbase-bubble-button`

### Testing Locally
WordPress plugins require:
- Local WordPress installation
- Plugin activated in admin
- Settings configured in Settings > Sophia Chat
- Browser dev tools to verify Chatbase widget loads and icon CSS applies

## Multi-Platform Integration
Plugin provides generic JavaScript/CSS snippet for non-WordPress integration in [README.md](../README.md). Keep WordPress and HTML/JS versions in sync when updating Chatbase initialization logic.

## External Dependencies
- **Chatbase** - Third-party service (embed.min.js loaded from www.chatbase.co)
- **No npm/composer dependencies** - Pure PHP WordPress plugin
- **jQuery** - WordPress core dependency (used only in settings page for form interactions)
