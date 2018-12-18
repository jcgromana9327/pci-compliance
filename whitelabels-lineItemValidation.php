
<?php

class MySeleniumSuite extends PHPUnit_Extensions_Selenium2TestCase {

    public function setUp() {

        $this -> configHost = require __DIR__ . "/config/host.php";
        $this -> configEnvironment = require __DIR__ . "/config/environment.php";
        $this -> configUserAgent = require __DIR__ . "/config/userAgent.php";
        $this -> configWindowSize = require __DIR__ . "/config/windowSize.php";
        $this -> templateHeader = require __DIR__ . "/template/bootstrap.php";
        $this -> setHost($this -> configHost["host"]);
        $this -> setBrowser("chrome");
        $this -> setPort($this -> configHost["port"]);
        $this -> setBrowserUrl($this -> configEnvironment["dev"]);
        // $this->setSeleniumServerRequestsTimeout(300);
        $this -> assertTrue(true);
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
        $this -> setDesiredCapabilities($param);
        $this -> filename = __DIR__ . "/reports/cpo-test-result.html";
        // $this -> filename = __DIR__ . "/reports/ca.cp-test-result.html";
        // $this -> filename = __DIR__ . "/reports/ca.jcw-test-result.html";
        $this -> fp = fopen($this -> filename, 'w');
        $data = 'PT origin environment' .$this -> templateHeader["lineItem-header"];

        fwrite($this->fp, $data);
    }

