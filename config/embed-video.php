<?php

return [
    /* -----------------------------------------------------------------
     |  Parsers
     | -----------------------------------------------------------------
     */
    'default' => 'youtube',

    'parsers' => [

        /* -----------------------------------------------------------------
         |  Youtube
         | -----------------------------------------------------------------
         */
        'youtube' => [
            'class'   => \Arcanedev\EmbedVideo\Parsers\YoutubeParser::class,

            'options' => [
                'patterns' => [
                    '^(https?://)?(?:www\.)?youtu\.be/([0-9a-zA-Z-_]{11})?(?:(?:\S+)?(?:\?|&)t=([0-9hm]+s))?(?:\S+)?',
                    '^(https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=))((?:\w|-){11})(?:(?:\S+)?(?:\?|&)t=([0-9hm]+s))?(?:\S+)?$'
                ],
            ],
        ],

        /* -----------------------------------------------------------------
         |  Vimeo
         | -----------------------------------------------------------------
         */
        'vimeo'   => [
            'class'   => \Arcanedev\EmbedVideo\Parsers\VimeoParser::class,

            'options' => [
                'patterns' => [
                    '(https?://)?(?:www\.)?vimeo\.com/([0-9]+)',
                    '(https?://)?(?:www\.)?vimeo\.com/m/([0-9]+)',
                ],
            ],
        ],

        /* -----------------------------------------------------------------
         |  Twitch
         | -----------------------------------------------------------------
         */
        'twitch' => [
            'class'   => \Arcanedev\EmbedVideo\Parsers\TwitchParser::class,

            'options' => [
                'patterns' => [
                    '^(https?://)?(?:www\.)?twitch\.tv/videos/([0-9a-zA-Z-_]+)',
                ],
            ],
        ],

    ],
];
