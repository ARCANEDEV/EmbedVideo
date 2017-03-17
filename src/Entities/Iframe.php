<?php namespace Arcanedev\EmbedVideo\Entities;

use Illuminate\Support\HtmlString;

/**
 * Class     Iframe
 *
 * @package  Arcanedev\EmbedVideo\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Iframe
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var array
     */
    private $queries;

    /**
     * @var array
     */
    private $replacer;

    /**
     * @var array
     */
    private $attributes;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * Iframe constructor.
     *
     * @param  string  $pattern
     * @param  array   $replacer
     * @param  array   $queries
     * @param  array   $attributes
     */
    public function __construct($pattern, array $replacer = [], array $queries = [], array $attributes = [])
    {
        $this->pattern    = $pattern;
        $this->replacer   = $replacer;
        $this->queries    = $queries;
        $this->attributes = $attributes;
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get iframe src value.
     *
     * @return string
     */
    public function src()
    {
        $url = str_replace(
            array_keys($this->replacer),
            array_values($this->replacer),
            $this->pattern
        );

        return $url.'?'.http_build_query($this->queries);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Render the iframe.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        return new HtmlString('<iframe src="'.$this->src().'"></iframe>');
    }

    /**
     * Convert the object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render()->toHtml();
    }
}
