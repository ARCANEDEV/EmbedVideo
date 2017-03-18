<?php namespace Arcanedev\EmbedVideo\Entities;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

/**
 * Class     Iframe
 *
 * @package  Arcanedev\EmbedVideo\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Iframe implements Htmlable
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
    protected $queries;

    /**
     * @var array
     */
    protected $replacer;

    /**
     * @var array
     */
    protected $attributes;

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
        return $this->renderUrl().$this->renderQueries();
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
        return new HtmlString(
            '<iframe src="'.$this->src().'"'.$this->renderAttributes().'></iframe>'
        );
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render()->toHtml();
    }

    /**
     * Convert the object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Render the base URL.
     *
     * @return string
     */
    public function renderUrl()
    {
        return str_replace(
            array_keys($this->replacer),
            array_values($this->replacer),
            $this->pattern
        );
    }

    /**
     * Render the URL queries.
     *
     * @return string
     */
    public function renderQueries()
    {
        return empty($this->queries) ? '' : '?'.http_build_query($this->queries);
    }

    /**
     * Render the attributes.
     *
     * @return string
     */
    public function renderAttributes()
    {
        $output = [];

        foreach ($this->attributes as $key => $value) {
            $output[] = is_int($key) ? $value : $key.'="'.e($value).'"';
        };

        return empty($output) ? '' : ' '.implode(' ', $output);
    }
}
