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

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Authorization\PolicyInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const RESOURCE_ID = "KiwiCommerce_CustomerPassword::customer_password";
    const CONFIG_ENABLE_PATH = 'customer_password/general/enable';
    const CONFIG_ENABLE_CLI = 'customer_password/general/enable_cli';

    /**
     * @var PolicyInterface
     */
    public $policyInterface;
    /**
     * @var Session
     */
    private $authSession;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param PolicyInterface $policyInterface
     * @param Session $authSession
     */
    public function __construct(
        Context $context,
        PolicyInterface $policyInterface,
        Session $authSession
    ) {
        $this->policyInterface = $policyInterface;
        parent::__construct($context);
        $this->authSession = $authSession;
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
        $storeScope = ScopeInterface::SCOPE_STORE;
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
        $storeScope = ScopeInterface::SCOPE_STORE;
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
            /* @var $currentUser Session */
            $user = $this->authSession->getUser();
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
     * @throws LocalizedException
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
     * @throws LocalizedException
     */
    public function isEnableCliCommand()
    {
        if ($this->isModuleEnabled() && $this->isCliEnabled()) {
            return true;
        }
        return false;
    }
}
