<?php namespace Arcanedev\EmbedVideo\Parsers;

/**
 * Class     TwitchParser
 *
 * @package  Arcanedev\EmbedVideo\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TwitchParser extends AbstractParser
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the default URL queries.
     *
     * @return array
     */
    protected function defaultQueries()
    {
        return [
            //
        ];
    }

    /**
     * Get the iframe pattern.
     *
     * @return string
     */
    protected function getIframePattern()
    {
        $this->prependQuery('video', 'v'.$this->videoId());

        return 'https://player.twitch.tv/';
    }

    /**
     * Get the iframe replace.
     *
     * @return array
     */
    protected function getIframeReplacer()
    {
        return [
            //
        ];
    }

    /**
     * Get the video id.
     *
     * @return mixed
     */
    public function videoId()
    {
        return $this->getCached(2);
    }

    /**
     * Get the info URL.
     *
     * @return string
     */
    public function getInfoUrl()
    {
        return $this->protocol.'://twitch.tv/videos/'.$this->videoId();
    }
}
