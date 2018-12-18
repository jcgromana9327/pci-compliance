<?php

class MySeleniumSuite extends PHPUnit_Extensions_Selenium2TestCase {

    public function setUp(){


        $this -> configHost = require __DIR__ . "/config/host.php";
        $this->setBrowser("chrome");
        // $this->setBrowserUrl("http://www.partstrain.com/");
        $this -> configPageUrl = require __DIR__ . "/config/pageUrl.php";
        $this -> configEnvironment = require __DIR__ . "/config/environment.php";
        $this -> configInjection = require __DIR__ . "/config/injection.php";
        $this -> setHost($this -> configHost["host"]);
        $this -> setPort($this -> configHost["port"]);
        $this -> setBrowserUrl($this -> configEnvironment["dev"]);
        $this->setSeleniumServerRequestsTimeout(10);
        $this->assertTrue(true);
        $chromeOptionsArr = array(

            "args" => array(
                '--headless',
                '--window-size=1300,1300',
                '--user-agent=Mozilla/5.0 (X11; Fedora; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3071.115 Safari/537.36 usap_selenium',
            ),
        );
        $param = array(
            "acceptInsecureCerts" => true,
            "chromeOptions" => $chromeOptionsArr,
            "goog:chromeOptions" => $chromeOptionsArr,
        );

        $this->setDesiredCapabilities($param);
        $this -> filename = __DIR__ . "/reports/sql-injection-result.html";
        $this -> fp = fopen($this -> filename, 'w');
        $data = '<!DOCTYPE html>
    <html>
    <head>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td{
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            thead tr {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
                background-color: navy;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <i class=""></i>PCI Compliance - SQL Injection Validation</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Scenario</th>
                                    <th>Expected Result</th>
                                    <th>Actual Result</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Scenario</th>
                                    <th>Expected Result</th>
                                    <th>Actual Result</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                            <tbody>';

        fwrite($this->fp, $data);
    }

    public function testCart()
   {
      $this->validateForms();
      $data1 = '</tbody></table>
                  </div>
              </div>
              <div class="card-footer small text-muted"></div>
          </div>
      </div>
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Page level plugin JavaScript-->
      <script src="vendor/datatables/jquery.dataTables.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin.min.js"></script>
      <!-- Custom scripts for this page-->
      <script src="js/sb-admin-datatables.min.js"></script>
      </body>
      </html>';
      fwrite($this->fp, $data1);
      fclose($this->fp);
   }

   public function validateForms(){
     // $this->url("/");
       // $this->cookie()->clear();
       $this->searchbox();
       $this->login();
       $this->trackorder();
       $this->forgotPassword();
       $this->accountRegistration();
       $this->couponCode();
       $this->saveQuote();
       $this->retrieveQuote();
       $this->checkout();
       $this->myaccount_address();
       $this->myaccount_change_password();
       $this->myaccount_addVehicles();
       $this->checkout_signin();
   }

public function searchbox(){
   $url = $this -> configPageUrl["search"];
   $inject = $this -> configInjection["sql-inject"];
   $fields = array(
   "Ntt" =>  urlencode($inject),
   );
   $content = $this->loadCurlHeader($url ,$fields , "-");
   echo "\n\nValidate Seachbox";
   $formName = "searchbox";
   $this->validateStatusCode($url,$content,$formName);

}

public function login(){
  $url = $this -> configPageUrl["myaccount"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "username" =>  urlencode($injectEmail),
  "password" =>  urlencode($inject),
  "login" =>  urlencode("Login"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Login";
  $formName = "my account login";
  $this->validateStatusCode($url,$content,$formName);
  // echo $this->validateStatusCode($url,$content);
}

public function trackorder(){
  $url = $this -> configPageUrl["myaccount"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "email" =>  urlencode($injectEmail),
  "orderid" =>  urlencode($inject),
  "TracOrderUnregistered" =>  urlencode("Track"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Trackorder";
  $formName = "my account trackorder";
  $this->validateStatusCode($url,$content,$formName);

}

public function forgotPassword(){
  $url = $this -> configPageUrl["myaccount"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "forgotPwdEmail" =>  urlencode($injectEmail),
  "sub_recoverPasswd" =>  urlencode("Submit"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Forgot Password";
  $formName = "my account forgotPassword";
  $this->validateStatusCode($url,$content,$formName);

}

public function accountRegistration(){
  $url = $this -> configPageUrl["myaccount"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];

  $fields = array(
  "FirstName" =>  urlencode($inject),
  "LastName" =>  urlencode($inject),
  "UserName" =>  urlencode($injectEmail),
  "Password" =>  urlencode($inject),
  "submit" =>  urlencode("Create Account"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Account Registration";
  $formName = "my account registration";
  $this->validateStatusCode($url,$content,$formName);
}

public function couponCode(){
  $url = $this -> configPageUrl["cart"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "coupon_code" =>  urlencode($inject),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Coupon code";
  $formName = "cart coupon code";
  $this->validateStatusCode($url,$content,$formName);

}

public function saveQuote(){
  $url = $this -> configPageUrl["savequote"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "first_name" =>  urlencode($inject),
  "last_name" =>  urlencode($inject),
  "email_address" =>  urlencode($injectEmail),
  "phone_number" =>  urlencode($inject),
  "buttonsaveQuote" =>  urlencode("Save Quote"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Save and Quote";
  $formName = "save quote";
  $this->validateStatusCode($url,$content,$formName);

}

public function retrieveQuote(){
  $url = $this -> configPageUrl["retrievequote"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "quoteId" =>  urlencode($inject),
  "buttonGo" =>  urlencode("Retrieve"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Retrieve Quote";
  $formName = "retrieve quote";
  $this->validateStatusCode($url,$content,$formName);

}

public function checkout(){
  $url = $this -> configPageUrl["checkout"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "customer_first_name" =>  urlencode($inject),
  "customer_last_name" =>  urlencode($inject),
  "customer_company" =>  urlencode($inject),
  "customer_street_address" =>  urlencode($inject),
  "customer_city" =>  urlencode($inject),
  "customer_state" =>  urlencode($inject),
  "customer_postcode" =>  urlencode($inject),
  "customer_phone_parts[one]" =>  urlencode("'\*'"),
  "customer_phone_parts[two]" =>  urlencode("'\*'"),
  "customer_phone_parts[three]" =>  urlencode("'\**'"),
  "customer_email_address" =>  urlencode($injectEmail),
  "customer_confirm_email_address" =>  urlencode($injectEmail),
  "credit-card-number" =>  urlencode("4111111111111111"),
  "expiration-month" =>  urlencode("09"),
  "expiration-year" =>  urlencode("2029"),
  "cvv" =>  urlencode("123"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Checkout form";
  $formName = "checkout";
  $this->validateStatusCode($url,$content,$formName);

}

public function myaccount_address(){
  $url = $this -> configPageUrl["alladdress"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "addr_label" =>  urlencode($inject),
  "addr_fname" =>  urlencode($inject),
  "addr_lname" =>  urlencode($inject),
  "addr_company" =>  urlencode($inject),
  "addr_line_1" =>  urlencode($inject),
  "addr_line_2" =>  urlencode($inject),
  "addr_country" =>  urlencode($inject),
  "addr_state" =>  urlencode($inject),
  "addr_city" =>  urlencode($inject),
  "addr_zip" =>  urlencode($inject),
  "addr_phone1" =>  urlencode("123"),
  "addr_phone2" =>  urlencode("321"),
  "addr_phone3" =>  urlencode("1233"),
  "Save" =>  urlencode("Save Changes"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate my account Add Address";
  $formName = "Myaccount add address";
  $this->validateStatusCode($url,$content,$formName);

}

public function myaccount_change_password(){
  $url = $this -> configPageUrl["alladdress"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "firstname" =>  urlencode($inject),
  "last_name" =>  urlencode($inject),
  "old_password" =>  urlencode("usap1q2w"),
  "new_password1" =>  urlencode($inject),
  "new_password2" =>  urlencode($inject),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Myaccount Change Password";
  $formName = "My change password";
  $this->validateStatusCode($url,$content,$formName);

}

public function myaccount_addVehicles(){
  $url = $this -> configPageUrl["getallvehicles"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "year" =>  urlencode($inject),
  "make" =>  urlencode($inject),
  "model" =>  urlencode($inject),
  "submodel" =>  urlencode($inject),
  "engine" =>  urlencode($inject),
  "ymm_submit" =>  urlencode("Save"),

  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Myaccount Add Vehicles";
  $formName = "my account add vehicles";
  $this->validateStatusCode($url,$content,$formName);

}

public function checkout_signin(){
  $url = $this -> configPageUrl["checkout"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "username" =>  urlencode($injectEmail),
  "password" =>  urlencode($inject),
  "sign_in_button" =>  urlencode("Sign In"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Checkout Sign In email";
  $formName = "checkout sign in";
  $this->validateStatusCode($url,$content,$formName);

}

 public function validateStatusCode($url,$content,$formName){


   $content[0] = "http_status: " . $content[0];
   $temp = explode("\n", $content[0]);
   $tmpArr = array();
   $httpStatus = str_replace("http_status: ", "", "$temp[0]");
   $scenario = "Validate SQL injection in ".$formName;
   $expected = "true";

   // if(strcasecmp($httpStatus,"HTTP/1.1 200 OK") == 0){
   $statusCompare = !strpos($httpStatus, "Forbidden");
  if ($statusCompare !== false) {
     // $timestamp = strtotime('now');
     // $screenshotFile = $timestamp . ".png";
     // $this -> createScreenshot($screenshotFile);
     echo "\nHTTP Status: " . $httpStatus;
     $actual = "true";
     $this->writeReport($scenario, $expected, $actual,$httpStatus,$formName);
     // return $httpStatus;
     // $this->back();

   }else{
     // $timestamp = strtotime('now');
     // $screenshotFile = $timestamp . ".png";
     // $this -> createScreenshot($screenshotFile);
     echo "\nHTTP Status: " . $httpStatus;
     $actual = "false";
     $this->writeReport($scenario, $expected, $actual,$httpStatus);
   }

 }

 public function writeReport($scenario, $expected, $actual,$httpStatus) {
     if (is_bool($expected) and ( $expected == true)) {
         $expected_text = "HTTP/1.1 200 OK";
     } elseif (is_bool($expected) and ( $expected == false)) {
         $expected_text = "false";
     } else {
         $expected_text = "HTTP/1.1 200 OK";
     }

     if (is_bool($actual) && ($actual == true)) {
         $actual_text = $httpStatus;
     } elseif (is_bool($actual) && ($actual == false)) {
         $actual_text = $httpStatus;
     } else {
         $actual_text = $httpStatus;
     }
     if ($expected == $actual) {
         $status = "Passed";
         $color = "#629632";
     } else {
         $status = "Failed";
         $color = "#FF0000";
     }
     $data = '<tr>
                            <td>' . $scenario . '</td>
                            <td>' . $expected_text . '</td>
                            <td>' . $actual_text . '</td>
                            <td><b><font color =' . $color . '>' . $status . '</font></b></td>
                          </tr>';

     fwrite($this->fp, $data);
 }


 public function onNotSuccessfulTest(Throwable $e) {

     $this -> createScreenshot("thereIsError.png");
     echo $e -> getMessage() . "\n\n";
     echo $e -> getTraceAsString();
 }

 public function createScreenshot($fileName = "fileNameNotSet.png") {
     $screenshotDir = __DIR__ . "/screenshots/";
     $base64 = base64_decode($this -> screenshot());
     file_put_contents($screenshotDir . $fileName, $base64);
 }


 public function loadCurlHeader($url,$fields) {


$fields_string = "";

if(!empty($fields)){
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');
}

$ch = curl_init();
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/58.0.1 usap_selenium');

      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  //    curl_setopt($ch, CURLOPT_SSLVERSION, 3);

      curl_setopt($ch, CURLOPT_HEADER, true);
      //curl_setopt($ch, CURLOPT_NOBODY, true);

      $content = curl_exec($ch);
      curl_close($ch);

     //echo "raw: \n"; print_r($content); echo "\n";
     $arrRequests = explode("\r\n\r\n", $content);

     $headers = array();
     $headers = $arrRequests;

     return $headers;
 }

}
?>
