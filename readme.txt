 === Plugin Name ===

Tags: redirect, multisite, dropdown menu, flexible select, edit select options
Requires at least: 3.8
Contributors: alordiel
Tested up to: 4.7.1.
Stable tag: /trunk/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Gives you the resources to make select field with redirecting options to a given URLs.

== Description ==

Do you need a way to give your visitors the option to navigate easily from your site other sites (multisite)? 
This plugin will give you the option to configure a small select/dropdown field with fully configurable options and values (urls).

= You can choose by three options: =

* manually configure the number of the options from the dropdown element - pick up a name of your option and the relevant url where the user will be redirected after choosing it; 

* get a automatically list of all sites from WordPress Multisite network - this one picks the names of all your sites that are in the multisite network and adds them to the select element;

* get the same list as previous one but only with the site where the current logged in user is registered;

= You can manage: =
* Your label for the name of the select option or leave it without label
* Your first select option ('Select branch', 'Select country', 'Choose Side')
* Sorting of your custom list (alphabetic sorting + reverse sorting (your last entries will become first in the dropdown))

Once you have saved your settings you can see the result using this shortcode [dms] or use the widget.

= Shortcodes =
[dms] - Using this shortcode will generate the same dropdown as the one you have configured in the admin settings panel.


[dms_manual name="" placeholder="" target="" options=""] - Use this one your own dropdown that has nothing to do with the settings you have set. The arguments of this shortcode are:
* name - the label of the select option (leave empty for no label)
* placeholder - the first option that is showen in the select menu (like: "--  Select --")
* target - could be "default" or "blank". This is the target of the link - "blank" is to be open in new window
* options - name-link pairs, should be placed as : "name1|url1, name2|url2, name3|url3"

An example: 
[dms_manual name="Label" placeholder="--Select--" target="blank" options="Trusted search engine|http://duckduckgo.com, Tracking search engine|http://google.bg"]

If you would more functionality, please contact me to check if I can implemente it. Also thanks to everyone giving me hints how to improve this plug-in.

== Installation ==
= 
From your WordPress dashboard 
=
1. Visit 'Plugins > Add New'
1. Search for 'Dropdown Multisite Selector'
1. Activate Dropdown Multisite Selector from your Plugins page. To start building your dropdown go to Settings -> Dropdown multisite.
= From WordPress.org 
=
1. Download 'Dropdown Multisite Selector'.
1. Upload the 'dropdown-multisite-selector' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
1. Activate it from your Plugins' page.


== Screenshots ==

 1. The admin part(from version 0.3)
 2. The front end - widget area + shortcode in post(from version 0.3)

== Changelog ==

= 0.6.4 =
* fixed bug with redirect on target blank when option without value is selected.

= 0.6.3 =
* fixed issue with WordPress repository and the last commit

= 0.6.2 =
* fixed issue with including a php files and trailing slashes for XAMPP and may be some windows server systems 

= 0.6.1. =
* Implementing better security
* Folder restructuring
* Code refactoring

= 0.6 =
* Added some sorting options for the custom list of options
* Small refactoring and security
* The "Add more" button was removed and option to add new row after each row was added
* CSS & JS tweaks in the admin side

= 0.5 =
* Fix Deprecated function wp_get_sites
* Fix Widget without save button (now plugins like Dynamic Widgets should work)
* Added shortcode with attributes

= 0.4.1 =
* Fix with some svn issues

= 0.4 =
* Fix: some php Notice messages were fixed
* Added: option to choose the name of your first option from the select field (thanks for the idea @Ruth Maude)
* Removed: the requirement for label name. Now you can build select option only with the selects' element (Option name and url) without label.

= 0.3.3 =
* Fix: Opps, the previous one didn't worked as expected :( Hope this one fix the problem

= 0.3.2 =
* Fix: issues when updating from 0.1 to any higher version (thanks for reporting @jfullerton)

= 0.3.1 =
* Fixed: not working if on the page there are two ore more select fields (thanks for reporting @Steve Borsch)

= 0.2 =

* Widget option added
* added option for automatically generated option's list of all sites connected in the current WordPress Multisite Network
* added option for automatically generated option's list of all sites connected in the current WMN where the logged in user is registered.
* fix problem with loading the js before the jquery
* code refactoring

= 0.1 =

* Start : )

