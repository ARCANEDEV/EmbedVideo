<?php namespace Arcanedev\EmbedVideo;

use Illuminate\Support\Arr;
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
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * Parser's patterns.
     *
     * @var array
     */
    protected $patterns = [];

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

        $this->registerParsers();
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

    /**
     * Guess the parser based on the given url.
     *
     * @param  string  $url
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser|null
     */
    public function guess($url)
    {
        foreach ($this->patterns as $driver => $patterns) {
            foreach ($patterns as $pattern) {
                if (preg_match('~'.$pattern.'~imu', $url, $matches))
                    return $this->parser($driver)->setUrl($url);
            }
        }

        return null;
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
    private function registerParsers()
    {
        foreach ($this->getConfig('parsers') as $driver => $configs) {
            $this->registerParser($driver, $configs);
        }
    }

    /**
     * Register the parser.
     *
     * @param  string  $driver
     * @param  array   $configs
     */
    protected function registerParser($driver, array $configs)
    {
        $this->extend($driver, function () use ($driver, $configs) {
            return new $configs['class'](
                $configs['options']
            );
        });

        $this->registerPatterns($driver, $configs);
    }

    /**
     * Register patterns.
     *
     * @param  string  $driver
     * @param  array   $configs
     */
    protected function registerPatterns($driver, array $configs)
    {
        $this->patterns[$driver] = Arr::get($configs, 'options.patterns', []);
    }
}
