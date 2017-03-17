<?php namespace Arcanedev\EmbedVideo\Parsers;

/**
 * Class     YoutubeParser
 *
 * @package  Arcanedev\EmbedVideo\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class YoutubeParser extends AbstractParser
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The parser's URL patterns.
     *
     * @var array
     */
    protected $patterns = [
        '^(https?://)?(?:www\.)?youtu\.be/([0-9a-zA-Z-_]{11})?(?:(?:\S+)?(?:\?|&)t=([0-9hm]+s))?(?:\S+)?',
        '^(https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=))((?:\w|-){11})(?:(?:\S+)?(?:\?|&)t=([0-9hm]+s))?(?:\S+)?$'
    ];

    /**
     * Timestamp pattern and param.
     *
     * @var array
     */
    protected $timestamp = [
        'pattern' => '^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/)(?:\S+)?(?:(?:\S+)?(?:\?|&)t=(?:([0-9]+)h)?(?:([0-9]+)m)?(?:([0-9]+)s)?)$',
        'param'   => 'start',
    ];

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the video id from cached matches.
     *
     * @return string
     */
    public function videoId()
    {
        return $this->getCached(2);
    }

    /**
     * Get the default URL queries.
     *
     * @return array
     */
    protected function defaultQueries()
    {
        return [
            'rel'   => 0,
            'wmode' => 'transparent',
        ];
    }

    /**
     * Get the iframe pattern.
     *
     * @return string
     */
    protected function getIframePattern()
    {
        return '{protocol}://www.youtube.com/embed/{id}';
    }

    /**
     * Get the iframe replace.
     *
     * @return array
     */
    protected function getIframeReplacer()
    {
        return [
            '{protocol}' => $this->protocol,
            '{id}'       => $this->videoId(),
        ];
    }
}
