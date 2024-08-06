# KiwiCommerce_CustomerPassword Module

## Overview
The `KiwiCommerce_CustomerPassword` module allows administrators to change customer passwords directly from the admin panel in Magento 2. This module enhances the admin's ability to manage customer accounts efficiently.

## Features
- Admins can change customer passwords directly from the customer edit page.
- Sends a notification email to customers when their password is changed by an admin.
- Secure password handling to ensure customer data privacy.

## Installation

### Composer Installation
1. Navigate to your Magento 2 root directory.
2. Run the following command:
    ```bash
    composer require kiwi-commerce/module-customer-password
    ```
3. Enable the module:
    ```bash
    bin/magento module:enable KiwiCommerce_CustomerPassword
    ```
4. After install the extension, run the following command <br/>
  `php bin/magento setup:upgrade`<br />
  `php bin/magento setup:di:compile`<br />
  `php bin/magento setup:static-content:deploy`<br />
  `php bin/magento cache:flush`
    ```

### Manual Installation
1. Download the module package and extract it.
2. Copy the extracted files to `app/code/KiwiCommerce/CustomerPassword`.
3. Follow steps 3-6 from the Composer Installation instructions above.

## Usage
1. Log in to the Magento admin panel.
2. Navigate to `Customers` > `All Customers`.
3. Select a customer you wish to change the password for and click `Edit`.
4. In the customer edit page, you will find a section to change the customer password.
5. Enter the new password and confirm it.
6. Save the changes.

## Contribution
Well unfortunately there is no formal way to contribute, we would encourage you to feel free and contribute by:

- Creating bug reports, issues or feature requests on <a target="_blank" href="https://github.com/kiwicommerce/magento2-inventory-log/issues">Github</a>
- Submitting pull requests for improvements.

We love answering questions or doubts simply ask us in issue section. We're looking forward to hearing from you!

- Follow us <a href="https://twitter.com/KiwiCommerce">@KiwiCommerce</a>
- <a href="mailto:support@kiwicommerce.co.uk">Email Us</a>
- Have a look at our <a href="https://kiwicommerce.co.uk/docs/inventory-log/">documentation</a> 





