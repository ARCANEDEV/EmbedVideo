<?php namespace Arcanedev\EmbedVideo\Contracts;

/**
 * Interface  ParserManager
 *
 * @package   Arcanedev\EmbedVideo\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface ParserManager
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get a video parser implementation.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    public function driver($driver = null);

    /**
     * Get a video parser implementation (alias).
     *
     * @param  string  $parser
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    public function parser($parser = null);
}
