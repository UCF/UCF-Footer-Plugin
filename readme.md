# UCF Footer Plugin #

Provides styles and functionality for displaying a consistent branded footer bar for UCF sites.


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "Settings > UCF Footer".

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Footer-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "Settings > UCF Footer".


## Changelog ##

### 1.0.2 ###
* Enhancements:
    * Added `ucf_footer_display_footer` filter which allows logic to be implemented for when to display the footer.

### 1.0.1 ###
* Bug Fixes:
  * Upadtes the way the menu feeds are pulled to avoid problems when the feed domain is external.

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Installation Requirements ##

* Ensure your activated theme calls `wp_footer()` immediately before the template's closing `<body>` tag.  `wp_footer()` should not be called from within any element with an explicit or max width (the UCF footer should span the full width of the page.)
* The current activated theme must enqueue a Cloud.Typography CSS Key that corresponds to a font project with Gotham Light enabled.  This plugin does not provide any custom webfonts.


## Development & Contributing ##

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.

### Wishlist/TODOs ###
* Move footer CSS to a CDN or other single, consistent location?
