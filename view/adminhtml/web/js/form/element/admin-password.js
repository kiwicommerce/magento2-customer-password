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
define(
    [
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract'
    ],
    function (registry, Abstract) {
        'use strict';

        return Abstract.extend(
            {
                defaults: {
                    focused: false,
                },
                initialize: function () {
                    this._super();
                    var admin_password = registry.get(this.parentName + '.' + 'admin_password');
                    admin_password.hide();
                    this.focused.subscribe(
                        function (value) {
                            if (value) {
                                admin_password.show();
                            } else if (!this.value().length) {
                                admin_password.hide();
                            }
                        }.bind(this)
                    );
                    registry.get(
                        'customer_form.areas.customer.customer.email',
                        function (element) {
                            if (element.value() === '') {
                                var password_section = registry.get(this.parentName);
                                password_section.visible(false);
                            }
                        }.bind(this)
                    );
                }
            }
        );
    }
);