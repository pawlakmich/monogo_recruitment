<?php

namespace Monogo\Recruitment\ViewModel;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Monogo\Recruitment\Service\QRCodeService;

class QrCode implements ArgumentInterface
{
    /**
     * @var QRCodeService
     */
    protected QRCodeService $qrGeneratorService;

    /**
     * @var Registry
     */
    protected Registry $registry;

    /**
     * @param QRCodeService $qrGeneratorService
     * @param Registry $registry
     */
    public function __construct(
        QRCodeService $qrGeneratorService,
        Registry      $registry)
    {
        $this->qrGeneratorService = $qrGeneratorService;
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getQrCode(): string
    {
        return $this->qrGeneratorService->getQrCode($this->registry->registry('current_product'));
    }
}
