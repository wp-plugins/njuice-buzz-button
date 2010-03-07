=== Njuice Buzz Button ===
Tags: google, buzz, rebuzz, buzzthis, button, voting, njuice
Requires at least: 2.3.0
Tested up to: 2.9.2
Stable tag: 1.0.0

== Description ==

This is a Google Buzz button that anyone can use on their site or blog to share news. It has a live "firehose" counter connected to it. This means that the count is not based on clicks on the actual button (like other services out there) but on the actual share count in the whole of Google Buzz. So no matter how and where people share your links to Buzz they will be counted.

= Features =
* Real time count of buzzes
* Choose between four types of buttons - normal, small, simple, image (for feeds)
* Choose where to place button
* Choose on what pages button should be displayed
* Ability to add/remove button only on specific posts

== Installation ==

Follow the steps below to install the plugin.

1. Upload the njuice-buzz-button directory to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings/Buzz Button to configure the button

== Frequently Asked Questions ==

= How do you calculate the count for the buttons? =

We use PubSubHubbub to get updates in real-time from Buzz, for every link we receive we expand the URL and update the counter.

= Is this the full Buzz Firehose? =

No, since there is no real API for Buzz updates yet. However we are retrieving data from over 10 million google profiles.

= Why do you share via mail and not Google Reader? =

The Google Reader share method most sites currently are using is flawed. Even though a user you follow has connected his account with Google Reader and he shares his posts this way it won't appear in your Buzz stream in the gmail interface (it will however show up in the public profile located at http://www.google.com/profiles/profile). The proper method to do it currently (before a real API is released) is via mail. 

= How can I add or remove button only on specific page? =

Type [BUZZBUTTON] anywhere in content and that tag will be replaced by a button. Type [NOBUZZBUTTON] to remove the button for that specific post if you've enabled it for all posts.

== ChangeLog ==

= 1.0.0 =

* Initial release