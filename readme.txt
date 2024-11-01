=== Plugin Name ===
Contributors: SdeWijs
Donate link: https://www.mollie.com/pay/link/1006571/D2A4A1C0/2.5/Koffie%20voor%20de%20Grinthorst/a60be34ef573cefa17c1a00e90002f526b723683
Tags: images, zoomify, shortcode
Requires at least: 3.0.1
Tested up to: 6.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin offers an easy way to embed zoomify .zif files in your WordPress website.

== Description ==

This Zoomify plugin for WordPress allows you to upload .zif files to your media directory. You can then create the Zoomify imagebox
with toolbar by using the shortcode `[zoomify file="fileUrl" zskinpath="Default/Dark/Light" zoomlevel=100]` (zoomlevel is optional), where "fileUrl" is the url/permalink to the zif-file.
The skin parameter has three options: Default, Dark and Light. If the skin parameter is omitted in the shortcode the Default skin will be used.

For example, if the permalink to your file is http://example.com/wp-content/uploads/2016/10/myAwesomemap.zif, the shortcode will look like this

`[zoomify file="http://example.com/wp-content/uploads/2016/10/myAwesomemap.zif" zskinpath="Default"]`

If copy-pasting this example does not work, please type out the shortcode manually in your WP editor so the double quotes are properly formatted.

I am not connected to Zoomify in any way, I coded this plugin for personal use and figured this may come in handy for other Zoomify users.

Each Zoomify image had it's own unique identifier, so you can add muiltiple Zoomify images to a page.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly (reccommended).
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to the Zoomify settingspage in the admin dashboard and upload the JS file which was included with the Zoomify software, select your Zoomify version and save the settings.
4. Upload your .zif files via the WordPress media section
5. Use the shortcode [zoomify file="fileUrl" skin="Default"] shortcode to create the Zoomify box on any post or page.


== Frequently Asked Questions ==

= I have a Pro/Enterprise version of Zoomify, can I use those options too? =

The plugin now has the option to upload your Pro, Express of Enterprise JavaScript file so you can use it with your Zoomify files. I will add specific options for those in upcoming releases. Please drop me an email and let me know which Pro/Enterprise options you use the most and I will add those first.

= What Zoomify options can I use in this plugin =

This plugin now supports all options that are available in Zoomify Free edition:
* zskinpath
* zinitialx
* zinitialy
* zinitialzoom
* zminzoom
* zmaxzoom
* znavigatorvisible
* ztoolbarvisible
* zslidervisible
* zlogovisible
* zfullpagevisible
* zfullpageinitial
* zprogressvisible
* ztooltipsvisible
* ztoolbarsize (standard or large) (This sets the size of the skin toolbar)
* zcomparisonpath

Please use the notation for the parameters as described above. The plugin translates these to the parameters Zoomify needs. The Zoomify documentation provides more detail about the parameters and their settings.

= Can I have more then one Zoomify image on a page or post? =

Yes, each Zoomify image is provided with an unique ID to prevent conflicts on the page.

= Can I add more skins to the plugin? =

There are 2 ways to add new skins. First and recommended, you upload the skin folder to your wp-content/uploads directory. 
After this, you add the full URL to your new skin folder in the zskinpath parameter. For example zskinpath="https://example.com/wp-content/uploads/customskinfolder" 
(please check the exact URL to your uploads folder and name of the custom skin folder).
Second, least recommended method: By uploading your custom skins to [your site url]/wp-content/plugins/gh-zoomify/assets/Skins] directory and use the foldername in the
shortcode. Please use the Zoomify style to name the folder. First letter uppercase and no spaces. For example 'Mycustomskin'. Warning, when updating the plugin any Skins added in the plugin directory will be overwritten. 

= Can I apply extra styling to the Zoomify container block? =

The styling of the containerblock is kept as clean as possible, so you can style away by selecting #zoomifyContainer in your own CSS file
or your theme's custom CSS section.

== Screenshots ==


== Changelog ==
= 1.5.2 =
* Remove deprecated zToolbarBackgroundVisible parameter, add missing zToolbarSize

= 1.5.1 =
* Add fallback for the case were Zoomify JS was not yet uploaded

= 1.5 =
* Update readme
* Please upload your own copy of the Zoomify js for your version (Express, Enterprise or Pro)
* From this version and upwards, your uploaded Zoomify js file will be stored in the uploads/gh-zoomify-embed folder (or your custom uploads folder if defined in your wp-config), so it does not get overwritten after updating this plugin.
* Add zcomparisonpath parameter
* If the file is null, in the case when you use zcomparisonpath, the unique ID of the container will be given a random ID instead of an ID based on the filename

= 1.4.1 =
* Update readme

= 1.4 =
* Each Zoomify image now has it's own unique ID, so you can add multiple Zoomify images on a page without conflicts
* The Zoomify containers all have a new .zoomify-wrapper css class, which you can use to custom style all the Zoomify images. If you are targeting the old #zoomifyContainer in your CSS, please change it to .zoomify-wrapper.
* Added Pro parameter ztoolbarbackgroundvisible
* Fixed upload issue for Zif files who were blocked by stricter WP upload rules. The MIME type for Zif files is now 'image/tiff' instead of 'image/zif'

= 1.3.1 =
* Added correct MIME type for handling JavaScript files

= 1.3 =
* Tested up to WP 5.1.1
* Fixed upload issue for Zoomify js

= 1.2.5 =
* Bump version number

= 1.2.4 =
* Fixed call to undefined function in settingspage

= 1.2.3 =
* Tested for wp 4.9.7
* Bumped version number

= 1.2.2 =
* Added Zoomify settings page, which can be found in the WP dashboard menu.
* Added possibility to upload your own Zoomify Javascript file that comes with the Zoomify software. The included JS will be removed from the plugin in future versions. This adds more flexibility in using version specific options in the future. The uploaded JS file will automatically be used for all your Zoomify images.
* Added selectbox to choose the Zoomify JavaScript version (Enterprise, Pro or Express) you have uploaded on the Zoomify settings page.

= 1.2.1 =
* Added version parameters in the plugins stylesheet and JS loading functions. Making if possible to change the force the browser to reload the stylesheet zoomify-styles.css after the user edits it. Please note: the best way to override the styles of this plugin is in the custom CSS section of your websites theme, or directly your theme's style.css file. Any changes made in this plugin's stylesheet will be overwritten in the next update.

= 1.2 =
* Added support for all available options in Zoomify Free edition
* Updates FAQ's with a list of available options

= 1.1.2.3 =
* Updated plugin description. Removed link to free .zif converter which no longer produces .zif files.

= 1.1.2.2 =
* Fixed path to custom skin directory and updated plugin description to inform about possible issues when copy-pasting the example code. The double quotes are not always recognized or properly formatted when pasted in the WP editor. As an alternative, users should manually type the shortcode.

= 1.1.2.1 =
* Bugfixes

= 1.1 =
* Added initial zoom parameter to finetune the initial image presented to the site visitor

= 1.0 =
* First stable release

== Upgrade Notice ==
The Zoomify containers all have a new .zoomify-wrapper css class, which you can use to custom style all the Zoomify images. If you are targeting the old #zoomifyContainer in your CSS, please change it to .zoomify-wrapper.
