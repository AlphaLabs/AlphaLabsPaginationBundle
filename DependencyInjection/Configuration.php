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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('alphalabs_pagination')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('pagination')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('items_per_page')
                            ->info('Default number of items per page')
                            ->example('20')
                            ->defaultValue(10)
                            ->end()
                        ->scalarNode('page_attribute_key')
                            ->info('Current page attribute to seek in request')
                            ->example('_pagination_page')
                            ->defaultValue('_pagination_page')
                            ->end()
                        ->scalarNode('items_per_page_attribute_key')
                            ->info('Items per page attribute to seek in request')
                            ->example('_pagination_items_per_page')
                            ->defaultValue('_pagination_items_per_page')
                            ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
