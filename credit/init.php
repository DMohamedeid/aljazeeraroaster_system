<?php
$response = array();
// include db connect class
require_once __DIR__ . '/../system/api/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");
?>
<html>
    <head>
        <style>
            .spinner {
                width: 40px;
                height: 40px;
                background-color: #333;

                margin: 100px auto;
                -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out;
                animation: sk-rotateplane 1.2s infinite ease-in-out;
            }

            @-webkit-keyframes sk-rotateplane {
                0% { -webkit-transform: perspective(120px) }
                50% { -webkit-transform: perspective(120px) rotateY(180deg) }
                100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
            }

            @keyframes sk-rotateplane {
                0% { 
                    transform: perspective(120px) rotateX(0deg) rotateY(0deg);
                    -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg) 
                } 50% { 
                    transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
                    -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg) 
                } 100% { 
                    transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
                    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
                }
            }
        </style>
    <div class="">Please wait...</div>

    <div class="spinner"></div>

    <?php
    $client_id = $_GET['client_id'];
    $amount = $_GET['amount'];
    $orderID = $_GET['orderID'];
    $ch = curl_init();
    // $orderID = mt_rand();
    curl_setopt($ch, CURLOPT_URL, 'https://credimax.gateway.mastercard.com/api/rest/version/52/merchant/E03957950/session');
    curl_setopt($ch, CURLOPT_USERPWD, 'merchant.E03957950' . ":" . '704977ae5dc1eebf5b0e5b083dd907ce');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"order": { "id": "' . $orderID . '", "currency": "BHD" }, "apiOperation": "CREATE_CHECKOUT_SESSION" ,"interaction": { "operation": "AUTHORIZE", "returnUrl": "http://emcan-group.com/library/completeCallback.php"}}');
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"order": { "id": "' . $orderID . '", "currency": "BHD" }, "apiOperation": "CREATE_CHECKOUT_SESSION" ,"interaction": { "operation": "PURCHASE"
            , "returnUrl": "https://aljazeeraroastery.com/credit/completeCallback.php?orderID=' . $orderID . '"}}');


    $result = curl_exec($ch);

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With';
    $headers[] = 'Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS';
    $headers[] = 'Access-Control-Allow-Origin: *';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if ($result === false) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    print_r("<pre>");
    print_r($result);
    print_r("<pre>");
    $result = json_decode($result);

    $ssID = $result->session->id;
    $successIndicator = $result->successIndicator;
    $version = $result->session->version;
    // echo 'fsfdfd'. $successIndicator;
    mysql_query("INSERT INTO `payment` VALUES (Null,'$client_id','$orderID','$ssID','$successIndicator','','credit','" . date("Y-m-d H:i:s") . "')");
    ?>

    <script src="https://credimax.gateway.mastercard.com/checkout/version/52/checkout.js"
            data-error="errorCallback"
            data-cancel="cancelCallback"
            >
    </script>

    <script type="text/javascript">
        function errorCallback(error) {
            console.log(JSON.stringify(error));

        }
        function cancelCallback() {
            console.log('Payment cancelled');
        }




        Checkout.configure({
            merchant: 'E03957950',
            session: {
                id: "<?php echo $ssID; ?>"
            },
            order: {
                amount: '<?php echo $amount; ?>',
                currency: 'BHD',
                description: 'Al-Jazeera Roastery',
                id: '<?php echo $orderID; ?>'
            },
            interaction: {
                operation: 'AUTHORIZE',
                merchant: {
                    name: 'ALJAZEERA',
                    address: {
                        line1: '200 Sample St',
                        line2: '1234 Example Town'
                    }
                }
            }
        });
        Checkout.showPaymentPage();
    </script>
<!--<input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />-->
<!--<input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />-->
</head>
</html>