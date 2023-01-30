<?php

namespace Monogo\Recruitment\Service;

use Monogo\Recruitment\Api\ConfigurationReaderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigurationReader implements ConfigurationReaderInterface
{
    /** @var ScopeConfigInterface */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * ConfigurationReader constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return int
     */
    public function getSizeOfProducts(): int
    {
        return (int)$this->scopeConfig->getValue(
            ConfigurationReaderInterface::XML_PATH_SIZE_OF_PRODUCTS_TO_SYNC,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }

    /**
     * @return string
     */
    public function getQrApiUsername(): string
    {
        return (string)$this->scopeConfig->getValue(
            ConfigurationReaderInterface::XML_PATH_QR_API_USERNAME,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }

    /**
     * @return string
     */
    public function getQrApiPassword(): string
    {
        return (string)$this->scopeConfig->getValue(
            ConfigurationReaderInterface::XML_PATH_QR_API_PASSWORD,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }

    /**
     * @return bool
     */
    public function getDebug(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ConfigurationReaderInterface::XML_PATH_QR_API_DEBUG,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
    }
}
