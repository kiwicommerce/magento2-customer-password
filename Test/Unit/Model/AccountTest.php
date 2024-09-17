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

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\ValidationResultsInterfaceFactory;
use Magento\Customer\Helper\View;
use Magento\Customer\Model\AccountManagement;
use Magento\Customer\Model\AccountConfirmation;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Customer\Model\Config\Share;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\Data\CustomerSecure;
use Magento\Customer\Model\EmailNotificationInterface;
use Magento\Customer\Model\Metadata\Validator;
use Magento\Customer\Model\ResourceModel\Visitor\CollectionFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Math\Random;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Session\SaveHandlerInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AccountTest extends TestCase
{
    /**
     * @var AccountManagement
     */
    protected $accountManagement;

    /**
     * @var ObjectManagerHelper
     */
    protected $objectManagerHelper;

    /**
     * @var CustomerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerFactory;

    /**
     * @var ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $manager;

    /**
     * @var StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManager;

    /**
     * @var Random|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $random;

    /**
     * @var Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $validator;

    /**
     * @var ValidationResultsInterfaceFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $validationResultsInterfaceFactory;

    /**
     * @var AddressRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressRepository;

    /**
     * @var CustomerMetadataInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerMetadata;

    /**
     * @var CustomerRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerRegistry;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    /**
     * @var EncryptorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $encryptor;

    /**
     * @var Share|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $share;

    /**
     * @var StringUtils|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $string;

    /**
     * @var CustomerRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerRepository;

    /**
     * @var ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfig;

    /**
     * @var TransportBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $transportBuilder;

    /**
     * @var DataObjectProcessor|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataObjectProcessor;

    /**
     * @var Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registry;

    /**
     * @var View|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerViewHelper;

    /**
     * @var DateTime|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dateTime;

    /**
     * @var Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customer;

    /**
     * @var DataObjectFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectFactory;

    /**
     * @var ExtensibleDataObjectConverter|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Store
     */
    protected $store;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|CustomerSecure
     */
    protected $customerSecure;

    /**
     * @var AuthenticationInterface |\PHPUnit_Framework_MockObject_MockObject
     */
    protected $authenticationMock;

    /**
     * @var EmailNotificationInterface |\PHPUnit_Framework_MockObject_MockObject
     */
    protected $emailNotificationMock;

    /**
     * @var DateTimeFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dateTimeFactory;

    /**
     * @var AccountConfirmation|\PHPUnit_Framework_MockObject_MockObject
     */
    private $accountConfirmation;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var  \PHPUnit_Framework_MockObject_MockObject|CollectionFactory
     */
    private $visitorCollectionFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SaveHandlerInterface
     */
    private $saveHandler;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function setUp()
    {
        $this->customerFactory = $this->createPartialMock(CustomerFactory::class, ['create']);
        $this->manager = $this->createMock(ManagerInterface::class);
        $this->store = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->storeManager = $this->createMock(StoreManagerInterface::class);
        $this->random = $this->createMock(Random::class);
        $this->validator = $this->createMock(Validator::class);
        $this->validationResultsInterfaceFactory = $this->createMock(
            ValidationResultsInterfaceFactory::class
        );
        $this->addressRepository = $this->createMock(AddressRepositoryInterface::class);
        $this->customerMetadata = $this->createMock(CustomerMetadataInterface::class);
        $this->customerRegistry = $this->createMock(CustomerRegistry::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->encryptor = $this->getMockBuilder(EncryptorInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->share = $this->createMock(Share::class);
        $this->string = $this->createMock(StringUtils::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->transportBuilder = $this->createMock(TransportBuilder::class);
        $this->dataObjectProcessor = $this->createMock(DataObjectProcessor::class);
        $this->registry = $this->createMock(Registry::class);
        $this->customerViewHelper = $this->createMock(View::class);
        $this->dateTime = $this->createMock(DateTime::class);
        $this->customer = $this->createMock(Customer::class);
        $this->objectFactory = $this->createMock(DataObjectFactory::class);
        $this->extensibleDataObjectConverter = $this->createMock(
            ExtensibleDataObjectConverter::class
        );
        $this->authenticationMock = $this->getMockBuilder(AuthenticationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->emailNotificationMock = $this->getMockBuilder(EmailNotificationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerSecure = $this->getMockBuilder(CustomerSecure::class)
            ->setMethods(['setRpToken', 'addData', 'setRpTokenCreatedAt', 'setData', 'getPasswordHash'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->visitorCollectionFactory = $this->getMockBuilder(
            CollectionFactory::class
        )
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->sessionManager = $this->getMockBuilder(SessionManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->saveHandler = $this->getMockBuilder(SaveHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dateTimeFactory = $this->createMock(DateTimeFactory::class);
        $this->accountConfirmation = $this->createMock(AccountConfirmation::class);

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->accountManagement = $this->objectManagerHelper->getObject(
            \Magento\Customer\Model\AccountManagement::class,
            [
                'customerFactory' => $this->customerFactory,
                'eventManager' => $this->manager,
                'storeManager' => $this->storeManager,
                'mathRandom' => $this->random,
                'validator' => $this->validator,
                'validationResultsDataFactory' => $this->validationResultsInterfaceFactory,
                'addressRepository' => $this->addressRepository,
                'customerMetadataService' => $this->customerMetadata,
                'customerRegistry' => $this->customerRegistry,
                'logger' => $this->logger,
                'encryptor' => $this->encryptor,
                'configShare' => $this->share,
                'stringHelper' => $this->string,
                'customerRepository' => $this->customerRepository,
                'scopeConfig' => $this->scopeConfig,
                'transportBuilder' => $this->transportBuilder,
                'dataProcessor' => $this->dataObjectProcessor,
                'registry' => $this->registry,
                'customerViewHelper' => $this->customerViewHelper,
                'dateTime' => $this->dateTime,
                'customerModel' => $this->customer,
                'objectFactory' => $this->objectFactory,
                'extensibleDataObjectConverter' => $this->extensibleDataObjectConverter,
                'dateTimeFactory' => $this->dateTimeFactory,
                'accountConfirmation' => $this->accountConfirmation,
                'sessionManager' => $this->sessionManager,
                'saveHandler' => $this->saveHandler,
                'visitorCollectionFactory' => $this->visitorCollectionFactory,
            ]
        );
        $reflection = new \ReflectionClass(get_class($this->accountManagement));
        $reflectionProperty = $reflection->getProperty('authentication');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->accountManagement, $this->authenticationMock);
        $reflectionProperty = $reflection->getProperty('emailNotification');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->accountManagement, $this->emailNotificationMock);
    }

    /**
     * reInit $this->accountManagement object
     */
    private function reInitModel()
    {
        $this->customerSecure = $this->getMockBuilder(CustomerSecure::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getRpToken',
                    'getRpTokenCreatedAt',
                    'getPasswordHash',
                    'setPasswordHash',
                    'setRpToken',
                    'setRpTokenCreatedAt',
                ]
            )
            ->getMock();

        $this->customerSecure
            ->expects($this->any())
            ->method('getRpToken')
            ->willReturn('newStringToken');

        $pastDateTime = '2016-10-25 00:00:00';

        $this->customerSecure
            ->expects($this->any())
            ->method('getRpTokenCreatedAt')
            ->willReturn($pastDateTime);

        $this->customer = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResetPasswordLinkExpirationPeriod'])
            ->getMock();

        $this->prepareDateTimeFactory();

        $this->sessionManager = $this->getMockBuilder(SessionManagerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['destroy', 'start', 'writeClose'])
            ->getMockForAbstractClass();
        $this->visitorCollectionFactory = $this->getMockBuilder(
            CollectionFactory::class
        )
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->saveHandler = $this->getMockBuilder(SaveHandlerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['destroy'])
            ->getMockForAbstractClass();

        $dateTime = '2017-10-25 18:57:08';
        $timestamp = '1508983028';
        $dateTimeMock = $this->createMock(\DateTime::class);
        $dateTimeMock->expects($this->any())
            ->method('format')
            ->with(DateTime::DATETIME_PHP_FORMAT)
            ->willReturn($dateTime);

        $dateTimeMock
            ->expects($this->any())
            ->method('getTimestamp')
            ->willReturn($timestamp);

        $dateTimeMock
            ->expects($this->any())
            ->method('setTimestamp')
            ->willReturnSelf();

        $dateTimeFactory = $this->createMock(DateTimeFactory::class);
        $dateTimeFactory->expects($this->any())->method('create')->willReturn($dateTimeMock);

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->accountManagement = $this->objectManagerHelper->getObject(
            \Magento\Customer\Model\AccountManagement::class,
            [
                'customerFactory' => $this->customerFactory,
                'customerRegistry' => $this->customerRegistry,
                'customerRepository' => $this->customerRepository,
                'customerModel' => $this->customer,
                'dateTimeFactory' => $dateTimeFactory,
                'stringHelper' => $this->string,
                'scopeConfig' => $this->scopeConfig,
                'sessionManager' => $this->sessionManager,
                'visitorCollectionFactory' => $this->visitorCollectionFactory,
                'saveHandler' => $this->saveHandler,
                'encryptor' => $this->encryptor,
                'dataProcessor' => $this->dataObjectProcessor,
                'storeManager' => $this->storeManager,
                'transportBuilder' => $this->transportBuilder,
            ]
        );
        $reflection = new \ReflectionClass(get_class($this->accountManagement));
        $reflectionProperty = $reflection->getProperty('authentication');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->accountManagement, $this->authenticationMock);
    }

    private function prepareDateTimeFactory()
    {
        $dateTime = '2017-10-25 18:57:08';
        $timestamp = '1508983028';
        $dateTimeMock = $this->createMock(\DateTime::class);
        $dateTimeMock->expects($this->any())
            ->method('format')
            ->with(DateTime::DATETIME_PHP_FORMAT)
            ->willReturn($dateTime);

        $dateTimeMock
            ->expects($this->any())
            ->method('getTimestamp')
            ->willReturn($timestamp);

        $this->dateTimeFactory
            ->expects($this->any())
            ->method('create')
            ->willReturn($dateTimeMock);

        return $dateTime;
    }

    /**
     * @return void
     */
    public function testChangePassword()
    {
        $customerId = 7;
        $email = 'test@example.com';
        $currentPassword = '1234567';
        $newPassword = 'abcdefg';
        $passwordHash = '1a2b3f4c';

        $this->reInitModel();
        $customer = $this->getMockBuilder(\Magento\Customer\Api\Data\CustomerInterface::class)
            ->getMock();
        $customer->expects($this->any())
            ->method('getId')
            ->willReturn($customerId);

        $this->customerRepository
            ->expects($this->once())
            ->method('get')
            ->with($email)
            ->willReturn($customer);

        $this->authenticationMock->expects($this->once())
            ->method('authenticate');

        $this->customerSecure->expects($this->once())
            ->method('setRpToken')
            ->with(null);
        $this->customerSecure->expects($this->once())
            ->method('setRpTokenCreatedAt')
            ->willReturnSelf();
        $this->customerSecure->expects($this->any())
            ->method('getPasswordHash')
            ->willReturn($passwordHash);

        $this->customerRegistry->expects($this->any())
            ->method('retrieveSecureData')
            ->with($customerId)
            ->willReturn($this->customerSecure);

        $this->string->expects($this->any())
            ->method('strlen')
            ->with($newPassword)
            ->willReturn(7);

        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with($customer);

        $this->sessionManager->expects($this->atLeastOnce())->method('start');
        $this->sessionManager->expects($this->atLeastOnce())->method('writeClose');
        $this->sessionManager->expects($this->atLeastOnce())->method('getSessionId');

        $visitor = $this->getMockBuilder(\Magento\Customer\Model\Visitor::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSessionId'])
            ->getMock();
        $visitor->expects($this->at(0))->method('getSessionId')->willReturn('session_id_1');
        $visitor->expects($this->at(1))->method('getSessionId')->willReturn('session_id_2');
        $visitorCollection = $this->getMockBuilder(
            CollectionFactory::class
        )
            ->disableOriginalConstructor()->setMethods(['addFieldToFilter', 'getItems'])->getMock();
        $visitorCollection->expects($this->atLeastOnce())->method('addFieldToFilter')->willReturnSelf();
        $visitorCollection->expects($this->atLeastOnce())->method('getItems')->willReturn([$visitor, $visitor]);
        $this->visitorCollectionFactory->expects($this->atLeastOnce())->method('create')
            ->willReturn($visitorCollection);
        $this->saveHandler->expects($this->at(0))->method('destroy')->with('session_id_1');
        $this->saveHandler->expects($this->at(1))->method('destroy')->with('session_id_2');

        $this->assertTrue($this->accountManagement->changePassword($email, $currentPassword, $newPassword));
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testAuthenticate()
    {
        $username = 'login';
        $password = '1234567';
        $passwordHash = '1a2b3f4c';

        $customerData = $this->getMockBuilder(\Magento\Customer\Api\Data\CustomerInterface::class)
            ->getMock();

        $customerModel = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $customerModel->expects($this->once())
            ->method('updateData')
            ->willReturn($customerModel);

        $this->customerRepository
            ->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn($customerData);

        $this->authenticationMock->expects($this->once())
            ->method('authenticate');

        $customerSecure = $this->getMockBuilder(CustomerSecure::class)
            ->setMethods(['getPasswordHash'])
            ->disableOriginalConstructor()
            ->getMock();
        $customerSecure->expects($this->any())
            ->method('getPasswordHash')
            ->willReturn($passwordHash);

        $this->customerRegistry->expects($this->any())
            ->method('retrieveSecureData')
            ->willReturn($customerSecure);

        $this->customerFactory->expects($this->once())
            ->method('create')
            ->willReturn($customerModel);

        $this->manager->expects($this->exactly(2))
            ->method('dispatch')
            ->withConsecutive(
                [
                    'customer_customer_authenticated',
                    ['model' => $customerModel, 'password' => $password]
                ],
                [
                    'customer_data_object_login', ['customer' => $customerData]
                ]
            );

        $this->assertEquals($customerData, $this->accountManagement->authenticate($username, $password));
    }
}
