<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\PaginationBundle\ParamConverter;

use AlphaLabs\Pagination\Provider\PaginatedCollectionRequestProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Param converter used to fetch pagination information
 *
 * @package AlphaLabs\Bundle\PaginationBundle\ParamConverter
 *
 * @author  Sylvain Mauduit <swop@swop.io>
 */
class PaginatedCollectionRequestConverter implements ParamConverterInterface
{
    /** @const string */
    const PAGINATED_COLLECTION_REQUEST_CLASS
        = "AlphaLabs\\Pagination\\PaginatedCollection\\PaginatedCollectionRequestInterface";

    /** @var  PaginatedCollectionRequestProviderInterface */
    protected $paginatedCollectionRequestProvider;

    /**
     * Sets the pagination information provider
     *
     * @param PaginatedCollectionRequestProviderInterface $paginatedCollectionRequestProvider
     *
     * @return $this
     */
    public function setPaginatedCollectionRequestProvider(
        PaginatedCollectionRequestProviderInterface $paginatedCollectionRequestProvider
    ) {
        $this->paginatedCollectionRequestProvider = $paginatedCollectionRequestProvider;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    function apply(Request $request, ParamConverter $paramConverter)
    {
        $param = $paramConverter->getName();

        $paginatedCollectionRequest = $this->paginatedCollectionRequestProvider->getPaginatedCollectionRequest();

        $request->attributes->set($param, $paginatedCollectionRequest);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    function supports(ParamConverter $paramConverter)
    {
        if (null === $paramConverter->getClass()) {
            return false;
        }

        return static::PAGINATED_COLLECTION_REQUEST_CLASS === $paramConverter->getClass();
    }
}
