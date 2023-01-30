<?php

namespace Monogo\Recruitment\Model;

use Exception;
use Magento\Catalog\Model\ResourceModel\Product\Action as ProductAction;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Monogo\Recruitment\Api\ConsumerInterface;
use Monogo\Recruitment\Api\Consumer\MessageInterface;

class Consumer implements ConsumerInterface
{
    /**
     * @var string
     */
    public const PRODUCTS_NAMES_ATTRIBUTE = 'products_names';

    /**
     * @var ProductCollectionFactory
     */
    protected ProductCollectionFactory $productCollectionFactory;

    /**
     * @var ProductAction
     */
    protected ProductAction $productAction;

    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ProductAction $productAction
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        ProductAction $productAction
    )
    {
        $this->productAction = $productAction;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @param MessageInterface $message
     * @throws Exception
     */
    public function processMessage(MessageInterface $message)
    {
        $productId = $message->getProductId();
        $productsNames = $this->productCollectionFactory->create()
            ->addAttributeToSelect('name')
            ->addFieldToSelect('name')
            ->getColumnValues('name');
        $productsNamesString = implode(',', $productsNames);

        $this->productAction->updateAttributes(
            [$productId],
            [self::PRODUCTS_NAMES_ATTRIBUTE => $productsNamesString],
            0
        );
    }
}
