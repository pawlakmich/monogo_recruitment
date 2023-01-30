<?php

namespace Monogo\Recruitment\Service;

use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Monogo\Recruitment\Api\QrApiRequestInterface;

class QRCodeService extends QrApiRequest
{
    /**
     * @var ConfigurationReader
     */
    protected ConfigurationReader $configurationReader;

    /**
     * @param ConfigurationReader $configurationReader
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ConfigurationReader $configurationReader,
        ClientFactory       $clientFactory,
        ResponseFactory     $responseFactory
    )
    {
        $this->configurationReader = $configurationReader;
        parent::__construct($clientFactory, $responseFactory);
    }

    /**
     * @param ProductInterface $product
     * @return string
     */
    public function getQrCode(ProductInterface $product): string
    {
        $username = $this->configurationReader->getQrApiUsername();
        $password = $this->configurationReader->getQrApiPassword();
        $productsNames = $product->getData('products_names');

        if ($username && $password && $productsNames) {
            $params = [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => ['plainText' => $productsNames],
                'debug' => $this->configurationReader->getDebug()
            ];

            $response = $this->doRequest(QrApiRequestInterface::QR_API_URL, $params);
            $body = json_decode((string)$response->getBody(), true);

            return $body['base64QRCode'] ?? '';
        }

        return '';
    }
}
