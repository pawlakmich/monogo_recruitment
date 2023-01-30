<?php

namespace Monogo\Recruitment\Service;

use Exception;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\MessageQueue\PublisherInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monogo\Recruitment\Api\Consumer\MessageInterface;
use Monogo\Recruitment\Api\Consumer\MessageInterfaceFactory;

class AssignProducts
{
    /**
     * @var int
     */
    public const PAGE_SIZE = 100;

    /**
     * @var string
     */
    public const PRODUCTS_NAMES_ATTRIBUTE = 'products_names';

    /**
     * @var string
     */
    public const DB_TOPIC_NAME = 'products.assign.db';

    /**
     * @var ProductCollectionFactory
     */
    protected ProductCollectionFactory $productCollectionFactory;

    /**
     * @var PublisherInterface
     */
    protected PublisherInterface $publisher;

    /**
     * @var MessageInterfaceFactory
     */
    protected MessageInterfaceFactory $messageInterfaceFactory;

    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param PublisherInterface $publisher
     * @param MessageInterfaceFactory $messageInterfaceFactory
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        PublisherInterface       $publisher,
        MessageInterfaceFactory  $messageInterfaceFactory
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->publisher = $publisher;
        $this->messageInterfaceFactory = $messageInterfaceFactory;
    }

    /**
     * @param int $size
     * @param OutputInterface $output
     * @return void
     */
    public function assign(int $size, OutputInterface $output)
    {
        $productCollection = $this->productCollectionFactory->create()
            ->addAttributeToSelect([self::PRODUCTS_NAMES_ATTRIBUTE, 'name', 'sku', 'entity_id'])
            ->setPageSize(self::PAGE_SIZE)
            ->setCurPage(1);
        $pages = $productCollection->getLastPageNumber();
        $counter = 0;
        try {
            for ($page = 1; $page <= $pages; $page++) {
                $productCollection->clear();
                $productCollection->setCurPage($page);
                $products = $productCollection->getItems();
                foreach ($products as $product) {
                    if ($counter < $size) {
                        $message = $this->messageInterfaceFactory->create();
                        $message->setProductId($product->getId());
                        $this->publisher->publish(self::DB_TOPIC_NAME, $message);
                        $counter++;
                    } else {
                        break 2;
                    }
                }
            }
            $output->writeln($counter . ' products assigned');
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }
    }
}
