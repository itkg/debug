<?php

namespace Itkg\Debug\Composer;

use Composer\Script\Event;

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
        $destination = null;
        $extra = $event->getComposer()->getPackage()->getExtra();
        if (!isset($extra[self::EXTRA_ASSET_DIR])) {
            return;
        }

        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        self::copyDirectory(
            $vendorDir.'/maximebf/debugbar/src/DebugBar/Resources',
            $extra[self::EXTRA_ASSET_DIR].'/vendor/maximebf/debugbar/src/DebugBar/Resources'
        );
    }

    /**
     * Copy directory helper
     *
     * @param $source
     * @param $destination
     */
    public static function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }
        $directory = dir($source);
        while (false !== ( $readdirectory = $directory->read())) {
            if ( $readdirectory == '.' || $readdirectory == '..' ) {
                continue;
            }
            $PathDir = $source . '/' . $readdirectory;
            if (is_dir( $PathDir)) {
                self::copyDirectory($PathDir, $destination . '/' . $readdirectory);
                continue;
            }
            copy($PathDir, $destination . '/' . $readdirectory);
        }

        $directory->close();
    }
}
