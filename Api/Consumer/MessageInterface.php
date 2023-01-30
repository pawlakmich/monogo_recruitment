<?php

namespace Monogo\Recruitment\Api\Consumer;

interface MessageInterface
{
    /**
     * @param int $productId
     * @return void
     */
    public function setProductId(int $productId);

    /**
     * @return ?int
     */
    public function getProductId(): ?int;
}
