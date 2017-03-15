<?php namespace Arcanedev\EmbedVideo\Facades;

use Arcanedev\EmbedVideo\Contracts\Embed as EmbedContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class     Embed
 *
 * @package  Arcanedev\EmbedVideo\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Embed extends Facade
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return EmbedContract::class; }
}
