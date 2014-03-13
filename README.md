# WPTT Developer Constants

Contributors: Curtis McHale
Tags: wp_mail, email logging
Requires at least: 3.6
Tested up to: 3.7
Stable tag: 1.0


## Description

Basic plugin that allows you to define constants for live/local/staging.

Ideal for hosting like WPEngine which blows out the staging wp-config.php file when you push live->staging with their tools

## Installation

1. Extract to your wp-content/mu-plugins/ folder. Create it if it doesn't exist and just put the .php file in. mu-plugins don't look inside folders.

2. Plugin is always run and won't show up in the WordPress admin

3. Follow this repository for any updates since MU Plugins don't get update notifications.

## Usage

Use this is the mu-plugins/ folder in your WordPress site. It's meant for you to change the code. Define your live, local, and staging site url's as needed.

You can then use them in any plugin since they are defined before regular plugins are loaded. It lets you do stuff like configure email logging on all staging and local sites by checking the defined constants.

### wp-config muckery

So for things like password resets the included file in mu-plugins just doesn't work for a reason that me and my magic underpants have not been able to figure out. To fully take advantage of this plugin you need to do some configuration for your wp-config.php file constants.

Place the following in your wp-config.php file just below your key salts.

```php
$local = array(
	'http://yourlocalsite.com',
);

define( 'LIVE_ENV', serialize( $local ) );

$staging = array(
	'http://yourstagingsite.com',
);
define( 'STAGING_ENV', serialize( $staging ) );

$live = array(
    'http://yourlivesite.com'
);
define( 'LIVE_ENV', serialize( $live ) );

```

Now at any point in the WordPress boot process you should have access to the conditionals just fine. Obviously change the domains to the domains of your local/live/staging sites.

## Changelog

### 1.0

- basic constants configuration
