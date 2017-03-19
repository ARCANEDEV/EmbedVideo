<?php namespace Arcanedev\EmbedVideo\Parsers;

use Arcanedev\EmbedVideo\Contracts\Parser;
use Arcanedev\EmbedVideo\Entities\Iframe;
use Illuminate\Support\Arr;

/**
 * Class     AbstractParser
 *
 * @package  Arcanedev\EmbedVideo\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractParser implements Parser
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The given URL to be parsed.
     *
     * @var string|null
     */
    protected $url;

    /**
     * The parser's URL patterns.
     *
     * @var array
     */
    protected $patterns   = [];

    /**
     * The iframe attribute.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $cachedMatches;

    /**
     * Use a secure HTTP Protocol.
     *
     * @var bool
     */
    protected $useSecure = true;

    /**
     * The HTTP Protocol.
     *
     * @var string
     */
    protected $protocol = 'https';

    /**
     * Timestamp pattern and param.
     *
     * @var array
     */
    protected $timestamp = [
        'pattern' => null,
        'param'   => null,
    ];

    /**
     * The URL Queries.
     *
     * @var array
     */
    protected $queries = [];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * AbstractParser constructor.
     *
     * @param  array  $options
     */
    public function __construct(array $options)
    {
        $this->queries  = $this->defaultQueries();
        $this->patterns = Arr::get($options, 'patterns', []);
        $this->setAttributes(Arr::get($options, 'attributes', []));
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the URL.
     *
     * @return string|null
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Set the URL.
     *
     * @param  string  $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->reset();

        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Set a attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setAttribute($key, $value)
    {
        Arr::set($this->attributes, $key, $value);

        return $this;
    }

    /**
     * Set the attributes.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the URL queries.
     *
     * @return array
     */
    public function queries()
    {
        return $this->queries;
    }

    /**
     * Set a query parameter.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setQuery($key, $value = null)
    {
        $this->queries = Arr::set($this->queries, $key, $value);

        return $this;
    }

    /**
     * Prepend a query parameter.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    protected function prependQuery($key, $value)
    {
        $this->queries = Arr::prepend($this->queries, $value, $key);

        return $this;
    }

    /**
     * Get the default URL queries.
     *
     * @return array
     */
    abstract protected function defaultQueries();

    /**
     * Get value from cached matches.
     *
     * @param  int         $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function getCached($key, $default = null)
    {
        return Arr::get($this->cachedMatches, $key, $default);
    }

    /**
     * Get the iframe pattern.
     *
     * @return string
     */
    abstract protected function getIframePattern();

    /**
     * Get the iframe replace.
     *
     * @return array
     */
    abstract protected function getIframeReplacer();

    /* -----------------------------------------------------------------
     |  Main method
     | -----------------------------------------------------------------
     */
    /**
     * Parse the given url.
     *
     * @param  string  $url
     *
     * @return bool
     */
    public function parse($url = null)
    {
        if ( ! is_null($url)) $this->setUrl($url);

        foreach ($this->patterns as $pattern) {
            if (preg_match('~'.$pattern.'~imu', $this->url, $matches)) {
                $this->cachedMatches = $matches;
                $this->parseProtocol();
                $this->parseTimestamp();
                $this->parseCustomParsing();

                return true;
            }
        }

        return false;
    }

    /**
     * Create an iframe entity.
     *
     * @return \Arcanedev\EmbedVideo\Entities\Iframe
     */
    public function iframe()
    {
        return new Iframe(
            $this->getIframePattern(),
            $this->getIframeReplacer(),
            $this->queries(),
            $this->attributes()
        );
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Parse the HTTP protocol.
     *
     * @throws \Exception
     */
    private function parseProtocol()
    {
        $protocol = $this->cachedMatches[1];

        if ( ! in_array($protocol, ['http://', 'https://']))
            $protocol = 'http://';

        if (is_null($this->url))
            throw new \Exception('Cannot detect protocol if URL or provider were not set.');

        $this->protocol = ($this->useSecure || $protocol === 'https://') ? 'https' : 'http';
    }

    /**
     * Parse the timestamp.
     */
    protected function parseTimestamp()
    {
        if ( ! $this->hasTimestampOption()) return;

        if (preg_match('~'.$this->timestamp['pattern'].'~imu', $this->url, $matches)) {
            unset($matches[0]);
            $multipliers = [3600, 60, 1];
            $timestamp   = 0;
            foreach (array_values($matches) as $key => $match) {
                $timestamp += (int) $match * $multipliers[$key];
            }
            $this->queries[$this->timestamp['param']] = $timestamp;
        }
    }

    /**
     * Check if the parser has a defined timestamp parsing.
     *
     * @return bool
     */
    protected function hasTimestampOption()
    {
        return is_string(Arr::get($this->timestamp, 'pattern'))
            && is_string(Arr::get($this->timestamp, 'param'));
    }

    /**
     * Enable to perform custom parsing.
     */
    protected function parseCustomParsing()
    {
        //
    }

    /**
     * Reset the parser.
     */
    private function reset()
    {
        $this->cachedMatches = [];
        $this->queries       = $this->defaultQueries();
    }
}
