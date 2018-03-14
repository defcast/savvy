=== Client Portal - Private user pages and login ===
Contributors: cozmoslabs, madalin.ungureanu, sareiodata
Donate link: http://www.cozmoslabs.com/
Tags: client portal, private user page, private pages, private content, private client page, user restricted content

Requires at least: 3.1
Tested up to: 4.7.4
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress Client Portal Plugin that creates private pages for all users that only an administrator can edit.

== Description ==

The WordPress Client Portal plugin creates private pages for each user. The content for that page is accessible  on the frontend only by the owner of the page
after he has logged in.

The plugin doesn't offer a login or registration form and it gives you the possibility to use a plugin of your choice.

The [client-portal] shortcode can be added to any page and when the logged in user will access that page he will be redirected to its private page.

For login and registration of users we recommend the free [Profile Builder](https://wordpress.org/plugins/profile-builder/) plugin.

You can then use the [wppb-login] shortcode in the same page as the [client-portal] shortcode.

== Installation ==

1. Upload and install the zip file via the built in WordPress plugin installer.
2. Activate the WordPress Client Portal plugin from the "Plugins" admin panel using the "Activate" link.


== Screenshots ==
1. Access the Private Page in the Users Listing in the admin area: screenshot-1.jpg
2. A Private Page in the admin area: screenshot-2.jpg
3. The Settings Page for the Plugin: screenshot-3.jpg

== Changelog ==
= 1.0.4 =
* We now have a default content option for pages
* Now private pages are excluded from appearing in frontend search
* Fixed a bug where the private page would reload indefinitely if the user hadn't a page created
* Fixed a bug where you could create duplicate pages for the same user


= 1.0.3 =
* Minor fixes and security improvements

= 1.0.2 =
* Added support for bulk Create Private Pages to Users page bulk actions

= 1.0.1 =
* Added support for comments on private user pages
* Settings page is now stylized

= 1.0.0 =
* Initial Version of the WordPress Client Portal plugin.