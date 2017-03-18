<?php namespace Arcanedev\EmbedVideo\Parsers;

/**
 * Class     VimeoParser
 *
 * @package  Arcanedev\EmbedVideo\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class VimeoParser extends AbstractParser
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the video id from cached matches.
     *
     * @return mixed
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
        return [];
    }

    /**
     * Get the iframe pattern.
     *
     * @return string
     */
    protected function getIframePattern()
    {
        return '{protocol}://player.vimeo.com/video/{id}';
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

    /**
     * Get the info URL.
     *
     * @return string
     */
    public function getInfoUrl()
    {
        return $this->protocol.'://vimeo.com/'.$this->videoId();
    }
}
