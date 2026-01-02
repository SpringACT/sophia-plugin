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
| **Chatbot ID** | The Sophia Chatbot ID (pre-filled with default) |
| **Chat Icon** | Choose from 21 regional Sophia avatars or use a custom icon |
| **Show Chat On** | All pages, homepage only, specific pages, or exclude pages |

---

## Direct HTML/JavaScript

For any website (including UN systems, custom government portals, or static sites), add this code before the closing `</body>` tag:

```html
<!-- Chatbase Widget -->
<script>
  window.embeddedChatbotConfig = {
    chatbotId: "Nq3vVo-7E8qgwlPRzAn9g",
    domain: "www.chatbase.co"
  }
</script>
<script src="https://www.chatbase.co/embed.min.js" chatbotId="Nq3vVo-7E8qgwlPRzAn9g" domain="www.chatbase.co" defer></script>
```

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

### Manual Way: Copy & Paste

1. Pick an icon from the table below
2. Copy the complete code snippet
3. Replace `ICON_URL_HERE` with your chosen icon URL

```html
<!-- Chatbase Widget with Custom Sophia Icon -->
<script>
  window.embeddedChatbotConfig = {
    chatbotId: "Nq3vVo-7E8qgwlPRzAn9g",
    domain: "www.chatbase.co"
  }
</script>
<script src="https://www.chatbase.co/embed.min.js" chatbotId="Nq3vVo-7E8qgwlPRzAn9g" domain="www.chatbase.co" defer></script>
<style>
  #chatbase-bubble-button {
    background-image: url('ICON_URL_HERE') !important;
    background-size: cover !important;
    background-position: center !important;
    border-radius: 50% !important;
  }
  #chatbase-bubble-button svg,
  #chatbase-bubble-button img {
    display: none !important;
  }
</style>
```

### Available Sophia Icons

| Region | Icon URL (copy this) |
|--------|----------------------|
| Western Europe | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_WesternEurope.png` |
| Central Europe | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_CentralEurope.png` |
| Southern Europe | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_SouthernEurope.png` |
| Eastern Europe | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_EasternEurope.png` |
| Eastern Europe & Eurasia | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_EasternEuropeEurasia.png` |
| Middle East | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_MiddleEast.png` |
| Persian Region | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_PersianRegion.png` |
| North America | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_NorthAmerica.png` |
| Latin America | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_LatinAmerica.png` |
| Latin America (Portuguese) | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_LatinAmericaPT.png` |
| East Africa | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_EastAfrica.png` |
| East Africa (Alt) | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_EastAfricaAlt.png` |
| North East Africa | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_NorthEastAfrica.png` |
| West Africa | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_WestAfrica.png` |
| East Asia | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_EastAsia.png` |
| South Asia | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_SouthAsia.png` |
| Southeast Asia | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_SoutheastAsia.png` |
| Asia Pacific | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_AsiaPacific.png` |
| Pacific Islands | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_PacificIslands.png` |
| Indigenous Contexts | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_IndigenousContexts.png` |
| Gender Inclusive | `https://raw.githubusercontent.com/SpringACT/sophia-plugin/main/assets/icons/Sophias/Sophia_GenderInclusive.png` |

---

## Need Help?

If your platform isn't listed or you need assistance with integration:

- **Issues:** [GitHub Issues](https://github.com/SpringACT/sophia-plugin/issues)
- **Contact:** [SpringACT](https://springact.org)

## License

GPL v2 or later - see [LICENSE](LICENSE) for details.
