<?php namespace Arcanedev\EmbedVideo\Tests;

/**
 * Class     EmbedVideoServiceProviderTest
 *
 * @package  Arcanedev\EmbedVideo\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EmbedVideoServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  \Arcanedev\EmbedVideo\EmbedVideoServiceProvider */
    protected $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(\Arcanedev\EmbedVideo\EmbedVideoServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

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
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\EmbedVideo\EmbedVideoServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            \Arcanedev\EmbedVideo\Contracts\Embed::class,
            \Arcanedev\EmbedVideo\Contracts\ParserManager::class,
        ];

        $this->assertSame($expected, $this->provider->provides());
    }
}
