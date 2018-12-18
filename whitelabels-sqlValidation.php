<?php

class MySeleniumSuite extends PHPUnit_Extensions_Selenium2TestCase {

    public function setUp(){


        $this -> configHost = require __DIR__ . "/config/host.php";
        $this->setBrowser("chrome");
        $this -> configPageUrl = require __DIR__ . "/config/pageUrl.php";
        $this -> configEnvironment = require __DIR__ . "/config/environment.php";
        $this -> configInjection = require __DIR__ . "/config/injection.php";
        $this -> configUserAgent = require __DIR__ . "/config/userAgent.php";
        $this -> configWindowSize = require __DIR__ . "/config/windowSize.php";
        $this -> templateHeader = require __DIR__ . "/template/bootstrap.php";
        $this -> setHost($this -> configHost["host"]);
        $this -> setPort($this -> configHost["port"]);
        $this -> setBrowserUrl($this -> configEnvironment["origin"]);
        // $this->setSeleniumServerRequestsTimeout(10);
        $this->assertTrue(true);
        $windowSize = $this -> configWindowSize["Desktop"];
        $userAgent = $this -> configUserAgent["Desktop"];
        $chromeOptionsArr = array(

            "args" => array(
                '--headless',
                "--window-size=$windowSize",
                "--user-agent=$userAgent",
            ),
        );
        $param = array(
            "acceptInsecureCerts" => true,
            "chromeOptions" => $chromeOptionsArr,
            "goog:chromeOptions" => $chromeOptionsArr,
        );

        $this->setDesiredCapabilities($param);
        // $this -> filename = __DIR__ . "/reports/cpo-sql-injection-result.html";
        // $this -> filename = __DIR__ . "/reports/ca.cp-sql-injection-result.html";
        // $this -> filename = __DIR__ . "/reports/ca.jcw-sql-injection-result.html";
        $this -> filename = __DIR__ . "/reports/ca.apw-sql-injection-result.html";


        $this -> fp = fopen($this -> filename, 'w');
        $data = 'Origin environment: ' . $this -> configEnvironment["origin"] .$this -> templateHeader["sql-header"];
        fwrite($this->fp, $data);
    }

    public function testCart()
   {
      $this->pass = 0;
      $this->fail = 0;
      $this->validateForms();
      $data = '</tbody></table>
                  </div>
              </div>
              <div class="card-footer">
              <table><tr>
              <td class="result">Total number of PASSED: <b>' . $this->pass. '</b></td><td> Total number of FAILED: <b>' . $this->fail . '</b></td>
              </tr></table></div>
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
      fwrite($this->fp, $data);
      fclose($this->fp);
   }

