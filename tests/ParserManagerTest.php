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

    /** @test */
    public function it_can_guess_parser_via_url()
    {
        $expectations = [
            \Arcanedev\EmbedVideo\Parsers\YoutubeParser::class => [
                'https://youtu.be/AvKvi406-M8',
                'http://youtube.com/watch?v=AvKvi406-M8',
                'http://youtube.com/v/AvKvi406-M8',
            ],

            \Arcanedev\EmbedVideo\Parsers\VimeoParser::class => [
                'https://vimeo.com/101143287',
            ],

            \Arcanedev\EmbedVideo\Parsers\TwitchParser::class => [
                'https://twitch.tv/videos/129350303',
            ],
        ];

        foreach ($expectations as $class => $urls) {
            foreach ($urls as $url) {
                $parser = $this->manager->guess($url);

                $this->assertInstanceOf($class, $parser);
                $this->assertSame($url, $parser->url());
            }
        }
    }

    /** @test */
    public function it_can_guess_custom_url()
    {
        $parser = $this->manager->guess('http://example.org/video-id.mov');

        $this->assertNull($parser);
    }
}
