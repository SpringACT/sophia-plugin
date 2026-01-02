# Sophia Chat Plugin - AI Coding Assistant Instructions

## Project Overview
Sophia Chat is a WordPress plugin that adds a chat bubble linking to sophia.chat/secure-chat for domestic violence support. The plugin displays a customizable regional avatar that opens the Sophia Chat interface in a popup window.

## Architecture & Key Components

### Plugin Structure
- **[sophia-chat.php](../sophia-chat.php)** - Single monolithic file containing all plugin logic
  - Hooks into `wp_footer` to inject chat bubble button and CSS
  - Admin settings page registered via WordPress Settings API
  - 7 main functions handling widget rendering, settings, and icon management

### Core Hooks & Filters
- `wp_footer` - Renders the chat bubble button that opens sophia.chat/secure-chat
- `admin_menu` - Registers settings page under Settings menu
- `admin_init` - Registers all settings with sanitization callbacks
- `admin_enqueue_scripts` - Loads admin CSS only on settings page
- `plugin_action_links_*` - Adds "Settings" link on plugins list

### Configuration Model
Plugin uses WordPress Options API (get_option/update_option) with these keys:
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

The chat bubble is a simple button element styled with CSS:
```css
#sophia-chat-bubble {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-image: url('icon-url');
  background-size: cover;
}
```

## Common Workflows

### Adding a New Setting
1. Register in `sophia_chat_register_settings()` with sanitization callback
2. Add form field in `sophia_chat_settings_page()` HTML
3. Access via `get_option('sophia_chat_[setting_name]')`
4. For conditional fields, use inline JavaScript in settings page (see custom icon/page ID patterns)

### Modifying Widget Output
Edit the `<style>` and `<button>` in `sophia_chat_add_widget()`:
- Button opens `https://sophia.chat/secure-chat` in a popup window
- Icon set via CSS background-image on `#sophia-chat-bubble`

### Testing Locally
WordPress plugins require:
- Local WordPress installation
- Plugin activated in admin
- Settings configured in Settings > Sophia Chat
- Click bubble to verify popup opens to sophia.chat/secure-chat

## Multi-Platform Integration
Plugin provides generic HTML/CSS snippet for non-WordPress integration in [README.md](../README.md). Keep WordPress and HTML versions in sync.

## External Dependencies
- **sophia.chat** - Chat interface opens in popup window
- **No npm/composer dependencies** - Pure PHP WordPress plugin
- **jQuery** - WordPress core dependency (used only in settings page for form interactions)
