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
     * Set the attributes.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes);

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Parse the given url.
     *
     * @param  string  $url
     *
     * @return self
     */
    public function parse($url);
}
