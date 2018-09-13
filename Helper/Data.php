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
 * @copyright Copyright (C) 2018 KiwiCommerce Ltd (https://kiwicommerce.co.uk/)
 * @license   https://kiwicommerce.co.uk/magento2-extension-license/
 */

namespace KiwiCommerce\CustomerPassword\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const RESOURCE_ID = "KiwiCommerce_CustomerPassword::customer_password";
    const CONFIG_ENABLE_PATH = 'customer_password/general/enable';
    const CONFIG_ENABLE_CLI = 'customer_password/general/enable_cli';

    /**
     * @var \Magento\Framework\Authorization\PolicyInterface
     */
    public $policyInterface;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context            $context
     * @param \Magento\Framework\Authorization\PolicyInterface $policyInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Authorization\PolicyInterface $policyInterface
    ) {
        $this->policyInterface = $policyInterface;
        parent::__construct($context);
    }

    /**
     * Whether a module is enabled in the configuration or not
     *
     * @param  string $moduleName Fully-qualified module name
     * @return boolean
     */
    public function isModuleEnabled()
    {
        if ($this->_moduleManager->isEnabled('KiwiCommerce_CustomerPassword')) {
            if ($this->isEnabled()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Whether a module output is permitted by the configuration or not
     *
     * @param  string $moduleName Fully-qualified module name
     * @return boolean
     */
    public function isOutputEnabled()
    {
        if ($this->_moduleManager->isOutputEnabled('KiwiCommerce_CustomerPassword')) {
            if ($this->isEnabled()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Whether a module is enabled by the configuration or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        if ($this->scopeConfig->getValue(self::CONFIG_ENABLE_PATH, $storeScope)) {
            return true;
        }
        return false;
    }

    /**
     * Whether a CLI command is enabled by the configuration or not
     *
     * @return bool
     */
    public function isCliEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        if ($this->scopeConfig->getValue(self::CONFIG_ENABLE_CLI, $storeScope)) {
            return true;
        }
        return false;
    }

    /**
     * @param null $user
     * @return bool
     */
    public function isAllowed($user = null)
    {
        if (!$user) {
            /* @var $currentUser \Magento\Backend\Model\Auth\Session */
            $user = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Backend\Model\Auth\Session')->getUser();
        }
        $role = $user->getRole();
        $permission = $this->policyInterface->isAllowed($role->getId(), self::RESOURCE_ID);
        if ($permission) {
            return true;
        }
        return false;
    }

    /**
     * Check password section is enable
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function isEnablePasswordSection()
    {
        if ($this->isModuleEnabled() && $this->isOutputEnabled() && $this->isAllowed()) {
            return true;
        }
        return false;
    }

    /**
     * Check password section is enable
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function isEnableCliCommand()
    {
        if ($this->isModuleEnabled() && $this->isCliEnabled()) {
            return true;
        }
        return false;
    }
}
