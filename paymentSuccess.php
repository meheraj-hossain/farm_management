<?php
include_once('helpers/db_con.php');
$val_id=urlencode($_POST['val_id']);
$store_id=urlencode("disas6070705cd6fd1");
$store_passwd=urlencode("disas6070705cd6fd1@ssl");
$requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle)))
{

	# TO CONVERT AS ARRAY
	# $result = json_decode($result, true);
	# $status = $result['status'];

	# TO CONVERT AS OBJECT
	$result = json_decode($result);

	# TRANSACTION INFO
	$status = $result->status;
	$tran_date = $result->tran_date;
	$tran_id = $result->tran_id;
	$val_id = $result->val_id;
	$amount = $result->amount;
	$store_amount = $result->store_amount;
	$bank_tran_id = $result->bank_tran_id;
	$card_type = $result->card_type;

	# EMI INFO
	$emi_instalment = $result->emi_instalment;
	$emi_amount = $result->emi_amount;
	$emi_description = $result->emi_description;
	$emi_issuer = $result->emi_issuer;

	# ISSUER INFO
	$card_no = $result->card_no;
	$card_issuer = $result->card_issuer;
	$card_brand = $result->card_brand;
	$card_issuer_country = $result->card_issuer_country;
	$card_issuer_country_code = $result->card_issuer_country_code;

	# API AUTHENTICATION
	$APIConnect = $result->APIConnect;
	$validated_on = $result->validated_on;
	$gw_version = $result->gw_version;

	$CowId = $result->value_a;
	$user_id = $result->value_c;
	$discount_code = $result->value_d;


	$get_customer = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE id='$user_id' "));
	$customer_name = $get_customer['name'];
	$customer_phone = $get_customer['phone'];
	$order_date = date('Y-m-d');

	
	$insert_selling = mysqli_query($con,"INSERT INTO cow_sellings VALUES('','$customer_name', '$customer_phone','$CowId','$amount','$order_date',1,0,'') ");
	if ($insert_selling) {
		//update cow as sold
		mysqli_query($con,"UPDATE cows SET status=0 WHERE unique_id='$CowId' ");
		//delete discount code
		mysqli_query($con,"DELETE FROM `discount_codes` WHERE code='$discount_code'");
		//insert transaction details
		mysqli_query($con,"INSERT INTO cow_selling_transactions VALUE('','$tran_id','$card_type','$tran_date','$CowId')");
		$notification_insert = mysqli_query($con,"INSERT INTO notifications VALUE('','New Cow order','$CowId is orderd by $customer_name', 'cowSellingList.php',0,0) ");

		$_SESSION["SuccessMessage"]="Cow Buy Successfull";
		header('Location:cows.php');
	}
} else {
	$_SESSION["SuccessMessage"]="Failed to connect with SSLCOMMERZ";
	header('Location:cows.php');
}

?>