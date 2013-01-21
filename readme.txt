=== Ninja Forms ===
Contributors: kstover, jameslaws
Donate link: http://wpninjas.com
Tags: form, forms
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 2.0.3
License: GPLv2 or later

== Description ==
Ninja Forms is a full-featured form building solution for WordPress. It allows you to easily and quickly design complex forms through a drag and drop interface.

= Some of the cool features of Ninja Forms: =

* Custom input masks allow you to restrict user input for things like phone numbers, currency, and dates.
* Manage, Edit, and Export user submissions.
* Save fields as favorites and re-use them in multiple forms.
* Export and Import forms and favorite fields.
* Set required fields.
* Add a datepicker to text fields.
* Email form results to any number of pre-determined email addresses, as well as specific messages to the user filling out the form.
* Extremely developer friendly.

= In addition to these features, extensions are available at our website: [Ninja Forms Extensions](http://wpninjas.com/downloads/category/ninja-forms/) =

* File Uploads - Allow users to upload files and store those files within a searchable database.
* Multi-Part Forms - Break up those long, complex forms into multiple pages.
* Save User Progress - Let your users save their progress and return later to finish filling out the form.
* Conditional Logic - Create "smart" forms that show or hide fields based upon user input. Even add a value to a dropdown list when a user selects a specific value from another list.
* Front-End Posting - Use Ninja Forms to create posts from the front-end. These can be added to any post type, including custom post types, and users can select categories and tags.

We have several other extensions in the works.

== Screenshots ==

To see up to date screenshots, visit the [Ninja Forms](http://wpninjas.com/ninja-forms/) page.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `ninja-forms` directory to your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the 'Forms' menu item in your admin sidebar

Shortcodes have been re-implemented. They are used like so: [ninja_forms_display_form id=3] where 3 is the ID number of the form you want to display.


== Use ==

For help and video tutorials, please visit our website: [Ninja Forms Documentation](http://wpninjas.com/ninja-forms/docs/)

== Upgrade Notice ==

= 2.0 =

Version 2.0 is a complete rebuild. If you are a Pro user you should have receieved some additional license keys and links to extension downloads to enhance Ninja Forms. HTML output may have been altered slightly as well so you public form may not look as you intend with this new version without some minor changes. If you need help with anything like that please let us know at wpninjas.com and we will try and assist you very quickly.

== Requested Features ==

If you have any feature requests, please feel free to visit [wpninjas.com](http://wpninjas.com/downloads/category/ninja-forms/) and let us know about it.

== Changelog ==
= 2.0.3 =
* Features:
* Added a checkbox to allow the appending of field values to administrator emails.
* Save form settings is now checked by default when creating a form.
* Hide form after successful submission is now checked by default when creating a new form.
* Changed the [label] system to [ninja_forms_field id=3] where 3 is the field ID that you want to insert.

* Changes:
*Changed the way that "settings saved" messages appear. When creating a save function on the admin-backend, you can now return the update message you wish users to see.

* Bugs:
* Fixed a bug that caused design elements, especially text fields, from showing on multi-part forms.
* Fixed a bug in the backend admin system that was causing problems with the Uploads Browser/Upload Settings tabs.
* To prevent conflicts with other plugins, we removed the position declaration from the admin menu hook. This means that the Forms link will now float to the bottom of the admin menu.
* Fixed a bug that was causing help text to be repeated underneath sections of the Form Settings Tab.
* Fixed a bug that prevented list-based checkboxes from showing up properly when editing submissions.
* Fixed a bug that was causing required checkboxes not to validate properly.

= 2.0.2 =
* Fixed several bugs including:
* A bug that caused multiple forms to a single page broke some JS
* Various export bugs. Exporting submissions should work properly.
* Various activation bugs.
* Varous bugs on the admin/back-end.

* Added widget functionality. You can now add Ninja Forms to your sidebars via a widget.

= 2.0.1 =
* Lots of bug fixes.

* Filter User and Admin email subject line for [bracketed] labels.
* Add an action hook to User and Email sending.
* Add an option to the "user email" section for attaching user submitted values.
* "Settings saved" now appears properly when saving plugin settings.
* Fixed a bug with including display js and css for core and extensions.
* Removed the label "Error message shown when all fields are empty." This wasn't used anyway.
* Added Shortcodes. They can be used like: [ninja_forms_display_form id=3].
* Fixed a bug where saving plugin settings would break upon HTML entry.
* Replaced isset( $ninja_forms_processing with is_object( $ninja_forms_processing.
* Fixed several activation bugs.

= 2.0 =
* Version 2.0 is a major leap forward for Ninja Forms. It is much more stable and developer friendly than previous versions of the plugin.