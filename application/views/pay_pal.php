
<?php
include('common/head-section.php');
?>

<?php
$n= base_url('recruiter/paypal_notify');
// $description        = $description;
// $txnid              = $txnid;     
// $key_id             = $key_id;
// $currency_code      = $currency_code;            
// $total              = $total // 100 = 1 indian rupees
// $amount             = $amount;
// $merchant_order_id  = "ABC-".date("YmdHis");
// $card_holder_name   = $card_holder_name;
// $email              = $email;
// $phone              = $phone;
// $name               = $name ;
?>

    <form name="razorpay-form" id="razorpay-form" action="<?php echo $callback_url; ?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
        <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
        <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
        <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $description; ?>"/>
        <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
        <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
        <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
        <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
        <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
        <input type="hidden" name="notify_url" value="'.$n.'">
    </form>
<body onload="read_cookie();" class="jp_authentication" <?php if(!empty($this->email)) { echo "class='jp_login'"; } ?>>
<input type="hidden" name="id" id="p_id" value="<?= $id; ?>" />
<div class="jp_main_wrapper">
    <div class="jp_auth_box_wrapper">
        <div class="container">
            <div class="jp_auth_box jp_payment_button_wrapper">
				<div class="jp_auth_form">
					<h3 class="jp_auth_title"><?= $controller->set_language('paymenu_heading'); ?></h3>
					<?php 
					$paypal_status=$res->paypal_status;
					$payu_status=$res->payu_status;
					?>
					<ul class="jp_payment_buttons">
					<?php if($paypal_status=='active') { ?>
						<li>
							<div class="pull-left">
								<h4> <?= $controller->set_language('pay_with_key'); ?> <img src="<?php echo base_url('assets/images/paypal_img.png'); ?>" alt="" class="img-responsive"></h4>
							</div>
							<div class="pull-right">  
								<input type="button" id="paypal" value="<?= $controller->set_language('pay_now_btn'); ?>" class="jp_btn jp_paypal_btn" />
							</div>
						</li>
					<?php } 
					 if($payu_status=='active') { 
					?>
						<li>
							<div class="pull-left">
								<h4> <?= $controller->set_language('pay_with_key'); ?> <img src="<?= base_url('assets/images/payu.jpg'); ?>" alt="" width="120px" class="img-responsive"></h4>
							</div>
							<div class="pull-right">  
								<input type="button" id="payu" value="<?= $controller->set_language('pay_now_btn'); ?>" class="jp_btn jp_paypal_btn" />
							</div>
						</li>
					 <?php } ?>
					 <!-- <li>
							<div class="pull-left">
								<h4> <?= $controller->set_language('pay_with_key'); ?> <img src="<?= base_url('assets/images/razor-pay.jpg'); ?>" alt="" width="120px" class="img-responsive"></h4>
							</div>
							<div class="pull-right">  
						
							<input  id="pay-btn" type="submit" onclick="razorpaySubmit(this);" value="<?= $controller->set_language('pay_now_btn'); ?>" class="jp_btn jp_paypal_btn"/>
							</div>
							</div>
						</li> -->
					</ul>
					<div id="form">
						
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<?php include('common/footer_user.php'); ?>
</body>
</html>

<!-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            key:            "<?php echo $key_id; ?>",
            amount:         "<?php echo $total; ?>",
            name:           "<?php echo $name; ?>",
            description:    "Order # <?php echo $merchant_order_id; ?>",
            netbanking:     true,
            currency:       "<?php echo $currency_code; ?>", // INR
            prefill: {
                name:       "<?php echo $card_holder_name; ?>",
                email:      "<?php echo $email; ?>",
                contact:    "<?php echo $phone; ?>"
            },
            notes: {
                soolegal_order_id: "<?php echo $merchant_order_id; ?>",
            },
            handler: function (transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('razorpay-form').submit();
            },
            "modal": {
                "ondismiss": function(){
                    location.reload()
                }
            }
        };

        var razorpay_pay_btn, instance;
        function razorpaySubmit(el) {
            if(typeof Razorpay == 'undefined') {
                setTimeout(razorpaySubmit, 200);
                if(!razorpay_pay_btn && el) {
                    razorpay_pay_btn    = el;
                    el.disabled         = true;
                    el.value            = 'Please wait...';  
                }
            } else {
                if(!instance) {
                    instance = new Razorpay(options);
                    if(razorpay_pay_btn) {
                    razorpay_pay_btn.disabled   = false;
                    razorpay_pay_btn.value      = "Pay Now";
                    }
                }
                instance.open();
            }
        }  
    </script>

</body>
</html> -->
<?php ?>
 <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>