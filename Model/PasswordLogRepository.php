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
namespace KiwiCommerce\CustomerPassword\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
use KiwiCommerce\CustomerPassword\Model\ResourceModel\PasswordLog as ResourcePasswordLog;
use Magento\Framework\Exception\CouldNotSaveException;
use KiwiCommerce\CustomerPassword\Api\Data\PasswordLogSearchResultsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use KiwiCommerce\CustomerPassword\Model\ResourceModel\PasswordLog\CollectionFactory as PasswordLogCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use KiwiCommerce\CustomerPassword\Api\PasswordLogRepositoryInterface;
use KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterfaceFactory;

/**
 * Class PasswordLogRepository
 *
 * @package KiwiCommerce\CustomerPassword\Model
 */
class PasswordLogRepository implements PasswordLogRepositoryInterface
{
    /**
     * @var PasswordLogInterfaceFactory
     */
    protected $dataPasswordLogFactory;

    /**
     * @var ResourcePasswordLog
     */
    protected $resource;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PasswordLogFactory
     */
    protected $passwordLogFactory;

    /**
     * @var PasswordLogCollectionFactory
     */
    protected $passwordLogCollectionFactory;

    /**
     * @var PasswordLogSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * PasswordLogRepository constructor.
     *
     * @param ResourcePasswordLog                      $resource
     * @param PasswordLogFactory                       $passwordLogFactory
     * @param PasswordLogInterfaceFactory              $dataPasswordLogFactory
     * @param PasswordLogCollectionFactory             $passwordLogCollectionFactory
     * @param PasswordLogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                         $dataObjectHelper
     * @param DataObjectProcessor                      $dataObjectProcessor
     * @param StoreManagerInterface                    $storeManager
     */
    public function __construct(
        ResourcePasswordLog $resource,
        PasswordLogFactory $passwordLogFactory,
        PasswordLogInterfaceFactory $dataPasswordLogFactory,
        PasswordLogCollectionFactory $passwordLogCollectionFactory,
        PasswordLogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->passwordLogFactory = $passwordLogFactory;
        $this->passwordLogCollectionFactory = $passwordLogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPasswordLogFactory = $dataPasswordLogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \KiwiCommerce\CustomerPassword\Api\Data\PasswordLogInterface $passwordLog
    ) {
        try {
            $this->resource->save($passwordLog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the password log: %1',
                    $exception->getMessage()
                )
            );
        }
        return $passwordLog;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($passwordLogId)
    {
        $passwordLog = $this->passwordLogFactory->create();
        $this->resource->load($passwordLog, $passwordLogId);
        if (!$passwordLog->getId()) {
            throw new NoSuchEntityException(__('Password log with id "%1" does not exist.', $passwordLogId));
        }
        return $passwordLog;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->passwordLogCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /* @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }
}
