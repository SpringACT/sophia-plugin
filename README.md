# Sophia Chat

Add the Sophia Chat bubble to your website. Sophia provides real-time, accessible, anonymous support and resources for individuals affected by domestic violence.

## Getting Started

To add Sophia Chat to your website, you'll need an **Integration ID**. Contact [SpringACT](https://springact.org) to get one.

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
5. Go to **Settings > Sophia Chat** and enter your Integration ID

### Option 2: Manual Installation

1. Download or clone this repository
2. Upload the `sophia-plugin` folder to `/wp-content/plugins/`
3. Activate **Sophia Chat** in the Plugins menu
4. Configure in **Settings > Sophia Chat**

### WordPress Settings

| Setting | Description |
|---------|-------------|
| **Integration ID** | Your unique Sophia Chat identifier (required) |
| **Region** | Select US or EU based on your users' location |
| **Chat Icon** | Choose from 21 regional Sophia avatars or use a custom icon |
| **Show Chat On** | All pages, homepage only, specific pages, or exclude pages |

---

## Direct HTML/JavaScript

For any website (including UN systems, custom government portals, or static sites), add this code before the closing `</body>` tag:

```html
<script>
  !function(e,n,t,r){
    function o(){try{var e;if((e="string"==typeof this.response?JSON.parse(this.response):this.response).url){var t=n.getElementsByTagName("script")[0],r=n.createElement("script");r.async=!0,r.src=e.url,t.parentNode.insertBefore(r,t)}}catch(e){}}var s,p,a,i=[],c=[];e[t]={init:function(){s=arguments;var e={then:function(n){return c.push({type:"t",next:n}),e},catch:function(n){return c.push({type:"c",next:n}),e}};return e},on:function(){i.push(arguments)},render:function(){p=arguments},destroy:function(){a=!0}},e.__onWebMessengerHostReady__=function(n){if(a)n.destroy();else{for(var t=0;t<i.length;t++)n.on.apply(n,i[t]);for(t=0;t<c.length;t++){var r=c[t];"t"===r.type?n.then(r.next):n.catch(r.next)}p&&n.render.apply(n,p),n.init.apply(n,s)}},function(){var e=new XMLHttpRequest;e.addEventListener("load",o),e.open("GET","https://app.smooch.io/loader.json",!0),e.responseType="json",e.send()}()
  }(window,document,"Smooch");

  Smooch.init({
    integrationId: 'YOUR_INTEGRATION_ID'
  });
</script>
```

Replace `YOUR_INTEGRATION_ID` with the Integration ID provided by SpringACT.

### EU Region

If your users are primarily in Europe, change the loader URL:

```javascript
e.open("GET","https://app-eu-1.smooch.io/loader.json",!0)
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

## Custom Icon (Optional)

To use a custom Sophia avatar, add the `businessIconUrl` option:

```javascript
Smooch.init({
  integrationId: 'YOUR_INTEGRATION_ID',
  businessIconUrl: 'https://your-site.com/path/to/icon.png'
});
```

Recommended icon size: 200x200 pixels, PNG format.

---

## Need Help?

If your platform isn't listed or you need assistance with integration:

- **Issues:** [GitHub Issues](https://github.com/SpringACT/sophia-plugin/issues)
- **Contact:** [SpringACT](https://springact.org)

## License

GPL v2 or later - see [LICENSE](LICENSE) for details.
