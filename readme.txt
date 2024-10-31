=== Post Content Slider ===
Contributors: alan.pagoto, polvodigital
Donate link: http://www.polvo.com.br
Tags: posts, ajax, slideshow, widget, sidebar
Requires at least: 3.0.1
Tested up to: 3.4.1
Stable tag: 4.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Post content slider - Rotate your favorite posts in a widget - Developed by Alan Hidalgo Pagoto under Polvo Digital

== Description ==

A plugin which allows you to put posts of a specific category (you can use even all the categories) in a widget. You can use more that one widget at the same time and configure different time transictions between two posts. You're able to change the quantity of posts in each widget as well. When there are too many posts to be loaded, the plugin loads the first ten and, when the first transiction is triggered (between the first and the second posts) the 11th is loaded and put in the queue. When the second transiction is triggered, the 12th post is loaded and the plugin keeps doing it until all posts are loaded. When it happens, the plugin stops making ajax requests to the server and the page runs normally.

You can find a demo on http://www.polvo.com.br/plugins/post-content-slider. There are two widgets configured on the right. The first one is set to change the post every 4 seconds and the second one every 10 seconds.

== Files structure ==

plugins/

postcontentslider.php => The main file of plugin. It calls some necessary hooks.

plugins/css

main.css => Has only one class, which turns absolute and hidden all the posts before starts to slide them

plugins/includes

pcs_post_templace.php => This plugin works with ajax requests and creates new li elements dinamically. This file is the structure of the posts on the widget.

pcs_widget_showdata.php => This is the widget class, which allows the plugin to show the information.

plugins/js

pcs_general.js => This javascript file changes the posts on the widget and make ajax requests

== How it works ==


After installing and activating the plugin, you must use it as a widget. At the widgets area, you may configure:

1) Widget title

The title that appears above the widget content

2) Box height

This is the size of the box which contains the post slider. You can change this value through css as well.

3) Category

You can choose a category to show the posts. For example: on this widget, I want to show a slide of posts about football. Anyway, you can choose "Any" and your widget will show the last posts of all categories.

4) Posts Quantity

You can choose the quantity of posts of your slideshow. You have the option of choosing "All the posts" as well, and the page will show every single post of your blog (or of a chosen category).

4.1) Ajax

If you choose more than 10 posts (or All posts), they will not be loaded when the page is loaded. Only the first 10 posts are loaded. When the first transition is triggered, the 11th post is loaded and added to the list with ajax. When the second transition is triggered, the 12th post is loaded, etc. When all the posts are already loaded and added to the list, the plugin stops making requests to the server through ajax.

5) Exhibition time

You can choose the time (in seconds) between the transitions.

== Installation ==

1) Upload the folder `postcontentslider` to the `/wp-content/plugins/` directory
2) Activate the plugin through the 'Plugins' menu in WordPress
3) Use and configure it through Widgets session


== Information ==

Remember that you can use more than one widget with this plugin and change the properties for each one.