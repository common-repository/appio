<?php
/*
Plugin Name: App.io
Plugin URI: http://app.io
Description: The App.io plugin lets you use shortcodes to embed playable iOS app demos from App.io in WordPress posts.
Version: 1.1
Author: App.io
Author URI: http://app.io
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2013 App.io (email: hello@app.io)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

The App.io plugin lets you use shortcodes to embed playable iOS app demos from App.io in WordPress posts.

For example, the shortcode `[app.io url="https://app.io/BJF03g"]` will embed a playable app demo in your post, with the default configuration.

You will need an App.io account to upload apps. You can sign up for a free trial account [here](https://app.io/signup).

This is the shortcode format:

[app.io url="{App.io app URL, e.g. https://app.io/BJF03g}"
    autoplay="true|false"
    chrome="true|false"
    device="iphone|iphone5|ipad|ipadmini"
    language="{ISO-639-1 language code}"
    location="{latitude and longitude in the form '37.7859, -122.406509'}"
    orientation="portrait|landscape"
    params="{URI-encoded JSON dictionary}"
]

The `url` parameter is mandatory. You can find an app's unique URL (e.g. <https://app.io/BJF03g>) from the [App.io dashboard](https://app.io/apps).

The parameters `autoplay`, `chrome`, `device`, `language`, `location`, `orientation`, and `params` are optional.

For information about the available parameters, see the [documentation](http://docs.app.io/parameters/).

*/
function app_io_shortcode_func($atts) {

    // Options
    $device_array       = array('iphone', 'iphone5', 'ipad', 'ipadmini');
    $language_array     = array('en', 'fr', 'de', 'ja', 'nl', 'it', 'es',
                                'pt', 'pt-PT', 'da', 'fi', 'nb', 'sv', 'ko',
                                'zh-Hans', 'zh-Hant', 'ru', 'pl', 'tr', 'uk',
                                'ar', 'hr', 'cs', 'el', 'he', 'ro', 'sk',
                                'th', 'id', 'ms', 'en-GB', 'ca', 'hu', 'vi');
    
    $atts = shortcode_atts(array(
        'url'           => null,
        'autoplay'      => '',
        'chrome'        => '',
        'debug'         => '',
        'device'        => '',
        'language'      => '',
        'location'      => '',
        'orientation'   => '',
        'params'        => ''
    ), $atts);
    $user_url           = $atts['url'];
    $user_autoplay      = ($atts['autoplay'] === '' || strtolower($atts['autoplay']) === 'false' ? 'false' : 'true');
    $user_chrome        = (strtolower($atts['chrome']) === 'false' ? 'false' : 'true');
    $user_debug         = ($atts['debug'] === '' || strtolower($atts['debug']) === 'false' ? '' : 'true');
    $user_device        = strtolower($atts['device']);
    $user_language      = $atts['language'];
    $user_location      = $atts['location'];
    $user_orientation   = (strtolower($atts['orientation']) === 'landscape' ? 'landscape' : 'portrait');
    $user_params        = $atts['params'];
    
    // 'url' is mandatory
    if (!$user_url) {
        return '<p><strong>App.io plugin error: no app URL was specified</strong></p>';
    }
    
    // Validate the URL format with regex
    $matches = array();
    $id = '';
    $match = preg_match('/^(http|https)\:\/\/app\.io\/([a-zA-Z0-9]+)$/', $user_url, $matches);
    if ($match) {
        $id = $matches[2];
    } else {
        return '<p><strong>App.io plugin error: invalid app URL: ' . htmlspecialchars($user_url) . '</strong></p>';
    }
    
    // Validate the device name
    if ($user_device !== '' && !in_array($user_device, $device_array)) {
        return '<p><strong>App.io plugin error: unknown device type: ' . htmlspecialchars($user_device) . '</strong></p>';
    }
    
    // Validate the ISO-639-1 language code
    if ($user_language !== '' && !in_array($user_language, $language_array)) {
        return '<p><strong>App.io plugin error: language not supported: ' . htmlspecialchars($user_language) . '</strong></p>';
    }
    
    // iframe dimensions
    $width = ($user_orientation === 'portrait' ? '291px' : '607px');
    $height = ($user_orientation === 'portrait' ? '607px' : '289px');
    switch ($user_device) {
      case 'iphone':
        $width = ($user_orientation === 'portrait' ? '305px' : '594px');
        $height = ($user_orientation === 'portrait' ? '598px' : '307px');
        break;
      case 'iphone5':
        $width = ($user_orientation === 'portrait' ? '291px' : '607px');
        $height = ($user_orientation === 'portrait' ? '607px' : '289px');
        break;
      case 'ipad':
        $width = ($user_orientation === 'portrait' ? '484px' : '629px');
        $height = ($user_orientation === 'portrait' ? '633px' : '488px');
        break;
      case 'ipadmini':
        $width = ($user_orientation === 'portrait' ? '595px' : '882px');
        $height = ($user_orientation === 'portrait' ? '886px' : '600px');
        break;
    }

    // Build the iframe URL
    $params = array('autoplay'      => $user_autoplay,
                    'chrome'        => $user_chrome,
                    'debug'         => ($user_debug === '' ? null : $user_debug),
                    'device'        => ($user_device === '' ? null : $user_device),
                    'language'      => ($user_language === '' ? null : $user_language),
                    'location'      => ($user_location === '' ? null : $user_location),
                    'orientation'   => $user_orientation,
                    'params'        => ($user_params === '' ? null : $user_params));
    $query_string = http_build_query($params);
    $url = "https://app.io/{$id}?{$query_string}";
    
    return "<iframe src=\"{$url}\" height=\"{$height}\" width=\"{$width}\" frameborder=\"0\" allowtransparency=\"true\" scrolling=\"no\"></iframe>";
}
add_shortcode('app.io', 'app_io_shortcode_func');

?>