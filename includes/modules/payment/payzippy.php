<?php

require_once 'payzippy/ChargingRequest.php';

if (!defined('DB_PREFIX')) {
    define('DB_PREFIX', '');
}

define('MODULE_PAYMENT_PAYZIPPY_TABLE', DB_PREFIX . 'payzippy');

class payzippy extends base {

    var $code, $title, $description, $enabled;
    var $charging_request, $charging_array;

    function payzippy() {
        global $order;

        $this->code = 'payzippy';
        $this->title = MODULE_PAYMENT_PAYZIPPY_TEXT_TITLE;
        $this->description = MODULE_PAYMENT_PAYZIPPY_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_PAYZIPPY_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_PAYZIPPY_STATUS == 'True') ? true : false);

        if ((int) MODULE_PAYMENT_PAYZIPPY_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_PAYZIPPY_ORDER_STATUS_ID;
        }
        if (is_object($order))
            $this->update_status();
        $this->form_action_url = MODULE_PAYMENT_PAYZIPPY_URL;
    }

    function update_status() {
        global $order;
        if ($this->enabled == true) {
            if ($order->content_type == 'virtual') {
                $this->enabled = false;
            }
        }
    }

    function javascript_validation() {
        return false;
    }

    function selection() {
/*
        $payment_methods_config = explode(", ", MODULE_PAYMENT_PAYZIPPY_METHODS);

        $netbanking_banks = explode(", ", MODULE_PAYMENT_PAYZIPPY_NET_BANKS);
        $netbanking_options = "";
        foreach ($netbanking_banks as $bank) {
            $netbanking_options .= "<option value='" . $bank . "'>" . Constants::BANK_NAMES($bank) . "</option>";
        }

        $emi_banks_available = array(
            "3" => explode(", ", MODULE_PAYMENT_PAYZIPPY_EMI_3),
            "6" => explode(", ", MODULE_PAYMENT_PAYZIPPY_EMI_6),
            "9" => explode(", ", MODULE_PAYMENT_PAYZIPPY_EMI_9),
            "12" => explode(", ", MODULE_PAYMENT_PAYZIPPY_EMI_12)
        );

        $emi_banks_options = "";
        foreach ($emi_banks_available as $months => $banks) {

            $options = "";
            foreach ($banks as $bank) {
                $options .= "<option value='" . $bank . "'>" . Constants::BANK_NAMES($bank) . "</option>";
            }
            $emi_banks_options[$months] = $options;
        }

        $payment_methods = array();
        foreach ($payment_methods_config as $method) {
            $payment_methods[] = array(
                'id' => $method,
                'text' => Constants::PAYMENT_METHODS($method)
            );
        }

        $emi_months = array(
            array(
                'id' => '3',
                'text' => '3 mths'
            ),
            array(
                'id' => '6',
                'text' => '6 months'
            ),
            array(
                'id' => '9',
                'text' => '9 months'
            ),
            array(
                'id' => '12',
                'text' => '12 months'
            ),
        );
*/
//        $on_focus_handler = ' onfocus="javascript:selectPayZippy();"';

        $selection = array(
            'id' => $this->code,
            'module' => $this->title
            //'icon' => 'asd'
        );
/*
        $js = '<script type="text/javascript">' .
                'function selectPayZippy(){' . "\n" .
                "	if (document.getElementById('pmt-" . $this->code . "')) {\n" .
                "		document.getElementById('pmt-" . $this->code . "').checked = 'checked';\n" .
                '	}' . "\n" .
                '}' . "\n" .
                'function hideElement(elem){' . "\n" .
                'elem.style.display = "none"' . "\n" .
                '}' . "\n" .
                'function showElement(elem){' . "\n" .
                'elem.style.display = "block"' . "\n" .
                '}' . "\n" .
                'var updateEMI = function(emi_months) {' . "\n" .
                'var options = "";' . "\n" .
                'if (emi_months == "3") {' . "\n" .
                'options = "' . $emi_banks_options["3"] . '";' . "\n" .
                '} else if (emi_months == "6") {' . "\n" .
                'options = "' . $emi_banks_options["6"] . '";' . "\n" .
                '} else if (emi_months == "9") {' . "\n" .
                'options = "' . $emi_banks_options["9"] . '";' . "\n" .
                '} else if (emi_months == "12") {' . "\n" .
                'options = "' . $emi_banks_options["12"] . '";' . "\n" .
                '}' . "\n" .
                'var select_bank = document.getElementsByName("payzippy_bank_name");' . "\n" .
                'select_bank[0].innerHTML = options;' . "\n" .
                '};' . "\n" .
                'function update_payment_method(target){' . "\n" .
                'var payment_method = target.value;' . "\n" .
                'var select_bank = document.getElementsByName("payzippy_bank_name");' . "\n" .
                'if (payment_method == "NET"){' . "\n" .
                'select_bank[0].innerHTML="' . $netbanking_options . '";' . "\n" .
                'hideElement(document.getElementById("pz_emi_months_div"));' . "\n" .
                'showElement(document.getElementById("pz_bank_names_div"));' . "\n" .
                '}' . "\n" .
                'else if (payment_method == "EMI"){' . "\n" .
                'showElement(document.getElementById("pz_emi_months_div"));' . "\n" .
                'showElement(document.getElementById("pz_bank_names_div"));' . "\n" .
                'var emi_months = document.getElementsByName("payzippy_emi_months");' . "\n" .
                'update_emi_banks(emi_months[0])' . "\n" .
                '}' . "\n" .
                'else {' . "\n" .
                'hideElement(document.getElementById("pz_emi_months_div"));' . "\n" .
                'hideElement(document.getElementById("pz_bank_names_div"));' . "\n" .
                '}' . "\n" .
                '}' . "\n" .
                'function update_emi_banks(target){' . "\n" .
                'updateEMI(target.value);' . "\n" .
                '}' . "\n" .
                '</script>';
        $js_onload = '<script type="text/javascript">' . "\n" .
                'update_payment_method(document.getElementsByName("payzippy_payment_method")[0]);' . "\n" .
                '</script>';

        $selection['fields'][] = array(
            'title' => "Payment Method",
            'field' => $js . zen_draw_pull_down_menu("payzippy_payment_method", $payment_methods, null, "onchange = 'update_payment_method(this)'" . $on_focus_handler) . "<div id='pz_emi_months_div'>"
        );
        $selection['fields'][] = array(
            'title' => "EMI Months",
            'field' => zen_draw_pull_down_menu("payzippy_emi_months", $emi_months, null, "onchange = 'update_emi_banks(this)'" . $on_focus_handler) . "</div><div id='pz_bank_names_div'>"
        );

        $selection['fields'][] = array(
            'title' => "Bank Name",
            'field' => zen_draw_pull_down_menu("payzippy_bank_name", array(), null, $on_focus_handler) . "</div>" . $js_onload
        );
*/
        return $selection;
    }

    function pre_confirmation_check() {
        global $order, $messageStack;
        $payment_method = $_POST["payzippy_payment_method"];

        $this->charging_request = new ChargingRequest();
        $this->charging_request->set_merchant_id(MODULE_PAYMENT_PAYZIPPY_LOGIN)
                ->set_merchant_key_id(MODULE_PAYMENT_PAYZIPPY_KEY_ID)
                ->set_currency("INR")
                ->set_transaction_amount($order->info['total'] * 100)
                ->set_merchant_transaction_id($_SESSION['customer_id'] . '-' . date('Ymdhis'))
                ->set_callback_url(MODULE_PAYMENT_PAYZIPPY_CALLBACK_URL)
                ->set_hash_method('SHA256')
                ->set_billing_address($order->customer['street_address'])
                ->set_billing_city($order->customer['city'])
                ->set_billing_name($order->customer['firstname'])
                ->set_billing_zip($order->customer['postcode'])
                ->set_billing_state($order->customer['state'])
                ->set_buyer_email_address($order->customer['email_address'])
                ->set_buyer_phone_no($order->customer['telephone'])
                ->set_transaction_type('SALE')
                ->set_zen_security_key($_SESSION['securityToken'])
                ->set_secret_key(MODULE_PAYMENT_PAYZIPPY_KEY)
                ->set_payment_method('PAYZIPPY')
                ->set_ui_mode(Constants::UI_MODE_REDIRECT)
                ->set_source('Zen-cart');
/*
        if ($payment_method == Constants::PAYMENT_MODE_NET) {
            $this->charging_request->set_bank_name($_POST["payzippy_bank_name"]);
        } else if ($payment_method == Constants::PAYMENT_MODE_EMI) {
            $this->charging_request->set_bank_name($_POST["payzippy_bank_name"])
                    ->set_emi_months($_POST["payzippy_emi_months"]);
        }
*/
        $errors = array();
        $this->charging_array = $this->charging_request->charge();

        if ($this->charging_array["status"] == "ERROR") {
            $errors[] = $this->charging_array["error_message"];
        }
        // var_dump($this->charging_array );
        if (sizeof($errors) > 0) {
            foreach ($errors as $error_message) {
                $messageStack->add_session('checkout_payment', $error_message, 'error');
            }
            zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }

        return true;
    }

    function confirmation() {
        $confirmation = array(
            'fields' => array(
                array(
                    'title' => 'Payment Method:&nbsp;',
                    'field' => $_POST["payzippy_payment_method"]
                )
            )
        );
        return $confirmation;
    }

    function process_button() {
        foreach ($this->charging_array['params'] as $key => $value) {
            $process_button_string .= zen_draw_hidden_field($key, $value);
        }

        return $process_button_string;
    }

    function before_process() {
        global $order, $messageStack;
        $paymentstatus = $_GET['paymentstatus'];
        $in_payzippytransid = $_GET['payzippytransid'];
        if ($paymentstatus == 'OK') {
            $order->info['comments'] .= "\n Payzippy Transaction ID: " . zen_db_prepare_input($in_payzippytransid);
        } else {
            $messageStack->add_session('checkout_payment', 'Error Occured While Processing Your Order', 'error');
            zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }
    }

    function after_order_create($zen_order_id) {
        global $db;

        $in_payzippytransid = zen_db_prepare_input($_GET['payzippytransid']);

        $response_array = array(
            'zen_order_id' => $zen_order_id,
            'transaction_id' => $in_payzippytransid
        );

        zen_db_perform(MODULE_PAYMENT_PAYZIPPY_TABLE, $response_array, 'update', "transaction_id = '" . $in_payzippytransid . "'");
        zen_redirect(zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$zen_order_id, 'SSL', true, false));
    }

    function admin_notification($zen_order_id) {
        global $db;

        $output = '';
        $transaction_info_sql = "SELECT * FROM " . MODULE_PAYMENT_PAYZIPPY_TABLE . " WHERE zen_order_id = '" . $zen_order_id . "';";
        $transaction_info_result = $db->Execute($transaction_info_sql);

        if (!$transaction_info_result->EOF) {
            require(DIR_FS_CATALOG . DIR_WS_MODULES .
                    'payment/payzippy/payzippy_admin_notication.php');
        }

        return $output;
    }

    function after_process() {
        return false;
    }

    function output_error() {
        $output_error_string = '<table border="0" cellspacing="0" cellpadding="0" width="100%">' . "\n" . '  <tr>' . "\n" . '    <td class="main">&nbsp;<font color="#FF0000"><b>' . MODULE_PAYMENT_PAYZIPPY_TEXT_ERROR . '</b></font><br>&nbsp;' . MODULE_PAYMENT_PAYZIPPY_TEXT_ERROR_MESSAGE . '&nbsp;</td>' . "\n" . '  </tr>' . "\n" . '</table>' . "\n";
        return $output_error_string;
    }

    function check() {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYZIPPY_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install() {

        global $db, $messageStack;

        $table_created = false;
        $table_exists_query = 'SHOW TABLES LIKE"' . MODULE_PAYMENT_PAYZIPPY_TABLE . '";';
        $table_exists_result = $db->Execute($table_exists_query);

        if ($table_exists_result->EOF) {
            $this->createDatabaseTable();
            $table_created = true;
        }

        $table_exists_result = $db->Execute($table_exists_query);
        if ($table_exists_result->EOF) {
            $messageStack->add_session('Database table could not be created! The database user may not have' .
                    ' CREATE TABLE privileges?!', 'error');
            return false;
        } else if ($table_created) {
            $messageStack->add_session('Database table successfully created.', 'success');
        } else {
            $messageStack->add_session('Existing database table found and being used.', 'success');
        }
/*
        $bank_names = Constants::BANK_NAMES();

        $bank_names_string = "'zen_cfg_select_multioption(array(";
        foreach ($bank_names as $key => $value) {
            $bank_names_string .= "\'" . $key . "\', ";
        }
        $bank_names_string .= "), '";

        $payment_methods = Constants::PAYMENT_METHODS();

        $payment_methods_string = "'zen_cfg_select_multioption(array(";
        foreach ($payment_methods as $key => $value) {
            $payment_methods_string .= "\'" . $key . "\', ";
        }
        $payment_methods_string .= "), '";
*/
        global $db;
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable PayZippy Module', 'MODULE_PAYMENT_PAYZIPPY_STATUS', 'True', 'Do you want to accept payzippy payments?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Merchant ID', 'MODULE_PAYMENT_PAYZIPPY_LOGIN', '', 'Merchant ID used for the payzippy service', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Secret Key', 'MODULE_PAYMENT_PAYZIPPY_KEY', '', 'Put in the  alphanumeric key from Payzippy', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Merchant Key ID', 'MODULE_PAYMENT_PAYZIPPY_KEY_ID', '', 'Given Merchant Key Id', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('PayZippy Charging API URL', 'MODULE_PAYMENT_PAYZIPPY_URL', '', 'Charging URL for payments through PayZippy', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Callback URL', 'MODULE_PAYMENT_PAYZIPPY_CALLBACK_URL', '', 'Callback URL for payments through PayZippy. Set it {yoursitename}/payzippy2_process.php. <br/>For example, if your site is at http\://www.example.com/zen/, then set callback URL to http\://www.example.com/zen/payzippy2_process.php', '6', '0', now())");
        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Payment Methods to enable', 'MODULE_PAYMENT_PAYZIPPY_METHODS', '', 'Payment Methods to enable', '6', '0'," . $payment_methods_string . ", now())");

        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Banks for Net Banking', 'MODULE_PAYMENT_PAYZIPPY_NET_BANKS', '', 'Banks to enable for Net Banking', '6', '0'," . $bank_names_string . ", now())");
        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Banks for 3 months EMI', 'MODULE_PAYMENT_PAYZIPPY_EMI_3', '', 'Banks to enable for 3 months EMI', '6', '0'," . $bank_names_string . ", now())");
        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Banks for 6 months EMI', 'MODULE_PAYMENT_PAYZIPPY_EMI_6', '', 'Banks to enable for 6 months EMI', '6', '0'," . $bank_names_string . ", now())");
        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Banks for 9 months EMI', 'MODULE_PAYMENT_PAYZIPPY_EMI_9', '', 'Banks to enable for 9 months EMI', '6', '0'," . $bank_names_string . ", now())");
        //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Banks for 12 months EMI', 'MODULE_PAYMENT_PAYZIPPY_EMI_12', '', 'Banks to enable for 12 months EMI', '6', '0'," . $bank_names_string . ", now())");

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_PAYZIPPY_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_PAYZIPPY_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
    }

    function remove() {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
        return array(
            'MODULE_PAYMENT_PAYZIPPY_STATUS',
            'MODULE_PAYMENT_PAYZIPPY_LOGIN',
            'MODULE_PAYMENT_PAYZIPPY_KEY',
            'MODULE_PAYMENT_PAYZIPPY_KEY_ID',
            'MODULE_PAYMENT_PAYZIPPY_CALLBACK_URL',
            'MODULE_PAYMENT_PAYZIPPY_URL',
            //'MODULE_PAYMENT_PAYZIPPY_METHODS',
            //'MODULE_PAYMENT_PAYZIPPY_NET_BANKS',
            //'MODULE_PAYMENT_PAYZIPPY_EMI_3',
            //'MODULE_PAYMENT_PAYZIPPY_EMI_6',
            //'MODULE_PAYMENT_PAYZIPPY_EMI_9',
            //'MODULE_PAYMENT_PAYZIPPY_EMI_12',
            'MODULE_PAYMENT_PAYZIPPY_SORT_ORDER',
            'MODULE_PAYMENT_PAYZIPPY_ORDER_STATUS_ID'
        );
    }

    function createDatabaseTable() {
        global $db;

        $db->Execute("CREATE TABLE " . MODULE_PAYMENT_PAYZIPPY_TABLE . " (
            `transaction_id` varchar(50) NOT NULL,
            `merchant_transaction_id` varchar(50) NOT NULL,
            `zen_order_id` int(11) unsigned DEFAULT NULL,
            `payment_method` varchar(50),
            `transaction_status` varchar(50),
            `transaction_response_code` varchar(100),
            `transaction_response_message` varchar(100),
            `is_international` varchar(10),
            `payment_instrument` varchar(15),
            `hash_match` varchar(10),
            `created_on` DATETIME,
            PRIMARY KEY (`transaction_id`)
        );"
        );
    }

}
?>