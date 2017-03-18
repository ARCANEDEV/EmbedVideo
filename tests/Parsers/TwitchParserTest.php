<?php namespace Arcanedev\EmbedVideo\Tests\Parsers;

/**
 * Class     TwitchParserTest
 *
 * @package  Arcanedev\EmbedVideo\Tests\Parsers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TwitchParserTest extends AbstractParserTest
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  string */
    protected $parserKey = 'twitch';

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
            \Arcanedev\EmbedVideo\Parsers\TwitchParser::class,
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

        $id         = '129350303';
        $url        = 'https://twitch.tv/videos/'.$id;
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
        $this->assertTrue($this->parser->parse('https://twitch.tv/videos/129350303'));

        $this->assertFalse($this->parser->parse('http://example.org/video-id.mov'));
    }

    /** @test */
    public function it_can_set_and_get_attributes()
    {
        $this->parser->setAttribute('height', 100)
            ->parse('https://twitch.tv/videos/129350303');

        $this->assertEquals(['height' => 100], $this->parser->attributes());
    }

    /** @test */
    public function it_can_switch_http_protocol_to_secure_if_supported()
    {
        $this->parser->parse('http://twitch.tv/videos/129350303');

        $this->assertEquals('https://twitch.tv/videos/129350303', $this->parser->getInfoUrl());
    }

    /** @test */
    public function it_can_render_embed_html()
    {
        $this->parser->parse('http://twitch.tv/videos/129350303');

        $this->parser->setQuery('autoplay', false);
        $this->parser->setAttributes([
            'frameborder' => 0,
            'allowfullscreen' => 'true',
            'scrolling' => 'no',
            'height' => 378,
            'width' => 620,
        ]);

        $iFrame = $this->parser->iframe();

        $this->assertEquals(
            '<iframe src="https://player.twitch.tv/?video=v129350303&autoplay=false" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>',
            $iFrame->toHtml()
        );
    }
}
