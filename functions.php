<?php
use IndicoPlus\CaritasApp\Core\DataFetcher;
use IndicoPlus\CaritasApp\Core\Helper;

if (!function_exists('caritas_app_get_targets_list')) {
    function caritas_app_get_targets_list()
    {
        return DataFetcher::getTargetsList();
    }
}

if (!function_exists('caritas_app_get_target')) {
    function caritas_app_get_target(int $id)
    {
        return DataFetcher::getTarget($id);
    }
}

if (!function_exists('caritas_app_get_target_payment_methods')) {
    function caritas_app_get_target_payment_methods(int $id, array $additional = [])
    {
        return DataFetcher::getTargetPaymentMethods($id, $additional);
    }
}

if (!function_exists('caritas_app_get_formatted_price')) {
    /**
     * Convert gr to zl
     *
     * @param integer $price
     * @return string
     */
    function caritas_app_get_formatted_price(int $price)
    {
        return Helper::getFormattedPrice($price);
    }
}

if (!function_exists('caritas_app_parse_formatted_price')) {
    /**
     * Convert zl to gr
     *
     * @param $price
     * @return int
     */
    function caritas_app_parse_formatted_price($price)
    {
        return Helper::parseFormattedPrice($price);
    }
}

if (!function_exists('http_build_url')) {
    // Define constants
    define('HTTP_URL_REPLACE', 0x0001); // Replace every part of the first URL when there's one of the second URL
    define('HTTP_URL_JOIN_PATH', 0x0002); // Join relative paths
    define('HTTP_URL_JOIN_QUERY', 0x0004); // Join query strings
    define('HTTP_URL_STRIP_USER', 0x0008); // Strip any user authentication information
    define('HTTP_URL_STRIP_PASS', 0x0010); // Strip any password authentication information
    define('HTTP_URL_STRIP_PORT', 0x0020); // Strip explicit port numbers
    define('HTTP_URL_STRIP_PATH', 0x0040); // Strip complete path
    define('HTTP_URL_STRIP_QUERY', 0x0080); // Strip query string
    define('HTTP_URL_STRIP_FRAGMENT', 0x0100); // Strip any fragments (#identifier)

    // Combination constants
    define('HTTP_URL_STRIP_AUTH', HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS);
    define('HTTP_URL_STRIP_ALL', HTTP_URL_STRIP_AUTH | HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT);

    /**
     * HTTP Build URL
     * Combines arrays in the form of parse_url() into a new string based on specific options
     * @name http_build_url
     * @param string|array $url     The existing URL as a string or result from parse_url
     * @param string|array $parts   Same as $url
     * @param int $flags            URLs are combined based on these
     * @param array &$new_url       If set, filled with array version of new url
     * @return string
     */
    function http_build_url( /*string|array*/$url, /*string|array*/ $parts = array(), /*int*/ $flags = HTTP_URL_REPLACE, /*array*/&$new_url = false)
    {
        // If the $url is a string
        if (is_string($url)) {
            $url = parse_url($url);
        }

        // If the $parts is a string
        if (is_string($parts)) {
            $parts = parse_url($parts);
        }

        // Scheme and Host are always replaced
        if (isset($parts['scheme'])) {
            $url['scheme'] = $parts['scheme'];
        }

        if (isset($parts['host'])) {
            $url['host'] = $parts['host'];
        }

        // (If applicable) Replace the original URL with it's new parts
        if (HTTP_URL_REPLACE & $flags) {
            // Go through each possible key
            foreach (array('user', 'pass', 'port', 'path', 'query', 'fragment') as $key) {
                // If it's set in $parts, replace it in $url
                if (isset($parts[$key])) {
                    $url[$key] = $parts[$key];
                }

            }
        } else {
            // Join the original URL path with the new path
            if (isset($parts['path']) && (HTTP_URL_JOIN_PATH & $flags)) {
                if (isset($url['path']) && $url['path'] != '') {
                    // If the URL doesn't start with a slash, we need to merge
                    if ($url['path'][0] != '/') {
                        // If the path ends with a slash, store as is
                        if ('/' == $parts['path'][strlen($parts['path']) - 1]) {
                            $sBasePath = $parts['path'];
                        }
                        // Else trim off the file
                        else {
                            // Get just the base directory
                            $sBasePath = dirname($parts['path']);
                        }

                        // If it's empty
                        if ('' == $sBasePath) {
                            $sBasePath = '/';
                        }

                        // Add the two together
                        $url['path'] = $sBasePath . $url['path'];

                        // Free memory
                        unset($sBasePath);
                    }

                    if (false !== strpos($url['path'], './')) {
                        // Remove any '../' and their directories
                        while (preg_match('/\w+\/\.\.\//', $url['path'])) {
                            $url['path'] = preg_replace('/\w+\/\.\.\//', '', $url['path']);
                        }

                        // Remove any './'
                        $url['path'] = str_replace('./', '', $url['path']);
                    }
                } else {
                    $url['path'] = $parts['path'];
                }
            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && (HTTP_URL_JOIN_QUERY & $flags)) {
                if (isset($url['query'])) {
                    $url['query'] .= '&' . $parts['query'];
                } else {
                    $url['query'] = $parts['query'];
                }

            }
        }

        // Strips all the applicable sections of the URL
        if (HTTP_URL_STRIP_USER & $flags) {
            unset($url['user']);
        }

        if (HTTP_URL_STRIP_PASS & $flags) {
            unset($url['pass']);
        }

        if (HTTP_URL_STRIP_PORT & $flags) {
            unset($url['port']);
        }

        if (HTTP_URL_STRIP_PATH & $flags) {
            unset($url['path']);
        }

        if (HTTP_URL_STRIP_QUERY & $flags) {
            unset($url['query']);
        }

        if (HTTP_URL_STRIP_FRAGMENT & $flags) {
            unset($url['fragment']);
        }

        // Store the new associative array in $new_url
        $new_url = $url;

        // Combine the new elements into a string and return it
        return
            ((isset($url['scheme'])) ? $url['scheme'] . '://' : '')
            . ((isset($url['user'])) ? $url['user'] . ((isset($url['pass'])) ? ':' . $url['pass'] : '') . '@' : '')
            . ((isset($url['host'])) ? $url['host'] : '')
            . ((isset($url['port'])) ? ':' . $url['port'] : '')
            . ((isset($url['path'])) ? $url['path'] : '')
            . ((isset($url['query'])) ? '?' . $url['query'] : '')
            . ((isset($url['fragment'])) ? '#' . $url['fragment'] : '')
        ;
    }
}