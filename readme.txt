`=== PMPro Social Locker ===
Contributors: scottsousa
Tags: pmpro, paid memberships pro, social locker
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: .1.2


== Description ==

Integrate PMPro with the Social Locker plugin from OnePress (http://wordpress.org/support/plugin/social-locker). The goal is to give a user a free membership if they interact with Social Locker.

== Installation ==

1. Upload the `pmpro-social-locker` directory to the `/wp-content/plugins/` directory of your site.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Define the PMPROSL_FREE_LEVEL_ID and PMPROSL_MEMBERSHIP_PERIOD_DAYS constants in a customizations plugin, functions.php or wp-config.php

== Frequently Asked Questions ==

= I found a bug in the plugin. =

Please post it in the issues section of GitHub and we'll fix it as soon as we can. Thanks for helping. https://github.com/strangerstudios/pmpro-addon-packages/issues

= I need help installing, configuring, or customizing the plugin. =

Please visit our premium support site at http://www.paidmembershipspro.com for more documentation and our support forums.

Please Note: This plugin is meant as a temporary solution. Most updates and fixes will be reserved for when this functionality is built into Paid Memberships Pro. We may not fix the pmpro-addon-packages plugin itself unless it is critical.

== Changelog ==
= .1.2 =
* ENHANCEMENT/BUG: Fixed potential PHP7 issue
= .1.1 =
* Commented out constant definitions to discourage editing the core plugin file. Define the constants somewhere else so your settings don't get overwritten with any updates.
* Moved plugin file into main folder.
= .1 =
* Initial release.
