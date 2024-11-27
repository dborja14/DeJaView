<?php

namespace App\Services;

use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PayPalService
{
    protected $apiContext;

    public function __construct()
    {
        $paypalConfig = config('paypal');

        // Determine the environment mode
        $mode = $paypalConfig['mode'];

        // Get the correct client_id and client_secret based on the mode
        $clientId = $paypalConfig[$mode]['client_id'];
        $clientSecret = $paypalConfig[$mode]['client_secret'];

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,     // ClientID
                $clientSecret   // ClientSecret
            )
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function createPayment($total)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($total);
        $amount->setCurrency(config('paypal.currency')); // Use the configured currency

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Order Payment');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success'))
            ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            throw new \Exception('Error processing PayPal payment: ' . $ex->getMessage());
        }

        return $payment;
    }

    public function executePayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $payment->execute($execution, $this->apiContext);
            return $payment; // Return the executed payment object
        } catch (PayPalConnectionException $ex) {
            // Handle exceptions as needed
            throw new \Exception("Error executing payment: " . $ex->getMessage());
        }
    }
}
