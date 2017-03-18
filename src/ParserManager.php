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
        return $this->getConfig('default');
    }

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->registerParser();
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get a video parser implementation.
     *
     * @param  string  $parser
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    public function parser($parser = null)
    {
        return $this->driver($parser);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
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

    /**
     * Register the parsers.
     */
    private function registerParser()
    {
        foreach ($this->getConfig('parsers') as $driver => $configs) {
            $this->extend($driver, function () use ($driver, $configs) {
                return $this->buildParser($driver, $configs);
            });
        }
    }

    /**
     * Build the parser.
     *
     * @param  string  $driver
     * @param  array   $configs
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    private function buildParser($driver, array $configs)
    {
        return new $configs['class'](
            $configs['options']
        );
    }
}
