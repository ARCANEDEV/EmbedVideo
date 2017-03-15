<?php

return [
    /* -----------------------------------------------------------------
     |  Parsers
     | -----------------------------------------------------------------
     */
    'parsers' => [
        'default' => 'youtube',

        'supported' => [
            'youtube' => [
                'class'   => \Arcanedev\EmbedVideo\Parsers\YoutubeParser::class,
                'options' => [],
            ],

            'vimeo'   => [
                'class'   => \Arcanedev\EmbedVideo\Parsers\VimeoParser::class,
                'options' => [],
            ],
        ]
    ],
];
