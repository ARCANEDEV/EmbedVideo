<?php namespace Arcanedev\EmbedVideo\Tests\Parsers;

use Arcanedev\EmbedVideo\Tests\TestCase;

/**
 * Class     YoutubeParserTest
 *
 * @package  Arcanedev\EmbedVideo\Tests\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class YoutubeParserTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  \Arcanedev\EmbedVideo\Parsers\YoutubeParser */
    protected $parser;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->parser = $this->getParserManager()->parser('youtube');
    }

    public function tearDown()
    {
        unset($this->parser);

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
            \Arcanedev\EmbedVideo\Contracts\Parser::class,
            \Arcanedev\EmbedVideo\Parsers\AbstractParser::class,
            \Arcanedev\EmbedVideo\Parsers\YoutubeParser::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->parser);
        }

        $this->assertNull($this->parser->url());
        $this->assertSame([], $this->parser->attributes());
        $this->assertSame([
            'rel'   => 0,
            'wmode' => 'transparent',
        ], $this->parser->queries());
    }

    /** @test */
    public function it_parse_url()
    {
        $id         = 'AvKvi406-M8';
        $url        = 'https://youtu.be/'.$id;
        $attributes = ['width' => 100];
        $queries    = [
            'rel'   => 0,
            'wmode' => 'transparent',
        ];

        $this->parser->parse($url)->setAttributes($attributes);

        $this->assertSame($url, $this->parser->url());
        $this->assertSame($attributes, $this->parser->attributes());
        $this->assertSame($queries, $this->parser->queries());
    }

    /**
     * @test
     *
     * @dataProvider provideUrlsWithTimestamp
     *
     * @param  string  $url
     * @param  string  $src
     * @param  string  $render
     */
    public function it_can_parse_url_with_timestamp($url, $src, $render)
    {
        $this->parser->parse($url);

        $iFrame = $this->parser->iframe();

        $this->assertInstanceOf(\Arcanedev\EmbedVideo\Entities\Iframe::class, $iFrame);
        $this->assertEquals($src, $iFrame->src());
        $this->assertSame($render, $iFrame->render()->toHtml());
    }

    /**
     * Provide urls with timestamp.
     *
     * @return array
     */
    public function provideUrlsWithTimestamp()
    {
        $id = 'AvKvi406-M8';

        return [
            [
                "http://youtu.be/{$id}?t=2m10s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=130",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=130"></iframe>'
            ],[
                "http://youtu.be/{$id}?t=56s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=56",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=56"></iframe>',
            ],[
                "http://youtu.be/{$id}?t=1h20m57s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=4857",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=4857"></iframe>',
            ],[
                "http://youtu.be/{$id}?t=1h20m57s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=4857",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=4857"></iframe>',
            ],[
                "http://youtu.be/{$id}?x=1&t=24m10s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=1450",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=1450"></iframe>',
            ],[
                "http://youtube.com/watch?v={$id}&t=24m10s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=1450",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=1450"></iframe>',
            ],[
                "http://youtube.com/v/{$id}?t=24m10s",
                "https://www.youtube.com/embed/{$id}?rel=0&wmode=transparent&start=1450",
                '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent&start=1450"></iframe>',
            ],
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get the parser manager.
     *
     * @return \Arcanedev\EmbedVideo\Contracts\ParserManager
     */
    protected function getParserManager()
    {
        return $this->app->make(\Arcanedev\EmbedVideo\Contracts\ParserManager::class);
    }
}
