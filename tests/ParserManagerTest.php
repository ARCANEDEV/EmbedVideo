<?php namespace Arcanedev\EmbedVideo\Tests;

/**
 * Class     ParserManagerTest
 *
 * @package  Arcanedev\EmbedVideo\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ParserManagerTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  \Arcanedev\EmbedVideo\ParserManager */
    protected $manager;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = $this->app->make(\Arcanedev\EmbedVideo\Contracts\ParserManager::class);
    }

    public function tearDown()
    {
        unset($this->manager);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\EmbedVideo\Contracts\ParserManager::class,
            \Arcanedev\EmbedVideo\ParserManager::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->manager);
        }
    }

    /** @test */
    public function it_can_build_parsers()
    {
        $this->assertInstanceOf(
            \Arcanedev\EmbedVideo\Parsers\YoutubeParser::class,
            $this->manager->parser('youtube')
        );

        $this->assertInstanceOf(
            \Arcanedev\EmbedVideo\Parsers\VimeoParser::class,
            $this->manager->parser('vimeo')
        );
    }
}
