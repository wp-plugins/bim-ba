=== BIM-ba ===
Contributors: andywar65
Donate link: http://www.andywar.net/wordpress-plugins/donate
Tags: BIM, project, management, studio, admin
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is the first module of a BIM (Building Information Modeling) based on WordPress. It manages a small Studio's projects and countability.

== Description ==

BIM-ba is a very basic BIM at it's first steps.
Only module available by now is called 'Manage Studio', and it helps management of projects and countability of a small design firm (like the one I own!). 
This module works on the backend of WordPress, and requires admin priviledges to be handled. Plugin creates following Custom Post Types:

OPERATORS-
Operators are the actors of the scene, and may have the role of 'Studio', 'Contributor', 'Client', 'Contractor' and so on.
First step is to create your own Operator with 'Studio' role. Then go to 'Studio Settings' submenu and set your Studio as the one the contability is related to.

PROJECTS-
Projects are the scenes where the operators act. You can create as many projects you want, set the Client, the phase it's in and define it's deadline.

REPORTS-
Reports are the actions of the Operators on the scenes. In example an action may be a Draft Bill, an Invoice, a Credit.
Reports are acted by an Operator and are related to a Project. You have to set it's amount.

BLOTTER ENTRIES-
These are special Reports, related to the Studio's countability. Every income and expense of the Studio must be logged in the Blotter.
Go to 'Studio Settings' submenu again, and check all the expense categories that build up your fixed expenses. We will use this data for forecasts.

After setting all these entities, you can inspect them through specific inspector submenues:

INSPECT OPERATOR-
Select an operator and see in which Project he/she is involved and what Reports are set. On the bottom line, a balance of incomes and expenses.

INSPECT PROJECT-
Select a project and see Operators involved and their Reports.

LIST ALL REPORTS-
Just a static list of all Reports. To be enhanced.

SEARCH BLOTTER ENTRIES-
Search Entries by Project and/or Operator, by date, category or keyword.

MANAGE STUDIO-
This submenu shows the balance of your Studio in every single Project and forecasts a total balance given the fixed expenses.


Additional instructions may be found here: http://www.andywar.net/wordpress-plugins/bim-ba/

== Installation ==

1. Download and unzip `bim-ba` folder, then upload it to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Nothing else

== Frequently Asked Questions ==

= Does the plugin work on multisites? =

Yes, it does.

= Does it work on all themes? =

It works only in the backend of WordPress, with admin roles.

== Screenshots ==

1. This is how the 'Studio Settings' submenu appears.
2. Blotter Entry search submenu. 
3. Report Taxonomies and Metabox for setting amounts, Projects and Operators.
4. Blotter Entries Taxonomies and Metabox for setting amounts, Projects and Operators.

== Changelog ==

= 1.0.1 =
* Italian translation available.

= 1.0 =
* First release.

== Upgrade Notice ==

= 1.0.1 =
* Italian translation available.

= 1.0 =
* No upgrades available.