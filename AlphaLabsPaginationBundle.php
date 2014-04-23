<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\PaginationBundle;

use AlphaLabs\Bundle\PaginationBundle\DependencyInjection\AlphaLabsPaginationExtension;
use AlphaLabs\Bundle\PaginationBundle\DependencyInjection\Compiler\FactoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlphaLabsPaginationBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension() {
        if (null === $this->extension) {
            $this->extension = new AlphaLabsPaginationExtension();
        }

        return $this->extension;
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FactoryCompilerPass());
    }
}
