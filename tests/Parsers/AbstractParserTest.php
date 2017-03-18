<?php namespace Arcanedev\EmbedVideo\Tests\Parsers;

use Arcanedev\EmbedVideo\Tests\TestCase;

/**
 * Class     AbstractParserTest
 *
 * @package  Arcanedev\EmbedVideo\Tests\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractParserTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  string */
    protected $parserKey;

    /** @var  \Arcanedev\EmbedVideo\Contracts\Parser */
    protected $parser;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->parser = $this->getParser($this->parserKey);
    }

    public function tearDown()
    {
        unset($this->parser);

        parent::tearDown();
    }

    /**
     * Get the parser manager.
     *
     * @return \Arcanedev\EmbedVideo\Contracts\ParserManager
     */
    protected function getParserManager()
    {
        return $this->app->make(\Arcanedev\EmbedVideo\Contracts\ParserManager::class);
    }

    /**
     * Get a parser.
     *
     * @param  string  $key
     *
     * @return \Arcanedev\EmbedVideo\Contracts\Parser
     */
    protected function getParser($key)
    {
        return $this->getParserManager()->parser($key);
    }
}
