<?php

namespace FroshThumbnailProcessor\Services;

class ThumbnailUrlTemplate implements ThumbnailUrlTemplateInterface
{
    private $pattern;

    public function __construct()
    {
        $this->pattern = '{mediaUrl}/{mediaPath}?width={width}&height={height}';
    }

    public function getUrl($mediaUrl, $mediaPath, $width, $height)
    {
        $result = $this->pattern;

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
