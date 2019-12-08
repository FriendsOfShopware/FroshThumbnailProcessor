<?php

namespace FroshThumbnailProcessor\Bundle\Commands;

use Doctrine\ORM\AbstractQuery;
use Shopware\Commands\ShopwareCommand;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Media\Media;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveThumbnails extends ShopwareCommand
{
    private $modelManager;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('frosh:thumbnails:remove')
            ->setDescription('Removes all thumbnails from current filesystem')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' #We\'ll search all media and remove their thumbnails');
        $output->writeln('');

        $sizes = $this->getAllThumbnailSizes();

        /** @var \Shopware\Models\Media\Repository $repository */
        $repository = Shopware()->Models()->getRepository(Media::class);
        $query = $repository->getMediaListQuery();

        /*
         * we need to get it in array, cause missing album would run into error - f.e. in demoshop
         */
        $mediaList = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
        $totalResult = count($mediaList);

        $progressBar = new ProgressBar($output, $totalResult);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent%%, Elapsed: %elapsed%' . "\n" . ' Current file: %filename%');
        $progressBar->setMessage('', 'filename');

        /** @var array $media */
        foreach ($mediaList as $media) {
            $mediaModel = new Media();
            $mediaModel->fromArray($media);

            $progressBar->setMessage($media['path'], 'filename');

            $mediaModel->removeAlbumThumbnails($sizes, $mediaModel->getFileName());
            $progressBar->advance();
        }

        $progressBar->setMessage('', 'filename');
        $progressBar->finish();
        $output->writeln('');
    }

    /**
     * @throws \Exception
     *
     * @return ModelManager
     */
    private function getModelManager()
    {
        if (!$this->modelManager) {
            $this->modelManager = $this->container->get('models');
        }

        return $this->modelManager;
    }

    /**
     * Searches all album settings for thumbnail sizes
     */
    private function getAllThumbnailSizes(): array
    {
        $connection = $this->container->get('dbal_connection');
        $joinedSizes = $connection
            ->query('SELECT DISTINCT thumbnail_size FROM s_media_album_settings WHERE thumbnail_size != ""')
            ->fetchAll(\PDO::FETCH_COLUMN);

        $sizes = [];
        foreach ($joinedSizes as $sizeItem) {
            $explodedSizes = explode(';', $sizeItem);
            if (empty($explodedSizes)) {
                continue;
            }

            $sizes = array_merge($sizes, array_flip($explodedSizes));
        }

        return array_keys($sizes);
    }
}
