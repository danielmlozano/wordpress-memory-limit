=== Plugin Name ===
Contributors: danielmlozano
Tags: memory, memory limit, memory exhausted, error 500
Requires at least: 2.7
Tested up to: 5.7
License GPLV3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Stable tag: 1.0

Ever faced an error of type "allowed memory size of 33554432 bytes exhausted" in your Wordpress site? This plugin allows you to change your Wordpress installation memory limit to bypass these errors.

== Description ==

As your Wordpress awesome site grows in size, there's a very good chance that you start to use a lot of plugins. These plugins usually wind up making your wordpress a very 
fat site, so your server needs to allocate a lot more in memory in order to serve your site. When this memory allocation arrives to its limit, your Wordpress site will crash
and won't let the user continue.

This plugin is intended to give you a very simple way to update this memory limit without touching any Wordpress or server configuration. Just install it, indicate the memory limit 
that you need (in MB) and press a button. Simple as that.

== FAQ ==

= What is an appropriate limit to set? =

Under normal circumstances and without a lot of plugin-usage, a Wordpress site will do with 64M. 

Usually, a low memory limit will prevent Wordpress overflowing your server memory size and affecting any other services that are running on your server. However, if your server is configured correctly 
and has good memory capacity, then you may increase the wP memory limit according to your needs.

= Why doesn't it work? =

Your server or hosting provider may prevent PHP from increasing its own memory limit. Contact your server administrator or customer service and 
ask if there's a way to do this.

== Changelog ==

= 1.0 =
* First release