=== MCWD Site Utilities ===
Donate link: https://curren.me
Tags: post types, taxonomies
Requires at least: 3.0.1
Tested up to: 6.1.1
Stable tag: 6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin declares the Custom Post Types and Custom Taxonomies for this WordPress site.

== Description ==

Requires at least PHP 7 to run.

The Custom Post Types and Custom Taxonomies are declared using arrays of definitions stored in named constants in `mcwd-cpt.php`. 

This might not be the best way to do things but I wanted the place where the custom data was declared to be higher up in the file tree, and I think this approach achieves that. 

I did prefix the constants, so that is something I guess:
 - `MCWD_CPT_POST_TYPES`
 - `MCWD_CPT_TAXONOMIES`