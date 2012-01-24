=== Ninja Forms Lite ===
Contributors: kstover, jameslaws
Donate link: http://wpninjas.net
Tags: form, forms
Requires at least: 3.1
Tested up to: 3.3
Stable tag: 1.2.9.2

Ninja Forms Lite is the free version of Ninja Forms Pro. Its drag and drop interface makes it easy to create both simple and complex forms.

== Description ==
*Notice* - With Version 1.2.9.2 you can access all of the fields submitted by a user on your subesquent WP pages as $_SESSION['ninja_field_Your Label Name']. e.g. echo $_SESSION['ninja_field_First Name'];

Ninja Forms Lite is a fully-functional WordPress form creation plugin, with an interface designed to look right at home within your WordPress dashboard.

Ninja Forms is a WordPress form building plugin for the rest of us. While there are plenty of other form building plugins available, they tend to be either very expensive or overly complicated. 
Our guess is you just want something that works without having to take out a second mortgage or fumble through complicated wizards. And you definitely don't want to have to mess with the code. Ninja Forms is the perfect solution.

End users aren't the only ones who can benefit from Ninja Forms simplicity either. Developers can also extend their projects with Ninjas Forms by using its convenient hooks and simple structure. 
And because Ninjas Forms is licensed under the GPL you can use it on all of your projects without any restrictions...forever. Stop wrestling with web forms that are overly complicated and confusing. 
With Ninja Forms, the WordPress Form builder plugin,  you can easily create almost any type of WordPress form you might need and customize it as much or as little as you like.

Some of the features of Ninja Forms Lite:

	* Create any type of restricted input field by using our easy to use filters.
	* Add a spam filter to prevent those pesky bots from filling out your form.
	* Save form submissions and download them in .xsl format.
	* Show custom help text for any form field.
	* Send a completion message to the end-user and to a list of email addresses. You can even customze the email address this comes from.
	* Use required fields to ensure that your users fill in important information.
	* Easily create dropdowns, multi-selects, checkboxs, radio buttons, etc. with our drag and drop interface.
	* Attach a form to a page or post by simply checking a box, or use our shortcodes and functions to place your form anywhere you want.
	* Fully customizable CSS, make your form look the way you want.
	
	
Upgrade to Ninja Forms Pro and get these additional features:

	* Allow users to create posts/pages/etc. from a front-end form.
	* Make long forms easier to manage by separating them into sections using multi-part forms.
	* Give users the option to save their progress and come back to complete the form at a later date.
	* Access to powerful pre and post processing hooks so you can manipulate the form data however you want.
	* Allow users to upload files, with controls for naming and upload directory.

Visit http://www.wpninjas.net/ to check out Ninja Forms Pro.
	
== Screenshots ==

1. Ninja Forms Lite - Field Editing Page
2. Ninja Forms Lite - Form Settings Page
3. Ninja Forms Lite - View Form Submissions Page
3. Ninja Forms Lite - Plugin Settings Page

	
== Installation ==

Installing Ninja Forms Lite is really simple:

1. Upload the plugin folder (i.e. ninja-forms-lite) to the /wp-content/plugins/ directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add or edit your forms by using the new Ninja Forms Lite button in your admin sidebar.
4. Have a snack. You're done.

== Use ==

Using Ninja Forms Lite should be fairly straightforward. If you have any questions, see http://www.wpninjas.net for more information.


== Advanced Styling ==

Ninja Forms gives each form element a set class name, which you can style in your own CSS stylesheet. Additionally, Ninja Forms Lite 
allows you to apply your own custom CSS classes to any form field, so you can easily style your form to your own needs. Again, for more information, please
visit http://www.wpninjas.net.


== Help / Bugs ==

If you need help with Ninja Forms Lite, please leave a post in the WordPress.org forum and we will answer it as quickly as we can.

== Requested Features ==

If you have any requests, please post them in the WordPress.org forum.

== Changelog ==

= 1.2.4 =
* First version of Ninja Forms Lite released.

= 1.2.5 =
* Fixed a bug some users were experiencing with a bad require_once() call.

= 1.2.6 =
* Fixed some major security-related bugs, please ensure that you are using this version.

= 1.2.7 =
* Fixed a bug caused by the inability of the programmer to type correctly.

= 1.2.8 =
* Fixed a bug that would cause the form to not be emailed on some server setups.

= 1.2.9 =
* Fixed a bug that was causing sidebar placement to be saved improperly.
* Introduced localization code throughout Ninja Forms Lite. The POT file is located within the ninja-forms/lang/ directory.

= 1.2.9.1 =
*Fixed some typos which created problems with localization.

= 1.2.9.2 =
*Fixed some bugs some users were experiencing when activating Ninja Forms
*Fixed PHP Notices
*Developers can now access user submitted fields via $_SESSION variables like $_SESSION['ninja_field_Your Field Label']. e.g. echo $_SESSION['ninja_field_First Name'];