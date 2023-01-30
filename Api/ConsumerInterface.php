<?php

namespace Monogo\Recruitment\Api;

use Monogo\Recruitment\Api\Consumer\MessageInterface;

interface ConsumerInterface
{
    /**
     * @param MessageInterface $message
     * @return void
     */
    public function processMessage(MessageInterface $message);
}
