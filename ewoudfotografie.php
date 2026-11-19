<?php

namespace Grav\Theme;

use Grav\Common\Grav;

/**
 * Site-specific child theme of Hadron (which itself extends Quark 2).
 *
 * This theme only exists to hold overrides. It does not re-implement Hadron:
 * the `streams` setting in ewoudfotografie.yaml makes `theme://` fall through to Hadron
 * and Quark 2, and this class exposes Hadron's templates as the `@hadron`
 * Twig namespace (Hadron's own onTwigLoader() does the same for `@quark2`).
 */
class Ewoudfotografie extends Hadron
{
    public static function getSubscribedEvents()
    {
        return [
            'onTwigLoader' => ['onTwigLoader', 0],
        ];
    }

    public function onTwigLoader()
    {
        parent::onTwigLoader();

        // Expose Hadron's templates as the @hadron namespace.
        $parentThemePath = Grav::instance()['locator']->findResource('themes://hadron');
        $this->grav['twig']->addPath($parentThemePath . DIRECTORY_SEPARATOR . 'templates', 'hadron');
    }
}
