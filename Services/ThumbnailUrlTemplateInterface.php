<?php

namespace FroshThumbnailProcessor\Services;

interface ThumbnailUrlTemplateInterface
{
    public function getUrl($mediaPath, $width, $height, $mediaUrl = '');
}
