<?php namespace Arcanedev\EmbedVideo\Tests\Parsers;

/**
 * Class     VimeoParserTest
 *
 * @package  Arcanedev\EmbedVideo\Tests\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class VimeoParserTest extends AbstractParserTest
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  string */
    protected $parserKey = 'vimeo';

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
            \Arcanedev\EmbedVideo\Parsers\VimeoParser::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->parser);
        }

        $this->assertNull($this->parser->url());
        $this->assertEmpty($this->parser->attributes());
        $this->assertEmpty($this->parser->queries());
    }

    /** @test */
    public function it_can_parse_url()
    {
        $id         = '101143287';
        $url        = 'https://vimeo.com/'.$id;
        $attributes = ['width' => 640];

        $result = $this->parser->setAttributes($attributes)->parse($url);

        $this->assertTrue($result);
        $this->assertSame($id,         $this->parser->videoId());
        $this->assertSame($url,        $this->parser->url());
        $this->assertSame($attributes, $this->parser->attributes());
    }

    /** @test */
    public function it_can_check_parsing()
    {
        $this->assertTrue($this->parser->parse('https://vimeo.com/101143287'));

        $this->assertFalse($this->parser->parse('http://example.org/video-id.mov'));
    }

    /** @test */
    public function it_can_set_and_get_attributes()
    {
        $this->parser->setAttribute('height', 100)
            ->parse('https://vimeo.com/101143287');

        $this->assertEquals(['height' => 100], $this->parser->attributes());
    }

    /** @test */
    public function it_can_switch_http_protocol_to_secure_if_supported()
    {
        $this->parser->parse('http://vimeo.com/101143287');

        $this->assertEquals('https://vimeo.com/101143287', $this->parser->getInfoUrl());
    }

    /** @test */
    public function it_can_render_embed_html()
    {
        $this->parser->parse('http://vimeo.com/101143287');

        $this->parser->setAttributes([
            'width' => 640,
            'height' => 360,
            'frameborder' => 0,
            'webkitallowfullscreen',
            'mozallowfullscreen',
            'allowfullscreen',
        ]);

        $iFrame = $this->parser->iframe();

        $this->assertEquals(
            '<iframe src="https://player.vimeo.com/video/101143287" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
            $iFrame->toHtml()
        );
    }
}
