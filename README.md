# Sophia Chat

Add the Sophia Chat bubble to your website. Sophia provides real-time, accessible, anonymous support and resources for individuals affected by domestic violence.

## Getting Started

Sophia Chat works out of the box with the default Chatbot ID. Simply install and choose your preferred Sophia icon.

---

## Installation Options

- [WordPress](#wordpress)
- [Direct HTML/JavaScript](#direct-htmljavascript)
- [Drupal](#drupal)
- [Joomla](#joomla)
- [Squarespace](#squarespace)
- [Wix](#wix)
- [SharePoint](#sharepoint)
- [Google Sites](#google-sites)
- [Plone](#plone)

---

## WordPress

WordPress is commonly used by NGOs, government agencies, and humanitarian organizations.

### Option 1: Download Plugin

1. Download the latest release from [GitHub Releases](https://github.com/SpringACT/sophia-plugin/releases)
2. In WordPress admin, go to **Plugins > Add New > Upload Plugin**
3. Upload the `.zip` file and click **Install Now**
4. Click **Activate**
5. Go to **Settings > Sophia Chat** and choose your preferred Sophia icon

### Option 2: Manual Installation

1. Download or clone this repository
2. Upload the `sophia-plugin` folder to `/wp-content/plugins/`
3. Activate **Sophia Chat** in the Plugins menu
4. Configure in **Settings > Sophia Chat**

### WordPress Settings

| Setting | Description |
|---------|-------------|
| **Chat Icon** | Choose from 20 Sophia avatars or use a custom icon |
| **Show Chat On** | All pages, homepage only, specific pages, or exclude pages |

---

## Direct HTML/JavaScript

For any website (including UN systems, custom government portals, or static sites), add this code before the closing `</body>` tag:

```html
<!-- Sophia Chat Widget -->
<style>
  #sophia-chat-bubble {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 999999;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background-color: #65758e;
    background-image: url('ICON_URL_HERE');
    background-size: cover;
    background-position: center;
    border: none;
    padding: 0;
  }
  #sophia-chat-bubble:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
  }
</style>
<button id="sophia-chat-bubble"
        onclick="window.open('https://sophia.chat/secure-chat', 'SophiaChat', 'width=400,height=600,scrollbars=yes,resizable=yes')"
        aria-label="Chat with Sophia"
        title="Chat with Sophia">
</button>
```

Replace `ICON_URL_HERE` with your chosen Sophia icon URL from the table below.

---

## Drupal

Popular with governments, universities, and large NGOs.

### Option 1: Block

1. Go to **Structure > Block layout**
2. Add a **Custom block** in the Footer region
3. Set text format to **Full HTML**
4. Paste the [JavaScript code](#direct-htmljavascript)
5. Save

### Option 2: Theme Template

1. Edit your theme's `html.html.twig`
2. Add the [JavaScript code](#direct-htmljavascript) before `</body>`
3. Clear cache

---

## Joomla

Used by many government agencies and NGOs worldwide.

### Option 1: Custom HTML Module

1. Go to **Extensions > Modules > New**
2. Select **Custom**
3. Paste the [JavaScript code](#direct-htmljavascript)
4. Set position to **debug** (or any footer position)
5. Save and enable

### Option 2: Template Override

1. Navigate to your template folder
2. Edit `index.php`
3. Add the [JavaScript code](#direct-htmljavascript) before `</body>`

---

## Squarespace

1. Go to **Settings > Advanced > Code Injection**
2. In the **Footer** section, paste the [JavaScript code](#direct-htmljavascript)
3. Click **Save**

---

## Wix

1. Go to **Settings > Custom Code**
2. Click **Add Custom Code**
3. Paste the [JavaScript code](#direct-htmljavascript)
4. Set placement to **Body - end**
5. Apply to **All pages**
6. Click **Apply**

---

## SharePoint

Used by many UN agencies and government organizations.

### SharePoint Online (Modern)

1. Go to **Site Settings > Site Pages**
2. Edit the page where you want to add the chat
3. Add a **Script Editor** or **Embed** web part
4. Paste the [JavaScript code](#direct-htmljavascript)
5. Publish the page

### SharePoint (Classic)

1. Edit the page
2. Add a **Content Editor** web part
3. Click **Edit Source**
4. Paste the [JavaScript code](#direct-htmljavascript)
5. Save

**Note:** You may need to allow custom scripts in SharePoint admin settings.

---

## Google Sites

1. In Google Sites editor, click **Insert > Embed**
2. Select **Embed code**
3. Paste the [JavaScript code](#direct-htmljavascript)
4. Click **Insert**
5. Publish your site

---

## Plone

Used by many UN agencies, governments, and research institutions.

### Option 1: Through-the-web

1. Go to **Site Setup > Theming**
2. Edit your theme's `index.html` or use a custom JavaScript registry
3. Add the [JavaScript code](#direct-htmljavascript)

### Option 2: Custom Add-on

Add to your theme's `main_template`:

```xml
<metal:script fill-slot="javascript_head_slot">
  <!-- Paste JavaScript code here -->
</metal:script>
```

---

## Choosing a Sophia Icon

### Easy Way: Code Generator

Use our **[Code Generator](https://springact.github.io/sophia-plugin/generator.html)** to select your Sophia icon and get ready-to-use code.

### Manual Way

Pick an icon URL from the table below and use it in the [Direct HTML/JavaScript](#direct-htmljavascript) code above.

### Available Sophia Icons

| Icon | URL (copy this) |
|------|-----------------|
| 1 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_1.png` |
| 2 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_2.png` |
| 6 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_6.png` |
| 7 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_7.png` |
| 9 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_9.png` |
| 10 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_10.png` |
| 11 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_11.png` |
| 12 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_12.png` |
| 13 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_13.png` |
| 14 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_14.png` |
| 15 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_15.png` |
| 16 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_16.png` |
| 17 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_17.png` |
| 18 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_18.png` |
| 20 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_20.png` |
| 21 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_21.png` |
| 22 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_22.png` |
| 23 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_23.png` |
| 24 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_24.png` |
| 25 | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_25.png` |

---

## Need Help?

If your platform isn't listed or you need assistance with integration:

- **Issues:** [GitHub Issues](https://github.com/SpringACT/sophia-plugin/issues)
- **Contact:** [SpringACT](https://springact.org)

## License

GPL v2 or later - see [LICENSE](LICENSE) for details.
