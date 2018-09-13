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

namespace KiwiCommerce\CustomerPassword\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KiwiCommerce\CustomerPassword\Model\PasswordManagement;
use Magento\Framework\App\State;
use KiwiCommerce\CustomerPassword\Helper\Data;

/**
 * Class ChangeCustomerPassword
 *
 * @package KiwiCommerce\CustomerPassword\Console\Command
 */
class ChangeCustomerPassword extends Command
{
    /* Options name */
    const ARG_CUSTOMER_ID = 'customer-id';
    const ARG_CUSTOMER_EMAIL = 'customer-email';
    const ARG_CUSTOMER_PASSWORD = 'password';

    /**
     * @var PasswordManagement
     */
    protected $accountManagement;

    /**
     * @var State | \Magento\Framework\App\State
     */
    protected $state;

    /**
     * CustomerPassword data
     *
     * @var Data
     */
    protected $helper;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("customer:password:change");
        $this->setDescription("Change customer password.");
        $this->addOption(
            self::ARG_CUSTOMER_PASSWORD,
            'p',
            InputOption::VALUE_REQUIRED,
            '(Required) Customer password'
        );
        $this->addOption(
            self::ARG_CUSTOMER_ID,
            'i',
            InputOption::VALUE_OPTIONAL,
            'Customer ID'
        );
        $this->addOption(
            self::ARG_CUSTOMER_EMAIL,
            'e',
            InputOption::VALUE_OPTIONAL,
            'Customer Email'
        );
        parent::configure();
    }

    /**
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function isEnabled()
    {
        return $this->helper->isEnableCliCommand();
    }

    /**
     * ChangeCustomerPassword constructor.
     *
     * @param  PasswordManagement $accountManagement
     * @param  State              $state
     * @param  Data               $helper
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        PasswordManagement $accountManagement,
        State $state,
        Data $helper
    ) {
        $this->accountManagement = $accountManagement;
        $this->state = $state;
        $this->helper = $helper;
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        parent::__construct();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        //$this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $customerId = $input->getOption(self::ARG_CUSTOMER_ID);
        $customerEmail = $input->getOption(self::ARG_CUSTOMER_EMAIL);
        $password = $input->getOption(self::ARG_CUSTOMER_PASSWORD);

        if ($password === null) {
            $output->writeln("<error>password --password <new password> is required field.");
        } elseif ($customerId === null && $customerEmail === null) {
            $output->writeln("<error>Enter either one of the field --customer-id <customer ID> or --customer-email <customer email></error>");
        } elseif ($customerId && $customerEmail) {
            $output->writeln("<error>Enter either one of the field --customer-id <customer ID> or --customer-email <customer email></error>");
        } else {
            try {
                if ($customerEmail) {
                    $this->accountManagement->changePassword($customerEmail, $password);
                } elseif ($customerId) {
                    $this->accountManagement->changePasswordById($customerId, $password);
                }
                $output->writeln('Customer password has been changed.');
            } catch (\Exception $e) {
                $output->write($e->getMessage());
            }
        }
    }
}
