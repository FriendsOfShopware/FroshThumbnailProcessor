<?php

namespace FroshThumbnailProcessor\Services;

use Shopware\Bundle\MediaBundle\MediaServiceInterface;

class MediaService implements MediaServiceInterface
{
    /**
     * @var MediaServiceInterface
     */
    private $mediaServiceParent;

    public function __construct(MediaServiceInterface $mediaServiceParent)
    {
        $this->mediaServiceParent = $mediaServiceParent;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($path)
    {
        if ($this->isEncoded($path) && (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0)) {
            return $path;
        }

        return $this->mediaServiceParent->getUrl($path);
    }

    /**
     * {@inheritdoc}
     */
    public function read($path)
    {
        return $this->mediaServiceParent->read($path);
    }

    /**
     * {@inheritdoc}
     */
    public function readStream($path)
    {
        return $this->mediaServiceParent->readStream($path);
    }

    /**
     * {@inheritdoc}
     */
    public function write($path, $contents, $append = false)
    {
        return $this->mediaServiceParent->write($path, $contents, $append);
    }

    /**
     * {@inheritdoc}
     */
    public function writeStream($path, $resource, $append = false)
    {
        return $this->mediaServiceParent->writeStream($path, $resource, $append);
    }

    /**
     * {@inheritdoc}
     */
    public function listFiles($directory = '')
    {
        return $this->mediaServiceParent->listFiles($directory);
    }

    /**
     * {@inheritdoc}
     */
    public function has($path)
    {
        return $this->mediaServiceParent->has($path);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path)
    {
        return $this->mediaServiceParent->delete($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getSize($path)
    {
        return $this->mediaServiceParent->getSize($path);
    }

    /**
     * {@inheritdoc}
     */
    public function rename($path, $newpath)
    {
        return $this->mediaServiceParent->rename($path, $newpath);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($path)
    {
        return $this->mediaServiceParent->normalize($path);
    }

    /**
     * {@inheritdoc}
     */
    public function encode($path)
    {
        return $this->mediaServiceParent->encode($path);
    }

    /**
     * {@inheritdoc}
     */
    public function isEncoded($path)
    {
        return $this->mediaServiceParent->isEncoded($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapterType()
    {
        return $this->mediaServiceParent->getAdapterType();
    }

    /**
     * {@inheritdoc}
     */
    public function createDir($dirname)
    {
        return $this->mediaServiceParent->createDir($dirname);
    }

    /**
     * {@inheritdoc}
     */
    public function migrateFile($path)
    {
        return $this->mediaServiceParent->migrateFile($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilesystem()
    {
        return $this->mediaServiceParent->getFilesystem();
    }
}
