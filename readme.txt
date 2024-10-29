=== App.io ===
Contributors: App.io
Tags: App.io, appio, getappio, Kickfolio, embed, iOS, app, demo, shortcode
Requires at least: 3.0.0
Tested up to: 3.6
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The App.io plugin lets you use shortcodes to embed playable iOS app demos from App.io in WordPress posts.

== Description ==

The App.io plugin lets you use shortcodes to embed playable iOS app demos from [App.io](http://app.io) in WordPress posts.

For example, the shortcode `[app.io url="https://app.io/BJF03g"]` will embed a playable app demo in your post, with the default configuration.

You will need an App.io account to upload apps. You can sign up for a free trial account [here](https://app.io/signup).

This is the shortcode format:

`[app.io url="{App.io app URL, e.g. https://app.io/BJF03g}"
    autoplay="true|false"
    chrome="true|false"
    device="iphone|iphone5|ipad|ipadmini"
    language="{ISO-639-1 language code}"
    location="{latitude and longitude in the form '37.7859, -122.406509'}"
    orientation="portrait|landscape"
    params="{URI-encoded JSON dictionary}"
]`

The `url` parameter is mandatory. You can find an app's unique URL (e.g. <https://app.io/BJF03g>) from the [App.io dashboard](https://app.io/apps).

The parameters `autoplay`, `chrome`, `device`, `language`, `location`, `orientation`, and `params` are optional.

For information about the available parameters, see the [documentation](http://docs.app.io/parameters/).

== Installation ==

1. Upload `app-io.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

Note: You will need an App.io account to upload apps. You can sign up for a free trial account [here](https://app.io/signup).

== Frequently Asked Questions ==

= What is App.io? =

App.io is an interactive, HTML5 mobile marketing tool that allows your customers to play iPhone & iPad apps directly inside the browser.

For more information visit [App.io](http://app.io).

== Changelog ==

= 1.0 =
* Initial release.