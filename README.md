 ## Plugin Name
Requires at least: WordPress 3.8

Tested up to: WordPress 6.7.2

Stable tag: 0.9.5

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description

With this plugin you can create fully configurable dropdown field which select options would work as links and will redirect the user to the selected one. It was originally built for multisite for faster navigation between each sub-site, but currently it also supports custom links as options from the dropdown. 

### There are three options:

* manually configure the number of the options from the dropdown element - pick up a name of your option and the relevant url where the user will be redirected after choosing it;
* get any list of all sites from WordPress Multisite network - this one picks the names of all your sites that are in the multisite network and adds them to the select element;
* get the same list as previous one but only with the site where the current logged-in user is registered;

### You can manage:
* Your label for the name of the select option or leave it without label
* Your first select option ('Select branch', 'Select country', 'Choose Side')
* Sorting of your custom list (alphabetic sorting + reverse sorting (your last entries will become first in the dropdown))

Once you have saved your settings you can see the result using this shortcode [dms] or use the widget.

## Shortcodes
`[dms]` - Using this shortcode will generate the same dropdown as the one you have configured in the admin settings panel.


`[dms_manual name="" placeholder="" target="" options=""]` - Use this one your own dropdown that has nothing to do with the settings you have set. The arguments of this shortcode are:
* name - the label of the select option (leave empty for no label)
* placeholder - the first option that is shown in the select menu (like: "--  Select --")
* target - could be "default" or "blank". This is the target of the link - "blank" is to be open in new window
* options - name-link pairs, should be placed as : "url1|name1, url2|name2, url3|name3"

An example:

```
[dms_manual name="Label" placeholder="--Select--" target="blank" options="Trusted search engine|https://duckduckgo.com, Tracking search engine|https://google.bg"]
```

If you would more functionality, please contact me to check if I can implement it. Also thanks to everyone giving me hints how to improve this plugin.

## Filters in the code
Here are some filters that you can use to modify the results from the code:
* `dms_sites_arguments` - to control the attributes used in the function `get_sites()` when 'Show all sites in the WMN' option is selected.
* `dms_multisite_pairs` - filter the results returned from `get_sites()`.
* `dms_users_sites` - control the sites when 'Show only the sites where the user is registered' option is selected.


## Installation
### From your WordPress dashboard 
1. Visit 'Plugins > Add New'
2. Search for 'Dropdown Multisite Selector'
3. Activate Dropdown Multisite Selector from your Plugins page. To start building your dropdown go to Settings -> Dropdown multisite.

### From WordPress.org
1. Download 'Dropdown Multisite Selector'.
1. Upload the 'dropdown-multisite-selector' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
1. Activate it from your Plugins' page.
