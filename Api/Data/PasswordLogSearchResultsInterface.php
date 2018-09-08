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
namespace KiwiCommerce\CustomerPassword\Api\Data;

/**
 * Interface PasswordLogSearchResultsInterface
 * @package KiwiCommerce\CustomerPassword\Api\Data
 */
interface PasswordLogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get PasswordLog list.
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     * @param \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
