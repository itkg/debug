<?php

namespace Itkg\Debug\Composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Post install & update command to copy debug bar assets
 *
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class Installer
{
    const EXTRA_ASSET_DIR = 'itkg_debug_asset_dir';

    /**
     * Copy assets into you assets directory
     *
     * @param Event $event
     */
    public static function copyAssets(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();
        if (!isset($extra[self::EXTRA_ASSET_DIR])) {
            return;
        }

        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

        $fs = new Filesystem();
        $fs->mirror(
            $vendorDir.'/maximebf/debugbar/src/DebugBar/Resources',
            //
            $extra[self::EXTRA_ASSET_DIR].'/vendor/maximebf/debugbar/src/DebugBar/Resources'
        );
    }
}
