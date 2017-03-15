<?php namespace Arcanedev\EmbedVideo;

use Illuminate\Support\Manager;
use Arcanedev\EmbedVideo\Contracts\ParserManager as ParserManagerContract;

/**
 * Class     ParserManager
 *
 * @package  Arcanedev\EmbedVideo
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ParserManager extends Manager implements ParserManagerContract
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->getConfig('parsers.default');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get a video parser implementation.
     *
     * @param  string $parser
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    public function parser($parser = null)
    {
        return $this->driver($parser);
    }

    /**
     * Create an instance of the specified parser.
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    protected function createYoutubeDriver()
    {
        return $this->buildParser('youtube');
    }

    /**
     * Create an instance of the specified parser.
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    protected function createVimeoDriver()
    {
        return $this->buildParser('vimeo');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Build the parser.
     *
     * @param  string  $key
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    protected function buildParser($key)
    {
        $config = $this->getConfig("parsers.supported.{$key}", []);

        return new $config['class'](
            $config['options']
        );
    }

    /**
     * Get the config repository.
     *
     * @return \Illuminate\Contracts\Config\Repository
     */
    protected function config()
    {
        return $this->app['config'];
    }

    /**
     * Get a config value.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    protected function getConfig($key, $default = null)
    {
        return $this->config()->get("embed-video.{$key}", $default);
    }
}
