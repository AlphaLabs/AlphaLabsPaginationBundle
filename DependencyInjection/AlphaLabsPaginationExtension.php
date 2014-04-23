<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\PaginationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AlphaLabsPaginationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $declarationFiles = ['pagination.xml'];

        foreach ($declarationFiles as $file) {
            $loader->load($file);
        }

        $this->configurePagination($config['pagination'], $container);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'alphalabs_pagination';
    }

    /**
     * @param array            $config    Pagination configuration
     * @param ContainerBuilder $container Container
     */
    private function configurePagination(array $config, ContainerBuilder $container)
    {
        $container->setParameter('alphalabs_pagination.default_items_per_page', $config['items_per_page']);
        $container->setParameter('alphalabs_pagination.page_attribute_key', $config['page_attribute_key']);
        $container->setParameter('alphalabs_pagination.items_per_page_attribute_key', $config['items_per_page_attribute_key']);

        $requestBasedFactoryDefinition = $container->getDefinition(
            'alphalabs_pagination.paginated_collection_request.factory.request_based'
        );

        $requestBasedFactoryDefinition->replaceArgument(1, $config['items_per_page_attribute_key']);
        $requestBasedFactoryDefinition->replaceArgument(2, $config['page_attribute_key']);
    }
}
