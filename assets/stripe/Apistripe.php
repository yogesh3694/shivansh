<?php 
/**
 * --------------------------------------------
 *	http://www.joseluisr2ac.com | Desarrollado by Jose Luis Rodriguez
 *      Api Quip Lab
 * 	@aplication Pakage
 * 	jr2ac-class-stripe.php
 * --------------------------------------------
 */
/*
 *  _stripe_charge_id 	      : ch_1ARJNgEYNwD9FytIEaXo4cQ1
 *  _stripe_charge_captured   : yes
 *  _stripe_customer_id       : cus_AaS5j3mdPZlcAO
 *  _stripe_card_id 	      : card_1AFHBcEYNwD9FytI67ZBFbZP 
 */
class Apistripe{
    protected $_token;
    protected $_customer;
    protected $_charse;
    protected $_apiTest;
    protected $_apiLive;
    protected $_dev;
    protected $_card;
    protected $_userid;
    protected $_cardinfo;
    protected $_order_id;


    public function __construct() {
        $this->_dev = true;
        $stripe = array(
          "secret_key"      => "sk_test_jvLlUOB31EPRbIEXLx9wKiiE",
          "publishable_key" => "pk_test_r1o3Sbe23WDz8JkHoGaHR4Dm"
        );
        $this->_apiTest = $stripe; 
        $this->_userid = null;
        $this->_cardinfo = array(
            "number" => 4444444445555,
            "exp_month" =>  123,
            "exp_year" => 12,
            "cvc" => 123
          );
    }
    
   
    /*   $key: publishable_key
     *   $key: secret_key     
     */  
    
    
    public function setCardInfo($dat,$key = false){
        if($key){
            $this->_cardinfo[$key] = $dat;
        }else{
            $this->_cardinfo = $dat;
        }
    }
    public function getCardInfo($key =false){
        if($key){
            return $this->_cardinfo[$key];
        }else{
            return $this->_cardinfo;
        }
        
    }
  
    public function paymentKoios($orderid){
	
	

         if($this->_userid != null){
		// echo $this->_userid;
		
            $customerid = $this->getCustomerId();
		//	echo $this->getCustomerId();
		
		//echo $customerid.'ffffff';
			 //die();
            if(empty($customerid)){
               return array('error' => "Not User credit card asociate");
            }
            $order_ob = new WC_Order($orderid);
            $total = $order_ob->get_total() * 100;
            // Charge the Customer instead of the card:
            \Stripe\Stripe::setApiKey($this->getApi('secret_key')); 
            $charge = \Stripe\Charge::create(array(
              "amount" => $total,
              "currency" => "usd",
              "customer" => $customerid
            ));
			
            $this->_charse = $charge;
            if ($charge->status == 'succeeded') {
                $chargeid = get_post_meta( $orderid ,'_stripe_charge_id',true);
                if(empty($chargeid)){
                    add_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    add_post_meta( $orderid ,'_transaction_id', $charge->id);
                    add_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    add_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    add_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    add_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    add_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }else{
                    update_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    update_post_meta( $orderid ,'_transaction_id', $charge->id);
                    update_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    update_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    update_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    update_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    update_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }
                $order_ob->add_order_note('Stripe charge complete (Charge ID: '.$charge->id.')');
                $order_ob->update_status("Completed", 'Imported order', TRUE);
                $order_ob->set_payment_method('stripe');
                $order_ob->set_payment_method_title('Credit Card Payment');
                $order_ob->set_transaction_id($charge->id);
                $order_ob->payment_complete();
                $order_ob->save();
                return $charge;
            }else{
                return array('error' => "Not user id");
            }
         }else{
              return array('error' => "Not user id");
         }
    }

