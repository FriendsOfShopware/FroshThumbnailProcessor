<?php

namespace FroshThumbnailProcessor;

use Exception;
use FroshThumbnailProcessor\Components\CompilerPass\SetCustomThumbnailManager;
use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FroshThumbnailProcessor extends Plugin
{
    /**
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new SetCustomThumbnailManager());
    }
}