    public function testApi() {

        $this -> validateCatalogService();
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

/* ##################################################################################### */

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

    public function homepage(){
    sleep(5);
     $expected = "present";
     $search = "#Ntt";
     $search = $this->byCssSelector($search);
     // sleep(5);

     if ($search->displayed() == true) {
         $actual = "present";
         // echo "\nSearch Textbox is present: PASSED";
         // $this->createScreenshot("homepage.png");
         $search->clear();
         $search->value("bolts");
         // $popularParts->value("discountautomirrors");
     } else {
         $actual = "not present";
         echo "\nSearch Textbox is missing: FAILED";
        $this->createScreenshot("Error.png");
      }


      $goButton = "#searchGo";
      $elementButton = $this->byCssSelector($goButton);
      if ($elementButton->displayed() == true) {
         // echo "\nSearch button is present: PASSED";
      } else {
         echo "\nSearch button is missing: FAILED";
     }

     $elementButton->click();
     sleep(5);
     $currentUrl = $this->url();
     $partname = str_replace("http://canadapartsonline.staging.usautoparts.com/search/?Ntt=", "", $currentUrl);
     $this->serp($partname);
    }
      public function serp($partname){
      // sleep(3);
      $scenario = "Check if " .$partname. " is added to cart";
      $expected = $partname;
      $elementSku = '#GridBuyBoxs > div.widgetMid > div.mid > div > div:nth-child(4) > div.productDetailsHolder > div > div.productMainDescriptionHolder > div.priceSummaryBox > div > form > div:nth-child(2)';
      $sku = $this->byCssSelector($elementSku);
      if ($sku->displayed() == true) {
        $screenshot = "-";
        $actual = $partname;
        $sku->click();
        // $timestamp = strtotime('now');
        // $screenshotFile = $timestamp . ".png";
        // $this -> createScreenshot($screenshotFile);
        // $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        //
        echo "\n" . $partname. " is added to cart";
      } else {
        $actual = $partname. " is not added to cart";
        $timestamp = strtotime('now');
        $screenshotFile = $timestamp . ".png";
        $this -> createScreenshot($screenshotFile);
        $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        echo "\n" . $partname. " is not added to cart";
      }
      $this->writeReport($scenario, $expected, $actual, $screenshot);
      // $sku->click();
      // sleep(5);
       }

       public function pdp(){

         $addToCart = "##GridBuyBoxs > div.widgetMid > div.mid > div > div:nth-child(4) > div.productDetailsHolder > div > div.productMainDescriptionHolder > div.priceSummaryBox > div > form > div:nth-child(2) > div > input";
         $addToCart = $this->byCssSelector($addToCart);
         if ($addToCart->displayed() == true) {
           $addToCart->click();
         } else {
           echo "\nMissing add to cart button";
         }
       }

       public function cart(){
          // sleep(2);
           $urlMain = "http://canadapartsonline.staging.usautoparts.com/search/?Ntt=";
           $urlArr = array(
             // $urlMain . "cornering light", // not available
             $urlMain . "Control Arm",
             $urlMain . "air filter",
             $urlMain . "a/c Compressor",
             $urlMain . "mirror",
             $urlMain . "mirror",
             $urlMain . "mirror",
             $urlMain . "mirror",
             $urlMain . "tail light",
             $urlMain . "wheels",
             $urlMain . "shock absorber",
             $urlMain . "bumper",
             $urlMain . "bumper",
             $urlMain . "bumper",
//20
             $urlMain . "A/C Condenser",
             $urlMain . "Alternator",
             $urlMain . "Axle Shaft",
             $urlMain . "Brake Caliper",
             $urlMain . "Brake Disc",
             $urlMain . "Brake Pad",
             $urlMain . "Catalytic Converter",
             $urlMain . "Clutch Kit",
             $urlMain . "Door Handle",
             $urlMain . "Exhaust Gasket",
//30
             $urlMain . "A/C Receiver Drier",
             $urlMain . "ACC Cabin Filter", // not available
             $urlMain . "Exhaust System",
             $urlMain . "Fender",
             $urlMain . "Floor Mats",
             $urlMain . "Fog Light",
             $urlMain . "Fuel Pump",
             $urlMain . "Grille Assembly",
             $urlMain . "Hood",
             $urlMain . "Ignition Coil",
//40
             $urlMain . "Intake Manifold Gasket",
             $urlMain . "Lift Strut",
             $urlMain . "Oil Filter",
             $urlMain . "Oxygen Sensor",
             $urlMain . "Radiator",
             $urlMain . "Tailgate Handle",
             $urlMain . "Spark Plug",
             $urlMain . "Splash Shield", // not available
             $urlMain . "Starter",
             $urlMain . "Suspension Bushings", // not available
//50
             $urlMain . "Timing Belt",
             $urlMain . "Vent Visor",
             $urlMain . "Water Pump",
             $urlMain . "Weatherstrip",
             $urlMain . "Wheel Cylinder",
             $urlMain . "Wheel Bearing",
             $urlMain . "Window Motor",
             $urlMain . "Window Regulator",
             $urlMain . "Wiper Blade",
             $urlMain . "Control Arm",
//60
             $urlMain . "Ball Joint",
             $urlMain . "Billet Grille",
             $urlMain . "Brake Hose",
             $urlMain . "Brake Master Cylinder",
             $urlMain . "Brake Shoe Set",
             $urlMain . "Bug Shield",
             $urlMain . "Bumper Bracket",
             $urlMain . "Bumper End",
             $urlMain . "Bumper Grille",
             $urlMain . "Bumper Reinforcement",
//70
             $urlMain . "Bumper Trim",
             $urlMain . "Clutch Kit",
             $urlMain . "Dash Trim",
             $urlMain . "Distributor Cap",
             $urlMain . "Distributor Rotor",
             $urlMain . "Emblem",
             $urlMain . "Engine Mount", // not available
             $urlMain . "Exhaust Manifold",
             $urlMain . "Exhaust Manifold Gasket Set",
             $urlMain . "Expansion Tank", // not available
//80
             $urlMain . "Fan Shroud",
             $urlMain . "Fender Flares",
             $urlMain . "Fuel Filter",
             $urlMain . "Fuel Tank Cap",
             $urlMain . "Header Panel", // not available
             $urlMain . "Headlight Assembly",
             $urlMain . "Headlight Bulb",
             $urlMain . "Headlight Door", // not available
             $urlMain . "Headlight Housing", // not available
             $urlMain . "Hood Lift",
//90
             $urlMain . "Ignition Coil",
             $urlMain . "Ignition Wire Set",
             $urlMain . "License Plate Bracket",
             $urlMain . "Lower Valance", // not available
             $urlMain . "Mirror Glass",
             $urlMain . "Mud Flaps",
             $urlMain . "Muffler",
             $urlMain . "Oil Pan Gasket Set",
             $urlMain . "Paper Repair Manual",
             $urlMain . "Park Light Assembly", // not available
//100
             $urlMain . "Radiator Hose",
             $urlMain . "Radiator Support",
             $urlMain . "Side Marker Assembly",
             $urlMain . "Strut Assembly",
             $urlMain . "Strut Mount",
             $urlMain . "Sway Bar Link Kit",
             $urlMain . "Tail Light Assembly",
             $urlMain . "Tailgate Cable",
             $urlMain . "Thermostat",
             $urlMain . "Tie Rod End",
//110
             $urlMain . "Trunk Strut",
             $urlMain . "Turn Signal Assembly", // not available
             $urlMain . "Valve Cover Gasket Set",
             $urlMain . "wax",
             $urlMain . "M4008216",
             $urlMain . "M4005701",
             $urlMain . "MEGM0664",
             $urlMain . "M4005724",
             $urlMain . "MEGG7014J",
             $urlMain . "M4005500",
//120
             $urlMain . "M4008100",
             $urlMain . "MEGG12718",
             $urlMain . "M4005550",
             $urlMain . "M4005750",
             $urlMain . "M4008224",
             $urlMain . "MEGA1214",
             $urlMain . "MEGA1216",
             $urlMain . "MEGA2216",
             $urlMain . "MEGG18211",
             $urlMain . "MEGG18216"


           );

           // $this->items = 1;
           foreach ($urlArr as $url){
             $this->url($url);
             $posUrl = strpos($this->url(), $urlMain);
             if ($posUrl !== false){
             $partname = str_replace("$urlMain", "", $url);
             $this->serp($partname);
            }
             // $this->pdp();

             // $this->items++;
           }
           // $itemCount = "";
           sleep(10);
           // $cartCount = "#HeaderCartv2 > div > small";
           // $cartCount = $this->byCssSelector($itemCount)->text();
           // echo $cartCount. "\n\n";

           $itemCount = $this->elements($this->using('css selector')->value('#formbasket .itemTable ul > li:not(.tablehead)'));
           // $itemCount = $this->byCssSelector("");
           $itemCount = count($itemCount);
           $scenario = "Check the total number of items";
           $expected = 99;
           if($itemCount <= $expected){
             $screenshot = "-";
             // $expected = $itemCount. " Line items" ;
             $actual = $itemCount;
             echo "\n\nTotal number of items added to cart- PASSED - " . $itemCount;
             $timestamp = strtotime('now');
             $screenshotFile = $timestamp . ".png";
             $this -> createScreenshot($screenshotFile);
             $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
             // echo "\n\nTotal number of items added to cart: " . $itemCount;
           }else{
             $expected = "less than or equal to 99 Line items";
             $actual = $itemCount;
             $timestamp = strtotime('now');
             $screenshotFile = $timestamp . ".png";
             $this -> createScreenshot($screenshotFile);
             $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
             echo "\n\nTotal number of items added to cart- FAILED - " . $itemCount;
           }
           $this->writeReport($scenario, $expected, $actual, $screenshot);


     }

    public function validateCatalogService() {



      try {
        $this->cookie()->clear();
        $this->url("/");
        $this->homepage();
        // $this->serp();
        // $this->pdp();
        $this->cart();
      } catch (Exception $e) {
          echo $e;
          // $date = date('m-d-Y_hia');
          $timestamp = strtotime('now');
          $screenshotFile = $timestamp . ".png";
          $this -> createScreenshot($screenshotFile);
      }


    }

    public function writeReport($scenario, $expected, $actual, $screenshot) {
        if (is_bool($expected) and ( $expected == true)) {
            $expected_text = "true";
        } elseif (is_bool($expected) and ( $expected == false)) {
            $expected_text = "false";
        } else {
            $expected_text = "Should add to cart " .$expected;
        }

        if (is_bool($actual) && ($actual == true)) {
            $actual_text = "true";
        } elseif (is_bool($actual) && ($actual == false)) {
            $actual_text = "false";
        } else {
            $actual_text = $actual. " is added to cart";
        }
        if ($expected == $actual) {
            $status = "Passed";
            $color = "#629632";
        } elseif ($actual <= $expected) {
            $status = "Passed";
            $color = "#629632";
        }
        else {
            $status = "Failed";
            $color = "#FF0000";
        }
        $data = '<tr>
                               <td>' . $scenario . '</td>
                               <td>' . $expected_text . '</td>
                               <td>' . $actual_text . '</td>
                               <td><b><font color =' . $color . '>' . $status . '</font></b></td>
                               <td>' . $screenshot . '</td>
                             </tr>';

        fwrite($this->fp, $data);
    }

    public function loadCurl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, "10.10.70.150:8080");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1 usap_selenium');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

}

?>
