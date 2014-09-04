<?php

namespace Itkg\Debug\Composer;

use Composer\Script\Event;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class Installer
{
    const EXTRA_ASSET_DIR = 'itkg_debug_asset_dir';

    public static function copyAssets(Event $event)
    {
        $destination = null;
        foreach($event->getComposer()->getRepositoryManager()->getLocalRepository()->getPackages() as $package){
            $extra = $package->getExtra();
            if (isset($extra[self::EXTRA_ASSET_DIR])) {
                $destination = $extra[self::EXTRA_ASSET_DIR];
            }
            break;
        }

        if (null == $destination) {
            return;
        }

        self::copyDirectory(__DIR__.'/../Resources/assets', $destination);
    }

    public static function copyDirectory($source, $destination)
    {
        if (is_dir($source)) {
            if (!is_dir($destination)) {
                mkdir($destination);
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
        }else {
            copy($source, $destination);
        }
    }
}
