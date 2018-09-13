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
namespace KiwiCommerce\CustomerPassword\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface PasswordLogRepositoryInterface
 *
 * @package KiwiCommerce\CustomerPassword\Api
 */
interface PasswordLogRepositoryInterface
{
    /**
     * Save PasswordLog
     *
     * @param  \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface $passwordLog
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface $passwordLog
    );

    /**
     * Retrieve PasswordLog
     *
     * @param  string $passwordlogId
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($passwordlogId);

    /**
     * Retrieve PasswordLog matching the specified criteria.
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );
}
