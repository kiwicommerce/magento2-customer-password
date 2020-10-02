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

use KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface;
use KiwiCommerce\CustomerPassword\Api\Data\PasswordLogSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

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
     * @param  PasswordLogInterface $passwordLog
     * @return PasswordLogInterface
     * @throws LocalizedException
     */
    public function save(
        PasswordLogInterface $passwordLog
    );

    /**
     * Retrieve PasswordLog
     *
     * @param  string $passwordlogId
     * @return PasswordLogInterface
     * @throws LocalizedException
     */
    public function getById($passwordlogId);

    /**
     * Retrieve PasswordLog matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PasswordLogSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );
}
