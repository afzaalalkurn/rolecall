<?php
/**
 * File Paypal.php.
 *
 * @author Andrey Klimenko <andrey.iemail@gmail.com>
 * @see https://github.com/paypal/rest-api-sdk-php/blob/master/sample/
 * @see https://developer.paypal.com/webapps/developer/applications/accounts
 */

namespace backend\components;


use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\base\Component;
use PayPal\Api\Address;
use PayPal\Api\CreditCard;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\FundingInstrument;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use PayPal\Api\Agreement;
use PayPal\Api\PayerInfo;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Currency;
use PayPal\Api\ChargeModel;
use PayPal\Api\MerchantPreferences;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

use common\components\Paypal as PayPalComponent;
use common\components\ResultPrinter;

/**
 * File Paypal.php.
 *
 * @see https://github.com/paypal/rest-api-sdk-php/blob/master/sample/
 * @see https://developer.paypal.com/webapps/developer/applications/accounts
 */

class Paypal extends PayPalComponent
{
    public function createPlan($model){

        // Create a new instance of Plan object
        $plan = new Plan();

// # Basic Information
// Fill up the basic information that is required for the plan
        $plan->setName($model->name)
            ->setDescription($model->description)
            ->setType($model->plan_type);

    // # Payment definitions for this billing plan.
        $paymentDefinition = new PaymentDefinition();

// The possible values for such setters are mentioned in the setter method documentation.
// Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
// You should be able to see the acceptable values in the comments.

        $paymentType = $this->paymentType($model->payment_type);

        $paymentDefinition->setName($paymentType)
            ->setType($model->payment_type)
            ->setFrequency($model->frequency)
            ->setFrequencyInterval($model->frequency_interval)
            ->setCycles($model->cycles)
            ->setAmount(new Currency(array('value' => $model->amount, 'currency' => $this->currency)));

       // Charge Models
       $chargeModel = new ChargeModel();
       $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 0, 'currency' => 'USD')));
       $paymentDefinition->setChargeModels(array($chargeModel));

       $merchantPreferences = new MerchantPreferences();
       $baseUrl = Yii::$app->request->hostInfo;

        // ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
        // However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
        // This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.

        $merchantPreferences->setReturnUrl("$baseUrl/execute-agreement?success=true")
            ->setCancelUrl("$baseUrl/execute-agreement?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));
        $plan->setMerchantPreferences($merchantPreferences);
        $plan->setPaymentDefinitions(array($paymentDefinition));

        // For Sample Purposes Only.
        $request = clone $plan;

        // ### Create Plan
        try {
            $res = $plan->create($this->_apiContext);

        } catch ( Exception $ex ){
            pr($ex);
        }



        return $res;
    }

    public function updatePlan($id, $status){

        try {

            $patch = new Patch();
            $value = new PayPalModel('{"state":"'.$status.'"}');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            try {
                $plan = Plan::get($id, $this->_apiContext);
            } catch (Exception $ex) {
                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                pr($ex);
                exit(1);
            }

            $plan->update($patchRequest, $this->_apiContext);

        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("Updated the Plan to Active State", "Plan", null, $patchRequest, $ex);
            pr($ex);
            exit(1);
        }

        return $plan;
    }



}