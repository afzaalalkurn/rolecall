<?php
/**
 * File Paypal.php.
 *
 * @author Andrey Klimenko <andrey.iemail@gmail.com>
 * @see https://github.com/paypal/rest-api-sdk-php/blob/master/sample/
 * @see https://developer.paypal.com/webapps/developer/applications/accounts
 */

namespace frontend\components;


use backend\modules\core\models\search\CorePlan;
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
    public function payNow($model){

        $user = Yii::$app->user->identity->user;
        $userAddress = $user->userAddress;
        $userProfile = $user->userProfile;
        $userPlan = CorePlan::findOne($model->plan_id);



        //$userPlan = $userProfile->plan;

        /* Create a new instance of Agreement object
        {
            "name": "DPRP",
            "description": "Payment with credit Card ",
            "start_date": "2015-06-17T9:45:04Z",
            "plan": {
              "id": "P-1WJ68935LL406420PUTENA2I"
            },
            "shipping_address": {
                "line1": "111 First Street",
                "city": "Saratoga",
                "state": "CA",
                "postal_code": "95070",
                "country_code": "US"
            },
            "payer": {
                "payment_method": "credit_card",
                "payer_info": {
                  "email": "ganesh-buyer@hotmail.com"
                },
                "funding_instruments": [
                    {
                        "credit_card": {
                            "type": "visa",
                            "number": "4417119669820331",
                            "expire_month": "12",
                            "expire_year": "2017",
                            "cvv2": "128"
                        }
                    }
                ]
            }
        }*/

        /*$now = new \DateTime('now', new \DateTimeZone('Asia/Kolkata'));*/
        //pr($this->_apiContext->getConfig());
        $now = new \DateTime('now');
        $now->modify('+5 minutes');

        $agreement = new Agreement();
        $agreement->setName($userPlan->name)
            ->setDescription($userPlan->description)
            ->setStartDate($now->format(\DateTime::ATOM));



// Add Plan ID
// Please note that the plan Id should be only set in this case.

        $paypalPlan = $this->findPaypalPlan($userPlan->paypal_plan_id);

        $plan = new Plan();
        $plan->setId($paypalPlan->getId());
        $agreement->setPlan($plan);


        // Add Payer
        $payer = new Payer();
        $payerInfo = new PayerInfo();
        $payerInfo->setFirstName($user->userProfile->first_name);
        $payerInfo->setLastName($user->userProfile->last_name);
        $payerInfo->setEmail($user->email);
        $payer->setPayerInfo($payerInfo);

        /*pr($model->method);*/

        if ($model->method == 1) {
            $payer->setPaymentMethod('paypal');
        } else {

            // Add Credit Card to Funding Instruments
            $payer->setPaymentMethod('credit_card');
            $payer->setPayerInfo(new PayerInfo(array('email' => $model->email)));
            $card_number = (int)str_replace(' ', '', $model->number);

            $card = new CreditCard();
            $card->setType($model->type)
                ->setNumber($card_number)
                ->setExpireMonth($model->expire_month)
                ->setExpireYear($model->expire_year)
                ->setCvv2($model->cvv2);

            $fundingInstrument = new FundingInstrument();
            $fundingInstrument->setCreditCard($card);
            $payer->setFundingInstruments(array($fundingInstrument));
        }

        //Add Payer to Agreement
        $agreement->setPayer($payer);


        // For Sample Purposes Only.
        $request = clone $agreement;

        // ### Create Agreement
        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($this->_apiContext);
            if ($model->method == 1) {
                $approvalUrl = $agreement->getApprovalLink();
                Yii::$app->getResponse()->redirect($approvalUrl)->send();
                exit;
            }

        } catch (Exception $ex) {
            pt($ex);
        }

        /*return $agreement;*/


    }

    public function getAgreement()
    {
        /** @var $user User */
        $user = \Yii::$app->user->identity;
        $transaction = $user->user->userProfile->transaction;
        if(is_null($transaction)) return false;

        $agreement_id = $transaction->agreement_id;
        if(empty($agreement_id)) return false;

        try {
            $agreement = Agreement::get($agreement_id, $this->_apiContext);
        } catch (\Exception $ex) {
            pr($ex);
        }
        return $agreement;
    }

    public function getCurrentPlan($agreementId){
        $agreement = Agreement::get($agreementId, $this->_apiContext);
        return $agreement->getPlan()->getId();
    }

    public function executeAgreement()
    {

        /** @var $user User */
        $success = $_GET['success'];
        $user = Yii::$app->user->identity;
        if (isset($success) && $success == TRUE) {
            $token = $_GET['token'];

            $agreement = new Agreement();
            try {
                    $agreement->execute($token, $this->_apiContext);
                    return $agreement;

            } catch (\Exception $exception) {
                $message = $exception->getMessage();

                return ['type' => 'info', 'duration' => 0, 'icon' => 'fa fa-check', 'message' => $message, 'title' => 'Info', 'positonY' => 'top', 'positonX' => 'right'];
            }
        }
    }

    protected function findPaypalPlan($plan_id)
    {
        try {

            $plan = Plan::get($plan_id,  $this->_apiContext);
            return $plan;
        } catch (\Exception $exception) {
            throw new \NotFoundHttpException($exception->getMessage());
        }
    }

}