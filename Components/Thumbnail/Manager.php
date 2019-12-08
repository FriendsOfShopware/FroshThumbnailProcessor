<?php

namespace FroshThumbnailProcessor\Components\Thumbnail;

use FroshThumbnailProcessor\Services\ThumbnailUrlTemplateInterface;
use Shopware\Bundle\MediaBundle\MediaServiceInterface;
use Shopware\Components\Thumbnail\Generator\GeneratorInterface;

class Manager extends \Shopware\Components\Thumbnail\Manager
{
    /**
     * This generator will be used for the thumbnail creation itself
     *
     * @var GeneratorInterface
     */
    protected $generator;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var \Enlight_Event_EventManager
     */
    protected $eventManager;

    /**
     * @var MediaServiceInterface
     */
    private $mediaService;

    private $shouldRun = true;

    /* @var ThumbnailUrlTemplateInterface */
    private $thumbnailUrlTpl;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        GeneratorInterface $generator,
        $rootDir,
        \Enlight_Event_EventManager $eventManager,
        MediaServiceInterface $mediaService
    ) {
        $this->generator = $generator;
        $this->rootDir = $rootDir;
        $this->eventManager = $eventManager;
        $this->mediaService = $mediaService;

        if (!Shopware()->Container()->get('frosh_thumbnail_processor.config')['ThumbnailProcessor']) {
            $this->shouldRun = false;
        }

        $this->thumbnailUrlTpl = Shopware()->Container()->get('frosh_thumbnail_processor.services.thumbnail_url_template');
    }

    /**
     * {@inheritdoc}
     */
    public function getMediaThumbnails($name, $type, $extension, array $sizes)
    {
        if (!$this->shouldRun) {
            return parent::getMediaThumbnails($name, $type, $extension, $sizes);
        }

        $sizes = $this->uniformThumbnailSizes($sizes);
        $path = 'media/' . strtolower($type) . '/';

        $thumbnails = [];
        foreach ($sizes as $size) {
            $thumbnails[] = [
                'maxWidth' => $size['width'],
                'maxHeight' => $size['height'],
                'source' => $this->thumbnailUrlTpl->getUrl($path . $name . '.' . $extension, $size['width'],
                    $size['height']),
                'retinaSource' => $this->thumbnailUrlTpl->getUrl($path . $name . '.' . $extension, $size['width'] * 2,
                    $size['height'] * 2),
            ];
        }

        return $thumbnails;
    }
}
