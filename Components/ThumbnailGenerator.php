<?php

namespace FroshThumbnailProcessor\Components;

use Shopware\Bundle\MediaBundle\MediaService;
use Shopware\Components\Thumbnail\Generator\GeneratorInterface;

class ThumbnailGenerator implements GeneratorInterface
{
    private $parentGenerator;
    private $shouldRun = true;

    public function __construct(array $config, GeneratorInterface $parentGenerator)
    {
        $this->parentGenerator = $parentGenerator;
        if (!$config['ThumbnailProcessor']) {
            $this->shouldRun = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createThumbnail($image, $destination, $maxWidth, $maxHeight, $keepProportions = false, $quality = 90)
    {
        if (!$this->shouldRun) {
            $this->parentGenerator->createThumbnail($image, $destination, $maxWidth, $maxHeight, $keepProportions, $quality);

            return;
        }

        /*
        * We'll need just 140x140 thumbs for preview in mediamanager.
        * Waiting for https://github.com/shopware/shopware/pull/2267 to get merged!
        */
        if ((int) $maxWidth === 140) {
            $this->parentGenerator->createThumbnail($image, $destination, $maxWidth, $maxHeight, $keepProportions, $quality);
        }
    }
}
