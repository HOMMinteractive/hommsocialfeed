# HOMM Social Feed plugin for Craft CMS

HOMM Social Feed Adapter for Juicer

![Screenshot](resources/img/plugin-logo-v2.svg)

## Requirements

This plugin requires Craft CMS 4.x.

For the Craft CMS 3.x plugin version, see 1.x tags.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require homm/hommsocialfeed

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for HOMM Social Feed.

## HOMM Social Feed Overview

HOMM Social Feed is a Craft adapter for [juicer.io](https://www.juicer.io) to collect all of your social media feeds
for easy integration in your application.

## Configuring HOMM Social Feed

Go to _Settings > HOMM Social Feed_ to setup the basic configuration options:

- **Social Feed API path:** The path to your Juicer API (for example: https://www.juicer.io/api/feeds/artdecohotelmontana)
- **Number of Posts:** The amount of posts to query by default
- **Colors:** The available colors you can set per feed. These values are only used for the CP section. In the query you
  retrieve the handles dark, highlight and muted.

Add the following CronJob, to regularly update your social feeds:

```bash
/path/to/your/project/craft hommsocialfeed/social-feeds/update
```

## Using HOMM Social Feed

Select _HOMM Social Feed_ in the left navigation.

You can set following properties:

- **Status:** Disable or enable specific posts
- **Color:** Change or reset the color for specific posts
- **Hide image/video:** Hide the image or video for specific posts

Basic usage in the template (Twig):

```html
{% for socialFeed in craft.socialFeed.all() %}
    <img src="{{ socialFeed.image }}" alt="{{ socialFeed.message|slice(0, 10) }}" loading="lazy">
{% endfor %}
```

More complex example in the template (Twig):

```html
{# Query all posts which has an image and the image is not hidden #}
{% for socialFeed in craft.socialFeed.all([{ isMediaHidden: false }, ['not', { image: null }]]) %}
    <div class="{{ socialFeed.color }}">
        {% if not socialFeed.isMediaHidden %}
            {% if socialFeed.video is not empty %}
                <div class="img">
                    <video class="video" controls poster="{{ socialFeed.image }}">
                        <source src="{{ socialFeed.video }}" type="video/mp4">
                    </video>
                </div>
            {% elseif socialFeed.image is not empty %}
                <a href="{{ socialFeed.feedUrl }}" title="{{ readMore }}" target="_blank">
                    <img src="{{ socialFeed.image }}" alt="{{ socialFeed.message|slice(0, 10) }}" loading="lazy">
                    <span>                             
                        {{ socialFeed.feedDateCreated|date('long') }}
                    </span>
                </a>
                {% for additionalPhoto in socialFeed.additionalPhotos|json_decode %}
                    <img src="additionalPhoto" alt="{{ socialFeed.message|slice(0, 10) }}" loading="lazy" style="display: none;">
                {% endfor %}
            {% endif %}
        {% endif %}
        {% if socialFeed.message is not empty %}
            <div>
                {% if socialFeed.message|length > 120 %}
                    {% set message = socialFeed.message|slice(0, 120) ~ '...</p>' %}
                {% endif %}
                {{ (message ?? socialFeed.message)|raw }}
                <a href="{{ socialFeed.feedUrl }}" title="{{ readMore }}" target="_blank">
                    {{ readMore }}
                </a>
            </div>
        {% endif %}
    </div>
{% endfor %}
```

The `craft.socialFeed.all()` function accepts following parameters:

1. `(array) $conditions`: An array of `where`-/`andWhere`-Conditions (see example above).
1. `(?int) $limit`: Overwrite the default limit provided in the settings page.
1. `(?array) $orderBy`: Order by one or multiple columns. The default is `['homm_socialfeeds.feedDateCreated' => SORT_DESC]`.

## HOMM Social Feed Roadmap

Some things to do, and ideas for potential features:

* Add filters in the CP section
* Allow to save social feed images locally

Brought to you by [HOMM interactive](https://github.com/HOMMinteractive)
