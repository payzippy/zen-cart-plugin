<?php
require_once 'includes/application_top_payzippy.php';
require_once 'includes/modules/payment/payzippy/ChargingResponse.php';
require_once 'includes/modules/payment/payzippy/Constants.php';

global $_POST, $messageStack;

$charging_response = new ChargingResponse($_POST);
$charging_response->set_secret_key(MODULE_PAYMENT_PAYZIPPY_KEY);
$hash_match = $charging_response->validate();

$payment_method = $charging_response->get_payment_method();
if ($payment_method == Constants::PAYMENT_MODE_EMI) {
    $payment_method = Constants::BANK_NAMES($charging_response->get_bank_name()) . " EMI " . $charging_response->get_emi_months();
} else if ($payment_method == Constants::PAYMENT_MODE_NET) {
    $payment_method = Constants::BANK_NAMES($charging_response->get_bank_name()) . " Net Banking";
}

$response_array_for_db = array(
    'transaction_id' => zen_db_prepare_input($charging_response->get_payzippy_transaction_id()),
    'merchant_transaction_id' => zen_db_prepare_input($charging_response->get_merchant_transaction_id()),
    'transaction_status' => zen_db_prepare_input($charging_response->get_transaction_status()),
    'transaction_response_code' => zen_db_prepare_input($charging_response->get_transaction_response_code()),
    'transaction_response_message' => zen_db_prepare_input($charging_response->get_transaction_response_message()),
    'payment_instrument' => zen_db_prepare_input($charging_response->get_payment_instrument()),
    'is_international' => zen_db_prepare_input($charging_response->get_is_international()),
    'payment_method' => zen_db_prepare_input($payment_method),
    'hash_match' => zen_db_prepare_input($hash_match),
    'created_on' => date('Y-m-d H:i:s')
);

$transaction_exists_query = 'SELECT * FROM `' . MODULE_PAYMENT_PAYZIPPY_TABLE . '` WHERE transaction_id = "' . zen_db_prepare_input($charging_response->get_payzippy_transaction_id()) . '";';
$transaction_exists_result = $db->Execute($transaction_exists_query);

if (!$transaction_exists_result->EOF) {
    $messageStack->add_session('checkout_payment', "Duplicate Transaction Detected. Your transaction has failed.", 'error');
    $redirect_url = zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false);
} else {
    zen_db_perform(MODULE_PAYMENT_PAYZIPPY_TABLE, $response_array_for_db, 'insert');
    if (!$hash_match) {
        $messageStack->add_session('checkout_payment', Constants::PAYMENT_ILLEGAL, 'error');
        $redirect_url = zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false);
    } else if ($hash_match && $charging_response->get_transaction_status() == Constants::RESPONSE_FAILED) {
        $messageStack->add_session('checkout_payment', Constants::PAYMENT_FAILED, 'error');
        $redirect_url = zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false);
    } else if ($hash_match && $charging_response->get_transaction_status() == Constants::RESPONSE_PENDING) {
        $messageStack->add_session('checkout_payment', Constants::PAYMENT_INITIATED, 'error');
        $redirect_url = zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false);
    } else if ($hash_match && $charging_response->get_transaction_status() == Constants::RESPONSE_SUCCESS) {
        $payzippy_transaction_id = $charging_response->get_payzippy_transaction_id();
        $redirect_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, 'paymentstatus=OK&payzippytransid=' . $payzippy_transaction_id, 'SSL', true, false);
    }
}
$redirect_url = str_replace('&amp;', '&', $redirect_url);
?>

<body>
    <script type="text/javascript" language="javascript">window.location = "<?php echo $redirect_url; ?>";</script>
    <noscript>
    If you are not redirected please <a href="<?php echo $redirect_url; ?>">click here</a> to confirm your order.
    </noscript>
</body>
