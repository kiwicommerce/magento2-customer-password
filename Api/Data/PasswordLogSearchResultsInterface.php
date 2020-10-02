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
namespace KiwiCommerce\CustomerPassword\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PasswordLogSearchResultsInterface
 *
 * @package KiwiCommerce\CustomerPassword\Api\Data
 */
interface PasswordLogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get PasswordLog list.
     *
     * @return PasswordLogInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     *
     * @param PasswordLogInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
