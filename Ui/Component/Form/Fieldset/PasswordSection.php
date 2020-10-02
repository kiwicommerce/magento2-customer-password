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

//@codingStandardsIgnoreFile

namespace KiwiCommerce\CustomerPassword\Ui\Component\Form\Fieldset;

use KiwiCommerce\CustomerPassword\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Form\Fieldset;

class PasswordSection extends Fieldset
{
    /**
     * CustomerPassword data
     *
     * @var Data
     */
    protected $helper;

    /**
     * PasswordSection constructor.
     * @param ContextInterface $context
     * @param array $components
     * @param array $data
     * @param Data $helper
     */
    public function __construct(
        ContextInterface $context,
        $components = [],
        array $data = [],
        Data $helper
    ) {
        parent::__construct($context, $components, $data);
        $this->helper = $helper;
    }

    /**
     * @throws LocalizedException
     */
    public function prepare()
    {
        parent::prepare();
        if (!$this->helper->isEnablePasswordSection()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }
}
