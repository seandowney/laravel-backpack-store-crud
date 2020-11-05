<?php

return [

    /*
    | SeanDowney/StoreCrud configs.
    */

    // You can make sure all your URLs use this prefix by using the backpack_url() helper instead of url()
    'route_prefix' => 'store',

    /**
     * Delivery Countries
     */
    'delivery' => [
        'default' => 'IE',

        'countries' => [
            'IE' => 'Ireland',
            'UK' => 'United Kingdom',
            'US' => 'United States of America',
            'AU' => 'Australia',
        ],
    ],
];
