<?php

namespace FroshThumbnailProcessor\Services;

use Shopware\Bundle\MediaBundle\MediaServiceInterface;

class ThumbnailUrlTemplate implements ThumbnailUrlTemplateInterface
{
    private $pattern;

    /* @var MediaServiceInterface */
    private $mediaService;

    public function __construct(MediaServiceInterface $mediaService, array $config)
    {
        $this->pattern = $config['ThumbnailPattern'] ?: '{mediaUrl}/{mediaPath}?width={width}&height={height}';
        $this->mediaService = $mediaService;
    }

    /**
     * @param $mediaPath
     * @param $width
     * @param $height
     * @param bool|string $mediaUrl
     *
     * @return string
     */
    public function getUrl($mediaPath, $width, $height, $mediaUrl = false)
    {
        $result = $this->pattern;

        if ($mediaUrl === true) {
            $mediaUrl = substr($this->mediaService->getUrl('/'), 0, -1);
        }

        $mediaPath = $this->mediaService->encode($mediaPath);

        $result = str_replace(
            ['{mediaUrl}', '{mediaPath}', '{width}', '{height}'],
            [$mediaUrl, $mediaPath, $width, $height], $result);

        /*$variables = [];
        preg_match_all('/{(.*?)}/', $this->pattern, $variables);


        foreach ($variables[0] as $variable) {
            str_replace($variable,);
        }*/
        return $result;
    }
}
