<?php

namespace Monogo\Recruitment\Model\Consumer;

use Monogo\Recruitment\Api\Consumer\MessageInterface;

class Message implements MessageInterface
{
    /**
     * @var int
     */
    protected int $productId;

    /**
     * {@inheritdoc}
     */
    public function setProductId(int $productId)
    {
        return $this->productId = $productId;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }
}
