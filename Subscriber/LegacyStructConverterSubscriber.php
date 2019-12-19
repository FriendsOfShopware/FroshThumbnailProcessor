<?php

namespace FroshThumbnailProcessor\Subscriber;

use Enlight\Event\SubscriberInterface;
use FroshThumbnailProcessor\Services\ThumbnailUrlTemplateInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Media;
use Shopware\Bundle\StoreFrontBundle\Struct\Thumbnail;

class LegacyStructConverterSubscriber implements SubscriberInterface
{
    /* @var ThumbnailUrlTemplateInterface */
    private $thumbnailUrlTpl;

    public function __construct(ThumbnailUrlTemplateInterface $thumbnailUrlTpl)
    {
        $this->thumbnailUrlTpl = $thumbnailUrlTpl;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Legacy_Struct_Converter_Convert_Media' => 'ConvertMedia',
        ];
    }

    public function ConvertMedia(\Enlight_Event_EventArgs $args)
    {
        if (!Shopware()->Container()->get('frosh_thumbnail_processor.config')['ThumbnailProcessor']) {
            return;
        }

        $data = $args->getReturn();

        /** @var Media $media */
        $media = $args->get('media');

        foreach ($data['thumbnails'] as &$thumbnail) {
            $thumbnail = [
                'source' => $this->getSource($media, $thumbnail['maxWidth'], $thumbnail['maxHeight']),
                'retinaSource' => $this->getRetinaSource($media, $thumbnail['maxWidth'], $thumbnail['maxHeight']),
                'sourceSet' => $this->getSourceSet($media, $thumbnail),
                'maxWidth' => $thumbnail['maxWidth'],
                'maxHeight' => $thumbnail['maxHeight'],
                'attributes' => $thumbnail['attributes'],
            ];
        }
        unset($thumbnail);

        $args->setReturn($data);
    }

    /**
     * @return string
     */
    private function getSource(Media $media, int $maxWidth, int $maxHeight)
    {
        return $this->thumbnailUrlTpl->getUrl($media->getPath(), $maxWidth, $maxHeight);
    }

    /**
     * @return string
     */
    private function getRetinaSource(Media $media, int $maxWidth, int $maxHeight)
    {
        return $this->thumbnailUrlTpl->getUrl($media->getPath(), $maxWidth * 2, $maxHeight * 2);
    }

    /**
     * @param mixed     $media
     * @param Thumbnail $thumbnail
     *
     * @return string
     */
    private function getSourceSet($media, $thumbnail)
    {
        $source = $this->getSource($media, $thumbnail['maxWidth'], $thumbnail['maxHeight']);
        $retinaSource = $this->getRetinaSource($media, $thumbnail['maxWidth'], $thumbnail['maxHeight']);

        if ($retinaSource !== null) {
            return sprintf('%s, %s 2x', $source, $retinaSource);
        }

        return $source;
    }
}
