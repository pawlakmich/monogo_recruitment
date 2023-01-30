<?php

namespace Monogo\Recruitment\Api;

use GuzzleHttp\Psr7\Response;
use Magento\Framework\Webapi\Rest\Request;

interface QrApiRequestInterface
{
    /**
     * @var string
     */
    public const QR_API_URL = 'https://www.de-vis-software.ro/qrcodeme.aspx';

    /**
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     * @return Response
     */
    public function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_POST
    ): Response;
}
