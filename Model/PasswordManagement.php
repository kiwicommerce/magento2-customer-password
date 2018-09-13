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

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Class PasswordManagement
 *
 * @package KiwiCommerce\CustomerPassword\Model
 */
class PasswordManagement
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerRegistry
     */
    protected $customerRegistry;

    /**
     * @var Encryptor
     */
    protected $encryptor;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \KiwiCommerce\CustomerPassword\Model\PasswordLogFactory
     */
    public $passwordLogFactory;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * PasswordManagement constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerRegistry            $customerRegistry
     * @param Encryptor                   $encryptor
     * @param \Magento\Framework\Registry $registry
     * @param PasswordLogFactory          $passwordLogFactory
     * @param RemoteAddress               $remoteAddress
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry,
        Encryptor $encryptor,
        \Magento\Framework\Registry $registry,
        \KiwiCommerce\CustomerPassword\Model\PasswordLogFactory $passwordLogFactory,
        RemoteAddress $remoteAddress
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
        $this->encryptor = $encryptor;
        $this->registry = $registry;
        $this->passwordLogFactory = $passwordLogFactory;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * Change customer password by Email
     *
     * @param  $customerEmail
     * @param  $password
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function changePassword($customerEmail, $password)
    {
        $customer = $this->customerRepository->get($customerEmail);
        $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerSecure->setRpToken(null);
        $customerSecure->setRpTokenCreatedAt(null);
        $passwordHash = $this->encryptor->getHash($password, true);
        $customerSecure->setPasswordHash($passwordHash);
        $this->customerRepository->save($customer);
        $this->addPasswordChangeLog($customer);
    }

    /**
     * Change customer password by id
     *
     * @param  $customerId
     * @param  $password
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function changePasswordById($customerId, $password)
    {
        $customer = $this->customerRepository->getById($customerId);
        $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerSecure->setRpToken(null);
        $customerSecure->setRpTokenCreatedAt(null);
        $passwordHash = $this->encryptor->getHash($password, true);
        $customerSecure->setPasswordHash($passwordHash);
        $this->customerRepository->save($customer);
        $this->addPasswordChangeLog($customer);
    }

    /**
     * Save customer password change log
     *
     * @param $customer
     */
    public function addPasswordChangeLog($customer)
    {
        $logFactory = $this->passwordLogFactory->create();
        $logFactory->setCustomerId($customer->getId());
        $logFactory->setCustomerEmail($customer->getEmail());

        $adminUser = $this->getAdminUser();
        if ($adminUser) {
            $logFactory->setAdminUsername($adminUser->getUsername());
            $logFactory->setAdminId($adminUser->getId());
            $logFactory->setAdminName($adminUser->getFirstname() . ' ' . $adminUser->getLastname());
            $logFactory->setIp($this->remoteAddress->getRemoteAddress());
        }
        $logFactory->save();
    }

    /**
     * Retrieving current admin detail from registry
     *
     * @return string
     */
    public function getAdminUser()
    {
        return $this->registry->registry('current_admin_user');
    }
}
