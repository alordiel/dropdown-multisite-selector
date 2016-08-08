 === Plugin Name ===

Tags: multisite, multisite list, dropdown menu, flexible select, edit select options
Requires at least: 3.8
Contributors: alordiel
Tested up to: 4.3
Stable tag: /trunk/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Gives you the option to make a select field with list of your multisites and more.

== Description ==

Do you need a way to give your visitors the option to navigate easily from your site other sites from your multisite network?
This plugin will give you the all that you need to configure a small select/dropdown field with fully configurable options and values (urls).

= You can choose by three options: =

* manually configure the number of the options from the dropdown element - pick up a name of your option and the relevant url where the user will be redirected after choosing it;

* get a automatically list of all sites from WordPress Multisite network - this one picks the names of all your sites that are in the multisite network and adds them to the select element;

* get the same list as previous one but only with the site where the current logged in user is registered;

= You can edit: =
* Your label for the name of the select option or leave it without label
* Your first select option ('Select branch', 'Select country', 'Choose Side')

Once you have saved your settings you can see the result using this shortcode [dms] or use the widget.

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
1. Activate it from your Plugins page.

== Changelog ==

= 0.5 =
* Option to add a list of you multisites in the theme's menu
* Custumizeble shortcode for setting your own list of links
* Styling option - user interface for controlling the css styles of the select option
* Field for custom css
* Sort alphabetic Option
* Show current site as first in the select option
* Option to open the link in new window/tab


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
