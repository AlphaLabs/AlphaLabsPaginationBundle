<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\PaginationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register factories into the chained factory
 *
 * @package AlphaLabs\Bundle\PaginationBundle\DependencyInjection\Compiler
 *
 * @author  Sylvain Mauduit <swop@swop.io>
 */
class FactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('alphalabs_pagination.paginated_collection_request.factory.chained')) {
            return;
        }

        $definition = $container->getDefinition(
            'alphalabs_pagination.paginated_collection_request.factory.chained'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'alphalabs_pagination.factory'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addFactory',
                    array(new Reference($id), $attributes['priority'])
                );
            }
        }
    }
}
