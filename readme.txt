=== UCF Footer Plugin ===
Contributors: ucfwebcom
Tags: ucf, footer, template
Requires at least: 4.9.6
Tested up to: 5.3
Stable tag: 1.0.8
Requires PHP: 5.4
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides styles and functionality for displaying a consistent branded footer bar for UCF sites.


== Installation ==

= Manual Installation =
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "Settings > UCF Footer".

= WP CLI Installation =
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Footer-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "Settings > UCF Footer".

= Installation Requirements =
* Ensure your activated theme calls `wp_footer()` immediately before the template's closing `<body>` tag.  `wp_footer()` should not be called from within any element with an explicit or max width (the UCF footer should span the full width of the page.)
* The current activated theme must enqueue the Athena Framework, and/or a Cloud.Typography CSS Key that corresponds to a font project with Gotham ScreenSmart Regular enabled.  This plugin does not provide any custom webfonts.


== Changelog ==

= 1.0.8 =
Enhancements:
* Added asynchonous loading of styles for the footer
* Upgraded packages

= 1.0.7 =
Enhancements:
* Added cache-busting to the plugin's enqueued stylesheet
* Added unique `aria-label` value to wrapper `<footer>` element
* Added linter configs, Github issue/PR templates, and CONTRIBUTING doc to repo
* Upgraded packages and gulpfile

= 1.0.6 =
Enhancements:
* Added instagram logo for the social menu in the footer

= 1.0.5 =
Bug Fixes:
* Updated default social/footer menu URLs
* Updated footer font stack to work with sites utilizing the Athena Framework without premium webfonts

Enhancements:
* Added underlines to links surrounding the address text for contrast/distinguish-ability as links

= 1.0.4 =
Enhancements:
* Updated ucf.edu links to point to https
* Added nofollow to telephone link

= 1.0.3 =
Bug Fixes:
* Fixed warning due to missing argument in `apply_filters()` in `UCF_Footer_Common::display_footer()`
* Updated methods in `UCF_Footer_Common` to be static
* Updated `.ucf-footer` to be a semantic footer element

= 1.0.2 =
Enhancements:
* Added `ucf_footer_display_footer` filter which allows logic to be implemented for when to display the footer.

= 1.0.1 =
Bug Fixes:
* Updates the way the menu feeds are pulled to avoid problems when the feed domain is external.

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Development ==

Note that compiled, minified css files are included within the repo.  Changes to these files should be tracked via git (so that users installing the plugin using traditional installation methods will have a working plugin out-of-the-box.)

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

= Requirements =
* node
* gulp-cli

= Instructions =
1. Clone the UCF-Footer-Plugin repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/UCF-Footer-Plugin.git`
2. `cd` into the new UCF-Footer-Plugin directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Optional: If you'd like to enable [BrowserSync](https://browsersync.io) for local development, or make other changes to this project's default gulp configuration, copy `gulp-config.template.json`, make any desired changes, and save as `gulp-config.json`.

    To enable BrowserSync, set `sync` to `true` and assign `syncTarget` the base URL of a site on your local WordPress instance that will use this plugin, such as `http://localhost/wordpress/my-site/`.  Your `syncTarget` value will vary depending on your local host setup.

    The full list of modifiable config values can be viewed in `gulpfile.js` (see `config` variable).
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against.
5. Activate this plugin on your development WordPress site.
6. Configure plugin settings from the WordPress admin under "Settings > UCF Footer".
7. Run `gulp watch` to continuously watch changes to scss files.  If you enabled BrowserSync in `gulp-config.json`, it will also reload your browser when plugin files change.

= Other Notes =
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.  See the [contributing guidelines](https://github.com/UCF/UCF-Footer-Plugin/blob/master/CONTRIBUTING.md) for more information.


== Contributing ==

Want to submit a bug report or feature request?  Check out our [contributing guidelines](https://github.com/UCF/UCF-Footer-Plugin/blob/master/CONTRIBUTING.md) for more information.  We'd love to hear from you!
