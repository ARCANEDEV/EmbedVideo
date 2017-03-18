<?php namespace Arcanedev\EmbedVideo\Tests\Parsers;

/**
 * Class     YoutubeParserTest
 *
 * @package  Arcanedev\EmbedVideo\Tests\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class YoutubeParserTest extends AbstractParserTest
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  string */
    protected $parserKey = 'youtube';

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
        $this->assertEmpty($this->parser->attributes());
        $this->assertSame([
            'rel'   => 0,
            'wmode' => 'transparent',
        ], $this->parser->queries());
    }

    /** @test */
    public function it_can_parse_url()
    {
        $id         = 'AvKvi406-M8';
        $url        = 'https://youtu.be/'.$id;
        $attributes = ['width' => 100];
        $queries    = [
            'rel'   => 0,
            'wmode' => 'transparent',
        ];

        $result = $this->parser->setAttributes($attributes)->parse($url);

        $this->assertTrue($result);
        $this->assertSame($id,         $this->parser->videoId());
        $this->assertSame($url,        $this->parser->url());
        $this->assertSame($attributes, $this->parser->attributes());
        $this->assertSame($queries,    $this->parser->queries());
    }

    /** @test */
    public function it_can_check_parsing()
    {
        $this->assertTrue($this->parser->parse('http://youtu.be/AvKvi406-M8'));

        $this->assertFalse($this->parser->parse('http://example.org/video-id.mov'));
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

    /** @test */
    public function it_can_set_and_get_attributes()
    {
        $this->parser->setAttribute('height', 100)
            ->parse('http://youtu.be/AvKvi406-M8');

        $this->assertEquals(['height' => 100], $this->parser->attributes());
    }

    /** @test */
    public function it_can_switch_http_protocol_to_secure_if_supported()
    {
        $this->parser->parse('http://youtu.be/AvKvi406-M8');

        $this->assertEquals('https://youtu.be/AvKvi406-M8', $this->parser->getInfoUrl());
    }

    /** @test */
    public function it_can_render_embed_html()
    {
        $this->parser->parse('http://youtu.be/AvKvi406-M8');

        $this->parser->setAttributes([
            'width' => 560,
            'height' => 315,
            'allowfullscreen',
            'frameborder' => 0,
        ]);

        $iFrame = $this->parser->iframe();

        $this->assertEquals(
            '<iframe src="https://www.youtube.com/embed/AvKvi406-M8?rel=0&wmode=transparent" width="560" height="315" allowfullscreen frameborder="0"></iframe>',
            $iFrame->toHtml()
        );
    }
}
