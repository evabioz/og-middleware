<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Crawler User Agents
    |--------------------------------------------------------------------------
    |
    | Requests from crawlers that do not support _escaped_fragment_ will
    | nevertheless be served. You can customize the list of crawlers here.
    |
    */

    'crawler_user_agents' => [
        // googlebot, yahoo, and bingbot are not in this list because
        // we support _escaped_fragment_ and want to ensure people aren't
        // penalized for cloaking.

        // 'googlebot',
        // 'yahoo',
        // 'bingbot',
        'baiduspider',
        'facebookexternalhit',
        'twitterbot',
        'rogerbot',
        'linkedinbot',
        'embedly',
        'quora link preview',
        'showyoubot',
        'outbrain',
        'pinterest',
        'developers.google.com/+/web/snippet',
        'slackbot',
    ],

    /*
    |--------------------------------------------------------------------------
    | Endpoints
    |--------------------------------------------------------------------------
    |
    | List paths or routes. You can use named route, or asterix
    | syntax (without start and end markers).
    |
    */

    'route_endpoint_list' => [

        // 'foo/bar' => OpenGraphEndpoint::class

    ],

];