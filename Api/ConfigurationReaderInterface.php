<?php

namespace Monogo\Recruitment\Api;

interface ConfigurationReaderInterface
{
    /**
     * @var string
     */
    public const XML_PATH_SIZE_OF_PRODUCTS_TO_SYNC = 'products/assign/size';

    /**
     * @var string
     */
    public const XML_PATH_QR_API_USERNAME = 'products/assign/api_username';

    /**
     * @var string
     */
    public const XML_PATH_QR_API_PASSWORD = 'products/assign/api_password';

    /**
     * @var string
     */
    public const XML_PATH_QR_API_DEBUG = 'products/assign/debug';

    /**
     * @return int
     */
    public function getSizeOfProducts(): int;

    /**
     * @return string
     */
    public function getQrApiUsername(): string;
    /**
     * @return string
     */
    public function getQrApiPassword(): string;

    /**
     * @return bool
     */
    public function getDebug(): bool;
}
