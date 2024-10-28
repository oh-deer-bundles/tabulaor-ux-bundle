<?php

namespace Odb\TabulatorUxBundle\DependencyInjection;

use Odb\TabulatorUxBundle\Builder\TabulatorBuilder;
use Odb\TabulatorUxBundle\Builder\TabulatorBuilderInterface;
use Odb\TabulatorUxBundle\Twig\TabulatorTwigExtension;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class TabulatorUxExtension  extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition('tabulator.builder', new Definition(TabulatorBuilder::class))
            ->setPublic(false)
        ;

        $container
            ->setAlias(TabulatorBuilderInterface::class, 'tabulator.builder')
            ->setPublic(false)
        ;

        $container
            ->setDefinition('tabulator.twig_extension', new Definition(TabulatorTwigExtension::class))
            ->addArgument(new Reference('stimulus.helper'))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$this->isAssetMapperAvailable($container)) {
            return;
        }

        $container->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    __DIR__.'/../../assets/dist' => '@oh-deer-bundles/tabulator-ux-bundle'
                ]
            ],
        ]);
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'].'/Resources/config/asset_mapper.php');
    }
}