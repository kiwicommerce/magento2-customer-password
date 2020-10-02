<?php
/**
 * KiwiCommerce
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us https://kiwicommerce.co.uk/contacts.
 *
 * @category  KiwiCommerce
 * @package   KiwiCommerce_CustomerPassword
 * @copyright Copyright (C) 2018 Kiwi Commerce Ltd (https://kiwicommerce.co.uk/)
 * @license   https://kiwicommerce.co.uk/magento2-extension-license/
 */

namespace KiwiCommerce\CustomerPassword\Block\Adminhtml\System\Config\Fieldset;

use \Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\AbstractElement;
use \Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Module\ModuleList;

/**
 * Class Hint
 *
 * @package KiwiCommerce\CustomerPassword\Block\Adminhtml\System\Config\Fieldset
 */
class Hint extends Template implements RendererInterface
{
    /**
     * @var ModuleList
     */
    private $moduleList;

    /**
     * Class constructor.
     *
     * @param Template\Context                     $context
     * @param ModuleList $moduleList
     * @param array                                $data
     */
    public function __construct(
        Template\Context $context,
        ModuleList $moduleList,
        array $data = []
    ) {
        $this->_template = 'KiwiCommerce_CustomerPassword::system/config/fieldset/hint.phtml';
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $_element = $element;
        return $this->toHtml();
    }

    /**
     * @return mixed
     */
    public function getModuleVersion()
    {
        return $this->moduleList->getOne('KiwiCommerce_CustomerPassword')['setup_version'];
    }
}
