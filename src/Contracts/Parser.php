<?php namespace Arcanedev\EmbedVideo\Contracts;

/**
 * Interface  Parser
 *
 * @package   Arcanedev\EmbedVideo\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Parser
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the URL.
     *
     * @return string|null
     */
    public function url();

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function attributes();

    /**
     * Set a attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setAttribute($key, $value);

    /**
     * Set the attributes.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes);

    /**
     * Get the URL queries.
     *
     * @return array
     */
    public function queries();

    /**
     * Set a query parameter.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setQuery($key, $value = null);

    /**
     * Get the video id.
     *
     * @return mixed
     */
    public function videoId();

    /**
     * Get the info URL.
     *
     * @return string
     */
    public function getInfoUrl();

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Parse the given url.
     *
     * @param  string  $url
     *
     * @return bool
     */
    public function parse($url);

    /**
     * Create an iframe entity.
     *
     * @return \Arcanedev\EmbedVideo\Entities\Iframe
     */
    public function iframe();
}
