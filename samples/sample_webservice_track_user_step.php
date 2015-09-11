<?php 
$paymentObj = new Icepay_PaymentObject();
$paymentObj->setAmount(400)
        ->setCountry("NL")
        ->setLanguage("NL")
        ->setIssuer('ACCEPTGIRO')
        ->setPaymentMethod('AFTERPAY')
        ->setReference("My Sample Website")
        ->setDescription("My Sample Payment")
        ->setCurrency("EUR")
        ->setOrderID('test01');


try {
    $webservice = Icepay_Api_Webservice::getInstance()->paymentService();
    $webservice->setMerchantID(MERCHANTID)->setSecretCode(SECRETCODE);

    $transactionObj = $webservice->extendedCheckout($paymentObj);
    $orderID = $transactionObj->getOrderID();

    $order = new Order();
    // We update the user order so we know he was redirect to icepay
    $order->update($orderID, array(
        'status' => 'USER_REDIRECTED'
    ));

    printf('<a href="%s">%s</a>', $transactionObj->getPaymentScreenURL(), 'Pay via icepay');
} catch (Exception $e) {
    var_dump($e);
}

/**
 * Example Order Class
 */
class Order
{
    public function update($id, $attributes = array()) {
       // Store this data somewhere
    }
}