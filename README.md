# HOMMSocialFeed plugin for Craft CMS 3.x

Craft CMS Social Feed Adapter for juicer.io

![Screenshot](resources/img/plugin-logo.svg)

## Requirements

This plugin requires Craft CMS 3.x.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require homm/hommsocialfeed

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for HOMMSocialFeed.

## HOMMSocialFeed Overview

HOMM Social Feed is a Craft adapter for [juicer.io](https://www.juicer.io) to collect all of your social media feeds
for easy integration in your application.

## Configuring HOMMSocialFeed

Go to _Settings > HOMMSocialFeed_ to setup the basic configuration options:

- **Social Feed API path:** The path to your Juicer API
- **Number of feeds:** The amount of feeds to query by default
- **Colors:** The available colors you can set per feed. These values are only used for the CP section. In the query you
  retrieve the handles dark, highlight and muted.
  
Add the following CronJob, to regularly update your social feeds:
```bash
/path/to/your/project/craft hommsocialfeed/social-feeds/update
```

## Using HOMMSocialFeed

Select _HOMMSocialFeed_ in the left navigation.

You can set following properties:

- **Status:** Disable or enable specific feeds
- **Color:** Change or reset the color for specific feeds
- **Hide image/video:** Hide the image or video for specific feeds

## HOMMSocialFeed Roadmap

Some things to do, and ideas for potential features:

* Add filters in the CP section

Brought to you by [HOMM interactive](https://github.com/HOMMinteractive)
