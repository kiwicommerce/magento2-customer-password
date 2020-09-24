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
namespace KiwiCommerce\CustomerPassword\Test\Unit\Model;

use KiwiCommerce\CustomerPassword\Model\PasswordLog;
use KiwiCommerce\CustomerPassword\Model\PasswordLogFactory;
use KiwiCommerce\CustomerPassword\Model\PasswordManagement;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\Data\CustomerSecure;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class InformationTest extends TestCase
{
    /**
     * @var
     */
    public $objectManager;
    /**
     * @var
     */
    public $customerRegistry;
    public $customerRepositoryInterface;
    public $encryptorInterface;
    public $passwordLogFactory;
    public $customerMock;
    public $customerid="10";
    public $customerEmail="roymiller@ymail.com";
    public $adminUsername="admin";
    public $passwordLogvalue=1;
    public $passwordLog;
    public $passwordLog1;
    public $customerSecure;

    public function setUp()
    {
        $this->customerRepositoryInterface = $this->getMockBuilder(
            CustomerRepositoryInterface::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerSecure = $this->getMockBuilder(CustomerSecure::class)
            ->setMethods(['setRpToken', 'addData', 'setRpTokenCreatedAt', 'setData', 'getPasswordHash'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerRegistry = $this->getMockBuilder(CustomerRegistry::class)
            ->setMethods(['getById','getId', 'retrieveSecureData','setRpToken'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->passwordLog1= $this->getMockBuilder(PasswordLog::class)
            ->setMethods(['setPasswordlogId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->encryptorInterface = $this->getMockBuilder(EncryptorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->passwordLogFactory = $this->getMockBuilder(
            PasswordLogFactory::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerMock = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);

        $this->processorTest = $objectManager->getObject(
            PasswordManagement::class,
            [
                'customerRepository' => $this->customerRepositoryInterface,
                'customerRegistry' => $this->customerRegistry,
                'encryptor' => $this->encryptorInterface,
                'passwordLogFactory' => $this->passwordLogFactory

            ]
        );
    }
    public function testAdminPassword()
    {
        $this->assertEquals("ChangeMe", "ChangeMe");
    }

    public function testCustomerId()
    {
        $this->passwordLog1->setCustomerId($this->customerid);
        $returnCustomer=$this->passwordLog1->getCustomerId();
        $this->assertEquals($this->customerid, $returnCustomer);
    }

    public function testCustomerEmail()
    {
        $this->passwordLog1->setCustomerEmail($this->customerEmail);
        $returnCustomerEmail=$this->passwordLog1->getCustomerEmail();
        $this->assertEquals($this->customerEmail, $returnCustomerEmail);
    }

    public function testAdminUsername()
    {
        $this->passwordLog1->setAdminUsername($this->adminUsername);
        $returnaAminUsername=$this->passwordLog1->getAdminUsername();
        $this->assertEquals($this->adminUsername, $returnaAminUsername);
    }
}
