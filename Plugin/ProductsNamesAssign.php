<?php

namespace Monogo\Recruitment\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductsNamesAssign
{
    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $entity
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    )
    {
        $product = $entity;
        $extensionAttributes = $product->getExtensionAttributes();
        $extensionAttributes->setProductsNames($product->getProductsNames());
        $product->setExtensionAttributes($extensionAttributes);

        return $product;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductSearchResultsInterface $searchCriteria
     * @return ProductSearchResultsInterface
     */
    public function afterGetList(
        ProductRepositoryInterface $subject,
        ProductSearchResultsInterface $searchCriteria
    ) : ProductSearchResultsInterface
    {
        $products = [];
        foreach ($searchCriteria->getItems() as $entity) {
            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setProductsNames($entity->getProductsNames());
            $entity->setExtensionAttributes($extensionAttributes);
            $products[] = $entity;
        }
        $searchCriteria->setItems($products);

        return $searchCriteria;
    }
}
