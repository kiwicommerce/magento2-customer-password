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
namespace KiwiCommerce\CustomerPassword\Model;

use KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface;

/**
 * Class PasswordLog
 * @package KiwiCommerce\CustomerPassword\Model
 */
class PasswordLog extends \Magento\Framework\Model\AbstractModel implements PasswordLogInterface
{

    protected $_eventPrefix = 'kiwicommerce_customer_password_log';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('KiwiCommerce\CustomerPassword\Model\ResourceModel\PasswordLog');
    }

    /**
     * Get passwordlog_id
     * @return string
     */
    public function getPasswordlogId()
    {
        return $this->getData(self::PASSWORDLOG_ID);
    }

    /**
     * Set passwordlog_id
     * @param string $passwordlogId
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setPasswordlogId($passwordlogId)
    {
        return $this->setData(self::PASSWORDLOG_ID, $passwordlogId);
    }

    /**
     * Get customer_id
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get customer_email
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get admin_username
     * @return string
     */
    public function getAdminUsername()
    {
        return $this->getData(self::ADMIN_USERNAME);
    }

    /**
     * Set admin_username
     * @param string $adminUsername
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setAdminUsername($adminUsername)
    {
        return $this->setData(self::ADMIN_USERNAME, $adminUsername);
    }

    /**
     * Get admin_id
     * @return string
     */
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    /**
     * Set admin_id
     * @param string $adminId
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * Get admin_name
     * @return string
     */
    public function getAdminName()
    {
        return $this->getData(self::ADMIN_NAME);
    }

    /**
     * Set admin_name
     * @param string $adminName
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setAdminName($adminName)
    {
        return $this->setData(self::ADMIN_NAME, $adminName);
    }

    /**
     * Get ip
     * @return string
     */
    public function getIp()
    {
        return $this->getData(self::IP);
    }

    /**
     * Set ip
     * @param string $ip
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setIp($ip)
    {
        return $this->setData(self::IP, $ip);
    }

    /**
     * Get logged_at
     * @return string
     */
    public function getLoggedAt()
    {
        return $this->getData(self::LOGGED_AT);
    }

    /**
     * Set logged_at
     * @param string $loggedAt
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     */
    public function setLoggedAt($loggedAt)
    {
        return $this->setData(self::LOGGED_AT, $loggedAt);
    }
}
