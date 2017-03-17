<?php namespace Arcanedev\EmbedVideo;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     EmbedVideoServiceProvider
 *
 * @package  Arcanedev\EmbedVideo
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EmbedVideoServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'embed-video';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();

        $this->singleton(Contracts\ParserManager::class, function ($app) {
            return new ParserManager($app);
        });
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\Embed::class,
            Contracts\ParserManager::class,
        ];
    }
}
