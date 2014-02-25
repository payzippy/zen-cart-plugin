<?php
require_once("Constants.php");
require_once("Utils.php");

class ChargingResponse
{
    private $params = array();
    private $secret_key;
    private $valid_parameters = array(
        Constants::PARAMETER_TRANSACTION_CURRENCY,
        Constants::PARAMETER_TRANSACTION_TIME,
        Constants::PARAMETER_TRANSACTION_RESPONSE_CODE,
        Constants::PARAMETER_TRANSACTION_STATUS,
        Constants::PARAMETER_MERCHANT_KEY_ID,
        Constants::PARAMETER_TRANSACTION_AMOUNT,
        Constants::PARAMETER_BANK_NAME,
        Constants::PARAMETER_HASH,
        Constants::PARAMETER_AUTH_STATE,
        Constants::PARAMETER_TRANSACTION_TYPE,
        Constants::PARAMETER_TRANSACTION_RESPONSE_MESSAGE,
        Constants::PARAMETER_VERSION,
        Constants::PARAMETER_UDF1,
        Constants::PARAMETER_UDF2,
        Constants::PARAMETER_UDF3,
        Constants::PARAMETER_UDF4,
        Constants::PARAMETER_UDF5,
        Constants::PARAMETER_HASH_METHOD,
        Constants::PARAMETER_PAYZIPPY_TRANSACTION_ID,
        Constants::PARAMETER_MERCHANT_TRANSACTION_ID,
        Constants::PARAMETER_IS_INTERNATIONAL,
        Constants::PARAMETER_FRAUD_ACTION,
        Constants::PARAMETER_FRAUD_DETAILS,
        Constants::PARAMETER_MERCHANT_ID,
        Constants::PARAMETER_PAYMENT_METHOD,
        Constants::PARAMETER_INSTRUMENT,
        Constants::PARAMETER_EMI_MONTHS
    );

    function __construct($params)
    {
        foreach ($params as $key => $value) {
//            if(in_array($key, $this->valid_parameters)){
                $this->params[$key] = $value;
//            }
        }
              unset($this->params['main_page']);
    }
    
    public function set_secret_key($value)
    {
      $this->secret_key = $value;
      return $this;
    }

    public function get_merchant_id()
    {
        return $this->params[Constants::PARAMETER_MERCHANT_ID];
    }

    public function get_merchant_key_id()
    {
        return $this->params[Constants::PARAMETER_MERCHANT_KEY_ID];
    }

    public function get_merchant_transaction_id()
    {
        return $this->params[Constants::PARAMETER_MERCHANT_TRANSACTION_ID];
    }

    public function get_payzippy_transaction_id()
    {
        return $this->params[Constants::PARAMETER_PAYZIPPY_TRANSACTION_ID];
    }

    public function get_transaction_status()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_STATUS];
    }

    public function get_transaction_response_code()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_RESPONSE_CODE];
    }

    public function get_transaction_response_message()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_RESPONSE_MESSAGE];
    }

    public function get_payment_method()
    {
        return $this->params[Constants::PARAMETER_PAYMENT_METHOD];
    }

    public function get_payment_instrument()
    {
        return $this->params[Constants::PARAMETER_INSTRUMENT];
    }

    public function get_bank_name()
    {
        return $this->params[Constants::PARAMETER_BANK_NAME];
    }

    public function get_emi_months()
    {
        return $this->params[Constants::PARAMETER_EMI_MONTHS];
    }

    public function get_transaction_amount()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_AMOUNT];
    }

    public function get_transaction_time()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_TIME];
    }

    public function get_transaction_currency()
    {
        return $this->params[Constants::PARAMETER_TRANSACTION_CURRENCY];
    }

    public function get_fraud_action()
    {
        return $this->params[Constants::PARAMETER_FRAUD_ACTION];
    }

    public function get_fraud_details()
    {
        return $this->params[Constants::PARAMETER_FRAUD_DETAILS];
    }

    public function get_version()
    {
        return $this->params[Constants::PARAMETER_VERSION];
    }

    public function get_udf1()
    {
        return $this->params[Constants::PARAMETER_UDF1];
    }

    public function get_udf2()
    {
        return $this->params[Constants::PARAMETER_UDF2];
    }

    public function get_udf3()
    {
        return $this->params[Constants::PARAMETER_UDF3];
    }

    public function get_udf4()
    {
        return $this->params[Constants::PARAMETER_UDF4];
    }

    public function get_udf5()
    {
        return $this->params[Constants::PARAMETER_UDF5];
    }

    public function get_hash_method()
    {
        return $this->params[Constants::PARAMETER_HASH_METHOD];
    }

    public function get_hash()
    {
        return $this->params[Constants::PARAMETER_HASH];
    }

    public function get_is_international()
    {
        return $this->params[Constants::PARAMETER_IS_INTERNATIONAL];
    }

    public function get_response_params()
    {
        return $this->params;
    }

    public function validate()
    {
        $hash = Utils::generate_hash($this->get_response_params(), $this->secret_key);
        $hash_match = $hash == $this->get_hash() ? TRUE : FALSE;
        return $hash_match;
    }

    public function is_transaction_successful()
    {
        return $this->get_transaction_status() == Constants::RESPONSE_SUCCESS;
    }
}

?>