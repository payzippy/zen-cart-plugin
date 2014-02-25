<?php

$output .= '<td></td></tr>';
$output .= '<tr class="PayZippyOrderTableRow">';
$output .= '<td>';

$output .= <<< STYLEBLOCK
<style type="text/css">
	#payzippy-admin { padding: 0; padding-top: 6px; border-top: 1px solid #000; }
	#payzippy-admin-transaction-info { width: 50%; }
	#payzippy-admin th { text-align: left; white-space: nowrap }
	#payzippy-admin h3 { padding-bottom: 0.2em; border-bottom: 1px solid #ccc; }
	table#payzippy-transaction { padding: 0; border-collapse: collapse; }
	#payzippy-transaction th { background-color: #d7d6cc; padding: 0.4em 1em 0.4em 0.4em; border-right: 0.2em solid #fff; border-bottom: 0.2em solid #fff; }
	#payzippy-transaction td { background-color: #f2f1ee; padding: 0.4em 0.8em; }
</style>
STYLEBLOCK;

$output .= '<div id="payzippy-admin">';

$output .= '<div id="payzippy-admin-transaction-info">';
$output .= '<h3>' . "PayZippy Transaction Details" . '</h3>' . "\n";
$output .= '<table id="payzippy-transaction" width=\"100%\">' . "\n";

foreach ($transaction_info_result->fields as $key => $value){
	$transaction_info_result->fields[$key] = stripslashes($value);
}

$output .= '<tr><th>' . "\n";
$output .= "PayZippy Transaction ID\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['transaction_id'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Payment Method\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['payment_method'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Transaction Status\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['transaction_status'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Transaction Response Code\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['transaction_response_code'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Transaction Response Message\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['transaction_response_message'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Is International\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['is_international'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '<tr><th>' . "\n";
$output .= "Payment Instrument\n";
$output .= '</th><td>' . "\n";
$output .= $transaction_info_result->fields['payment_instrument'] . "\n";
$output .= '</td></tr>' . "\n";

$output .= '</table>';
$output .= '</div>';
$output .= '</div>';
$output .= '</td>' . "\n\t";

//zen_redirect(zen_href_link("shopping_cart&action=empty_cart"));
//zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, 'action=empty_cart', 'SSL', true, false));

?>
