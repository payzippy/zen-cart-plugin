<?php

//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: pm2checkout.php,v 1.1 2003/11/25 17:09:07 wilt Exp $
//

define('MODULE_PAYMENT_PAYZIPPY_TEXT_TITLE', 'PayZippy Payment Gateway');
define('MODULE_PAYMENT_PAYZIPPY_TEXT_DESCRIPTION', '<fieldset style="background: #f7f6f0; margin-bottom: 1.5em; color: #000;">
	<legend style="font-size: 1.2em; font-weight: bold">About PayZippy Payment Gateway</legend>
	<p style="margin: 0.4em 0 0.6em 0;">PayZippy is a smart payment product built by Flipkart, which makes it extremely safe and easy to pay online</p>
	<p><a href="https://www.payzippy.com/merchants" style="text-decoration: underline; font-weight: bold;">Visit the PayZippy Merchant page to sign up for an account!</a></p>
</fieldset>');
define('MODULE_PAYMENT_PAYZIPPY_TEXT_TYPE', '');
define('MODULE_PAYMENT_PAYZIPPY_TEXT_ERROR_MESSAGE', 'There has been an error processing your Payment. Please try again.');
define('MODULE_PAYMENT_PAYZIPPY_TEXT_ERROR', 'Credit Card Error!');
define('MODULE_PAYMENT_PAYZIPPY_CURRENCY_CONVERSITION', 'Currency Conversion');
define('MODULE_PAYMENT_PAYZIPPY_ALERT_ERROR_MESSAGE', 'Security Error. Illegal access detected, please try again.');
?>