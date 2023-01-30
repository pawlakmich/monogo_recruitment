<?php

namespace Monogo\Recruitment\Service;

use Monogo\Recruitment\Api\QrApiRequestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

class QrApiRequest implements QrApiRequestInterface
{
    /**
     * @var ResponseFactory
     */
    protected ResponseFactory $responseFactory;

    /**
     * @var ClientFactory
     */
    protected ClientFactory $clientFactory;

    /**
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_POST
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => QrApiRequestInterface::QR_API_URL
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (RequestException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage(),
                'body' => $exception->getResponse() ? $exception->getResponse()->getBody() : ''
            ]);
        } catch (GuzzleException $exception) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage(),
            ]);
        }

        return $response;
    }

    /**
     * @param array $body
     * @return string[]
     */
    protected function getErrors(array $body): array
    {
        $result = [];
        if (!empty($body['errorMSG'])) {
            $result[] = $body['errorMSG'];
        }

        $errors = $body['errors'] ?? [];
        if (is_array($errors)) {
            foreach ($errors as $error) {
                $result[] = $error;
            }
        }

        return $result;
    }
}
