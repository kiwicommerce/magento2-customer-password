<?php
/**
 * KiwiCommerce
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us https://kiwicommerce.co.uk/contacts.
 *
 * @category   KiwiCommerce
 * @package    KiwiCommerce_CustomerPassword
 * @copyright  Copyright (C) 2018 Kiwi Commerce Ltd (https://kiwicommerce.co.uk/)
 * @license    https://kiwicommerce.co.uk/magento2-extension-license/
 */
namespace KiwiCommerce\CustomerPassword\Controller\Adminhtml\PasswordLog;

use Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker;

/**
 * Class Index
 * @package KiwiCommerce\CustomerPassword\Controller\Adminhtml\PasswordLog
 */
class Test extends \Magento\Config\Controller\Adminhtml\System\AbstractConfig
{
    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $response;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Config\Model\Config\Structure $configStructure,
        ConfigSectionChecker $sectionChecker
    ) {
        $this->response = $context->getResponse();
        parent::__construct($context, $configStructure, $sectionChecker);
    }

    /**
     * Index action
     *
     * @throws \Exception
     */
    public function execute()
    {
        $contentType = 'application/octet-stream';
        // @codingStandardsIgnoreLine
        echo $content = 'tessss';
        $contentLength = strlen($content);
        $fileName = 'tablerates.log';
        $this->response->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', $contentType, true)
            ->setHeader('Content-Length', $contentLength === null ? strlen($content) : $contentLength, true)
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"', true)
            ->setHeader('Last-Modified', date('r'), true);
        return $this->response;
    }
}
