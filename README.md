# Special Offers
This plugin is developed as test task of the company ITIBO (Belarus).
## Description
Special Offers plugin for Wordpress. Plugin allows you to add special offers to any page using shortcode. On the blog pages shortcode content is loaded using AJAX, when it enters viewport. Special offer is a block that contains:
1. Title
2. Description
3. Category
4. Image (resizing to 300x200)
5. Regular price
6. Special price
7. End date of the special offer

In admin panel on the plugin page you can add special offers that are stored in database. After adding special offers, you can display them on the blog page via shortcode.
## Installation
####Recommend Requirements
* WordPress 4.9 or greater
* PHP 7.2 or greater
* MySQL 5.6 or greater OR MariaDB 10.0 or greater
* GD2 PHP extension
####Installation
Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
Activate the plugin through the 'Plugins' menu in WordPress.
## Usage
Insert shortcode `[specoff id='X']` into the content of page, where `X` is unique identifier of the offer.