    public function paymentEccma($token){
        if($this->_userid != null){
            $user_id = $this->_userid;
            $orderid = $this->getOrderId();
            $this->_token =  $token; 
            $card = $this->getCardId($user_id);
            if(empty($card)){

            }
            $this->_card = $token->card;
            add_user_meta( $user_id,'_stripe_card_id', $token->card->id);
            $customerid = $this->getCustomerId();
            if(empty($customerid)){
                $customerid = $this->createCustomer($user_id);
            }
            $order_ob = new WC_Order($orderid);
            $total = $order_ob->get_total() * 100;
            // Charge the Customer instead of the card:
            \Stripe\Stripe::setApiKey($this->getApi('secret_key')); 
            $charge = \Stripe\Charge::create(array(
              "amount" => $total,
              "currency" => "usd",
              "customer" => $customerid
            ));
            $this->_charse = $charge;
            if ($charge->status == 'succeeded') {
                $chargeid = get_post_meta( $orderid ,'_stripe_charge_id',true);
                if(empty($chargeid)){
                    add_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    add_post_meta( $orderid ,'_transaction_id', $charge->id);
                    add_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    add_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    add_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    add_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    add_post_meta( $orderid ,'_stripe_card_id', $token); 
                    add_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }else{
                    update_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    update_post_meta( $orderid ,'_transaction_id', $charge->id);
                    update_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    update_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    update_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    update_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    update_post_meta( $orderid ,'_stripe_card_id', $token); 
                    update_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }
                $order_ob->add_order_note('Stripe charge complete (Charge ID: '.$charge->id.')');
                $order_ob->update_status("Completed", 'Imported order', TRUE);
                $order_ob->set_payment_method('stripe');
                $order_ob->set_payment_method_title('Credit Card Payment');
                $order_ob->set_transaction_id($charge->id);
                $order_ob->payment_complete();
                $order_ob->save();
                return $charge;
            }else{
                return array('error' => "Not user id");
            }
        }else{
            return array('error' => "Not user id");
        }
    }
    public function paymentEccmaSource($token){
        $user_id = $this->_userid;
        $orderid = $this->getOrderId();
        \Stripe\Stripe::setApiKey($this->getApi('secret_key'));
        $customerid = $this->getCustomerId();
        if(empty($customerid)){
            $user = new ApiUser();
            $user->loadById($user_id);
            $customer = \Stripe\Customer::create(array(
              "email" => $user->getEmail(),
              "source" => $token,
            ));
            add_user_meta( $user_id,'_stripe_customer_id', $customer->id);
        }else{
            $cu = \Stripe\Customer::retrieve($customerid);
            $cu->description = "Customer for quiplab";
            $cu->source = $token; // obtained with Stripe.js
            $cu->save();
        }   
        $order_ob = new WC_Order($orderid);
            $total = $order_ob->get_total() * 100;
            // Charge the Customer instead of the card:
            \Stripe\Stripe::setApiKey($this->getApi('secret_key')); 
            $charge = \Stripe\Charge::create(array(
              "amount" => $total,
              "currency" => "usd",
              "customer" => $customerid,
              "source" => $token,
            ));
            $this->_charse = $charge;
            if ($charge->status == 'succeeded') {
                $chargeid = get_post_meta( $orderid ,'_stripe_charge_id',true);
                if(empty($chargeid)){
                    add_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    add_post_meta( $orderid ,'_transaction_id', $charge->id);
                    add_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    add_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    add_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    add_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    add_post_meta( $orderid ,'_stripe_card_id', $token); 
                    add_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }else{
                    update_post_meta( $orderid ,'_stripe_charge_id', $charge->id);
                    update_post_meta( $orderid ,'_transaction_id', $charge->id);
                    update_post_meta( $orderid ,'_stripe_charge_captured', 'yes'); 
                    update_post_meta( $orderid ,'_payment_method', 'stripe'); 
                    update_post_meta( $orderid ,'_payment_method_title', 'Credit Card Payment'); 
                    update_post_meta( $orderid ,'_paid_date', date("Y-m-d H:i:s")); 
                    update_post_meta( $orderid ,'_stripe_card_id', $token); 
                    update_post_meta( $orderid, '_stripe_customer_id', $customerid);
                }                
                $order_ob->update_status("pending", 'Imported order', TRUE);
                $order_ob->save();
                return $charge;
            }else{
                return array('error' => "Not user id");
            }
        
    }
    /*  $cardinfo['number']
     *  $cardinfo['exp_month']
     *  $cardinfo['exp_year']
     *  $cardinfo['cvc']
     */
    
    public function createToken($cardinfo){
        \Stripe\Stripe::setApiKey($this->getApi('secret_key'));
         $token = \Stripe\Token::create(array(
          "card" => array(
            "number" => $cardinfo['number'],
            "exp_month" => $cardinfo['exp_month'],
            "exp_year" => $cardinfo['exp_year'],
            "cvc" => $cardinfo['cvc']
          )
        ));
        $this->_token =  $token; 
        $this->_card = $token->card;
       return $token->card->id;
    }
    
    public function getCard(){
        return $this->_card;
    }

    public function getCardId($user_id = false){
        if($user_id){
            return get_user_meta( $user_id, '_stripe_card_id', true ); 
        }else{
            return get_user_meta( $this->_userid, '_stripe_card_id', true ); 
        }
    }
    
    public function getToken(){
        return $this->_token;
    }
    
    public function getCustomer(){
        return $this->_customer;
    }
    
 
    public function  createCustomer($user_id){
        $user = new ApiUser();
        $user->loadById($user_id);
        $token = $this->getToken();
        // 'plan'     => "monthly_recurring_setupfee",
        //"description" => "Customer for benjamin.white@example.com",
        \Stripe\Stripe::setApiKey($this->getApi('secret_key')); 
        $customer = \Stripe\Customer::create(array(
            'source'   => $token,
            'email'    => $user->getEmail()
        ));
        add_user_meta( $user_id,'_stripe_customer_id', $customer->id); 
        $this->_customer =  $customer;
        return $customer->id;
    }
    
    
    
    public function getCharse(){
        return $this->_charse;
    }
    
    public function getCharseId($order_id = false){
        if($order_id){
            return get_post_meta( $order_id, '_stripe_charge_id', true );
        }else{
            return get_post_meta($this->_order_id, '_stripe_charge_id', true );
        }
	//$captured = get_post_meta( $order_id, '_stripe_charge_captured', true );
    }

    public function createCharse($amount,$orderID){
        
        $token = $this->getToken();
        \Stripe\Stripe::setApiKey($this->getApi('secret_key'));
        $charse = \Stripe\Charge::create(array(
          "amount" => $amount,
          "currency" => "usd",
          "source" => $token, // obtained with Stripe.js
          "description" => "Charge for order : ".$orderID
        ));
        $this->_charse = $charse;
        add_post_meta( $orderID ,'_stripe_charge_id', $charse->id);  
        return $charse->id;
    }
    
    
    /*
     * if ( $meta_value = get_post_meta( $order_id, '_stripe_customer_id', true ) ) {
				$stripe_customer->set_id( $meta_value );
			}

			if ( $meta_value = get_post_meta( $order_id, '_stripe_card_id', true ) ) {
				$stripe_source = $meta_value;
			}
     * 
     * if ( $source->customer ) {
			update_post_meta( $order_id, '_stripe_customer_id', $source->customer );
		}
		if ( $source->source ) {
			update_post_meta( $order_id, '_stripe_card_id', $source->source );
		}
     * 
     * update_post_meta( $order_id, '_stripe_charge_id', $response->id );
		update_post_meta( $order_id, '_stripe_charge_captured', $response->captured ? 'yes' : 'no' );
     */
}