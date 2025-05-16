<?php

return [

    // Where to store UTM data: 'session' (default)
    'storage' => 'session',

    // Which UTM keys to track
    'utm_keys' => [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ],

    // Table name for storing UTM visits (if using HasUtmRelation)
    'table' => 'utm_visits',

    // Fully qualified class name for related UTM model
    'related_model' => \Webudvikleren\UtmManager\Models\UtmVisit::class,
];