   public function validateForms(){
       // $this->url("/");
       // $this->cookie()->clear();
       $this->searchbox();
       $this->login();
       $this->trackorderRegistered();
       $this->trackorderUnRegistered();
       $this->forgotPassword();
       $this->accountRegistration();
       $this->saveQuote();
       $this->retrieveQuote();
       $this->checkout();
       $this->checkoutPayment();
       $this->myaccount_address();
       $this->myaccount_change_password();
       $this->myaccount_addVehicles();
       $this->checkout_signin();
       $this->rma();
       $this->feedback();
       $this->contact();
   }

public function searchbox(){
   $url = $this -> configPageUrl["search"];
   $inject = $this -> configInjection["sql-inject"];
   $fields = array(
   "Ntt" =>  urlencode($inject),
   );
   $content = $this->loadCurlHeader($url ,$fields , "-");
   echo "\n\nSQL Validation Test Results";
   echo "\n\nValidate Seachbox";
   $formName = "searchbox";
   $this->validateStatusCode($url,$content,$formName);

}

public function login(){
  $url = $this -> configPageUrl["myaccount"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "username" =>  urlencode("$injectEmail"),
  "password" =>  urlencode($inject),
  "login" =>  urlencode("Login"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Login Form";
  $formName = "my account login";
  $this->validateStatusCode($url,$content,$formName);
  // echo $this->validateStatusCode($url,$content);
}

public function trackorderRegistered(){
  $url = $this -> configPageUrl["trackorder"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "username" =>  urlencode($injectEmail),
  "password" =>  urlencode($inject),
  "Submit" =>  urlencode("Registered"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Trackorder Registered Customer";
  $formName = "my account trackorder registered";
  $this->validateStatusCode($url,$content,$formName);

}

public function trackorderUnRegistered(){
  $url = $this -> configPageUrl["trackorder"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "orderid" =>  urlencode($inject),
  "lastname" =>  urlencode($inject),
  "Submit" =>  urlencode("Unregistered"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Trackorder Unregistered Customer";
  $formName = "my account trackorder unregistered";
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
  "Password2" =>  urlencode($inject),
  "submit" =>  urlencode("Create Account"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Account Registration Form";
  $formName = "my account registration";
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
  "customer_country" => urlencode($inject),
  "customer_phone_parts[one]" =>  urlencode("'\*'"),
  "customer_phone_parts[two]" =>  urlencode("'\*'"),
  "customer_phone_parts[three]" =>  urlencode("'\**'"),
  "customer_email_address" =>  urlencode($injectEmail),
  "Submit" => urlencode(""),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Checkout Form";
  $formName = "checkout";
  $this->validateStatusCode($url,$content,$formName);

}

public function checkoutPayment(){
  $url = $this -> configPageUrl["addpaymentoption"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "credit-card-number" =>  urlencode("$inject"),
  "expiration-month" =>  urlencode("$inject"),
  "expiration-year" =>  urlencode("$inject"),
  "cvv" =>  urlencode("$inject"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate checkoutpayment form";
  $formName = "checkout payment";
  $this->validateStatusCode($url,$content,$formName);

}

public function myaccount_address(){
  $url = $this -> configPageUrl["addaddress"];
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
  "addr_phone1" =>  urlencode($inject),
  "addr_phone2" =>  urlencode($inject),
  "addr_phone3" =>  urlencode($inject),
  "Save" =>  urlencode("Save Changes"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate my account Add Address Form";
  $formName = "Myaccount add address";
  $this->validateStatusCode($url,$content,$formName);

}

public function myaccount_change_password(){
  $url = $this -> configPageUrl["changepassword"];
  $inject = $this -> configInjection["sql-inject"];
  $fields = array(
  "first_name" =>  urlencode($inject),
  "last_name" =>  urlencode($inject),
  "old_password" =>  urlencode("usap1q2w"),
  "new_password1" =>  urlencode($inject),
  "new_password2" =>  urlencode($inject),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Myaccount Change Password Form";
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
  "ymm_submit" =>  urlencode("Start Shopping"),

  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Myaccount Add Vehicles Form";
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
  // "sign_in_button" =>  urlencode("Sign In"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Checkout Sign In email";
  $formName = "checkout sign in";
  $this->validateStatusCode($url,$content,$formName);

}

public function rma(){
  $url = $this -> configPageUrl["rma"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "OrderNumber" =>  urlencode($inject),
  "OrderedPartNumber[]" =>  urlencode($inject),
  "ReturnType[]" =>  urlencode("Others"),
  "DetailedDescriptionOfIssue[]" => urlencode($inject),
  "Name" =>  urlencode($inject),
  "CustomerEmail" =>  urlencode($injectEmail),
  "ContactNumber" =>  urlencode($inject),
  "PurchaseDate" =>  urlencode($inject),
  "year" =>  urlencode($inject),
  "make" =>  urlencode($inject),
  "model" =>  urlencode($inject),
  // "submodel" =>  urlencode($inject),
  // "engine" =>  urlencode($inject),
  "Submit" => urlencode("SUBMIT RETURN REQUEST"),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Checkout RMA Form";
  $formName = "RMA";
  $this->validateStatusCode($url,$content,$formName);

}

public function feedback(){
  $url = $this -> configPageUrl["feedback"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "comment_topic" =>  urlencode("Broken link"),
  "comments" =>  urlencode($inject),
  "email" =>  urlencode($injectEmail),
  "buttonFeedback" => urlencode($inject),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Feeback Form";
  $formName = "feedback";
  $this->validateStatusCode($url,$content,$formName);

}

public function contact(){
  $url = $this -> configPageUrl["contactus"];
  $inject = $this -> configInjection["sql-inject"];
  $injectEmail = $this -> configInjection["email-inject"];
  $fields = array(
  "name" =>  urlencode($inject),
  "message" =>  urlencode($inject),
  "phone" => urlencode($inject),
  "email" => urlencode($inject),
  "department" => urlencode($inject),
  "key" => urlencode($inject),
  "part_num" => urlencode($inject),
  );
  $content = $this->loadCurlHeader($url ,$fields , "-");
  echo "\n\nValidate Contact Us";
  $formName = "contact us";
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
     echo "\nHTTP Status- PASSED - " . $httpStatus;
     echo "\n" . $url;
     $actual = "true";
     $this->writeReport($scenario, $expected, $actual,$httpStatus,$formName);
     // return $httpStatus;
     // $this->back();
     $this->pass++;

   }else{
     // $timestamp = strtotime('now');
     // $screenshotFile = $timestamp . ".png";
     // $this -> createScreenshot($screenshotFile);
     echo "\nHTTP Status- FAILED - " . $httpStatus;
     echo "\n" . $url;
     $actual = "false";
     $this->writeReport($scenario, $expected, $actual,$httpStatus);
     $this->fail++;
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


 // public function onNotSuccessfulTest(Throwable $e) {
 //
 //     $this -> createScreenshot("thereIsError.png");
 //     echo $e -> getMessage() . "\n\n";
 //     echo $e -> getTraceAsString();
 // }
 //
 // public function createScreenshot($fileName = "fileNameNotSet.png") {
 //     $screenshotDir = __DIR__ . "/screenshots/";
 //     $base64 = base64_decode($this -> screenshot());
 //     file_put_contents($screenshotDir . $fileName, $base64);
 // }


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
