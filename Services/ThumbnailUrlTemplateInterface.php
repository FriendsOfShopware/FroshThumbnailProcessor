<?php

namespace FroshThumbnailProcessor\Services;

interface ThumbnailUrlTemplateInterface
{
    public function getUrl($mediaUrl, $mediaPath, $width, $height);
}
