<?php

include "./partials/_dbconnect.php";
session_start();

$email = "";
$userId;

if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
    header("Location: /barca-academy/login.php");
}

if (isset($_SESSION['userEmail'])) {
    $email = $_SESSION['userEmail'];
}


$sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($result);

if ($numRows == 1) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['user_id'];
}

$plan = "";
$price = "";
$subscription = false;
$subscription = false;
$checkSubscribed = false;

if (isset($_POST['basic'])) {
    $plan = "Basic";
    $price = (int)$_POST['basic'];
    $_SESSION['price'] = $price;
}

if (isset($_POST['standard'])) {
    $plan = "Standard";
    $price = (int)$_POST['standard'];
    $_SESSION['price'] = $price;
}
if (isset($_POST['special'])) {
    $plan = "Special";
    $price = (int)$_POST['special'];
    $_SESSION['price'] = $price;
}


if (isset($_POST['cardHolder'])) {
    $sql = "SELECT * FROM subscription WHERE userId='$userId'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    if ($numRows >= 1) {
        $checkSubscribed = true;
    }else{
        $cardholderName = $_POST['cardHolder'];
        $price = $_SESSION['price'];
        $sql = "INSERT INTO `subscription` (`cardholder_name`, `price`, `userId`) VALUES ('$cardholderName', '$price', '$userId')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $subscription = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing | Barca Academy</title>
    <link rel="stylesheet" href="/barca-academy/pricing.css">
</head>

<body>
    <div class="screen flex-center">
        <?php
        if ($checkSubscribed) {
            echo "<h2>User has already subscribed</h2>";
        }
        ?>
        <form class="popup flex p-lg" action="/barca-academy/pricing.php" method="post">

            <!-- CARD FORM -->
            <div class="flex-fill flex-vertical">
                <div class="header flex-between flex-vertical-center">
                    <div class="flex-vertical-center">
                        <i class="ai-bitcoin-fill size-xl pr-sm f-main-color"></i>
                        <span class="title">
                            <strong>Barca</strong><span>Pay</span>
                        </span>
                    </div>
                </div>
                <div class="card-data flex-fill flex-vertical">

                    <!-- Card Number -->
                    <div class="flex-between flex-vertical-center">
                        <div class="card-property-title">
                            <strong>Card Number</strong>
                            <span>Enter 16-digit card number on the card</span>
                        </div>
                        <div class="f-main-color pointer"><?php echo $plan . " plan: " . "Rs." . $price; ?></div>
                    </div>

                    <!-- Card Field -->
                    <div class="flex-between">
                        <div class="card-number flex-vertical-center flex-fill">
                            <div class="card-number-field flex-vertical-center flex-fill">


                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px">
                                    <path fill="#ff9800" d="M32 10A14 14 0 1 0 32 38A14 14 0 1 0 32 10Z" />
                                    <path fill="#d50000" d="M16 10A14 14 0 1 0 16 38A14 14 0 1 0 16 10Z" />
                                    <path fill="#ff3d00" d="M18,24c0,4.755,2.376,8.95,6,11.48c3.624-2.53,6-6.725,6-11.48s-2.376-8.95-6-11.48 C20.376,15.05,18,19.245,18,24z" />
                                </svg>



                                <!--
<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path fill="#F44336" d="M33 11A13 13 0 1 0 33 37A13 13 0 1 0 33 11Z"/><path fill="#2196F3" d="M28,24h-8c0-0.682,0.068-1.347,0.169-2h7.661c-0.105-0.685-0.255-1.354-0.464-2h-6.732c0.225-0.694,0.508-1.362,0.84-2h5.051c-0.369-0.709-0.804-1.376-1.293-2h-2.465c0.379-0.484,0.79-0.941,1.233-1.367c-0.226-0.218-0.455-0.432-0.696-0.633c-2.252-1.872-5.146-3-8.304-3C7.82,11,2,16.82,2,24s5.82,13,13,13c3.496,0,6.664-1.388,9-3.633c0.443-0.426,0.854-0.883,1.232-1.367h-2.465c-0.489-0.624-0.923-1.291-1.293-2h5.051c0.333-0.638,0.616-1.306,0.841-2h-6.732c-0.209-0.646-0.358-1.315-0.464-2h7.661C27.932,25.347,28,24.682,28,24z"/></svg>
                -->

                                <!--
<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path fill="#1565C0" d="M45,35c0,2.209-1.791,4-4,4H7c-2.209,0-4-1.791-4-4V13c0-2.209,1.791-4,4-4h34c2.209,0,4,1.791,4,4V35z"/><path fill="#FFF" d="M15.186 19l-2.626 7.832c0 0-.667-3.313-.733-3.729-1.495-3.411-3.701-3.221-3.701-3.221L10.726 30v-.002h3.161L18.258 19H15.186zM17.689 30L20.56 30 22.296 19 19.389 19zM38.008 19h-3.021l-4.71 11h2.852l.588-1.571h3.596L37.619 30h2.613L38.008 19zM34.513 26.328l1.563-4.157.818 4.157H34.513zM26.369 22.206c0-.606.498-1.057 1.926-1.057.928 0 1.991.674 1.991.674l.466-2.309c0 0-1.358-.515-2.691-.515-3.019 0-4.576 1.444-4.576 3.272 0 3.306 3.979 2.853 3.979 4.551 0 .291-.231.964-1.888.964-1.662 0-2.759-.609-2.759-.609l-.495 2.216c0 0 1.063.606 3.117.606 2.059 0 4.915-1.54 4.915-3.752C30.354 23.586 26.369 23.394 26.369 22.206z"/><path fill="#FFC107" d="M12.212,24.945l-0.966-4.748c0,0-0.437-1.029-1.573-1.029c-1.136,0-4.44,0-4.44,0S10.894,20.84,12.212,24.945z"/></svg>
                -->

                                <input class="numbers" type="number" min="1" max="9999" placeholder="0000">-
                                <input class="numbers" type="number" placeholder="0000">-
                                <input class="numbers" type="number" placeholder="0000">-
                                <input class="numbers" type="number" placeholder="0000" data-bound="carddigits_mock" data-def="0000">
                            </div>
                            <i class="ai-circle-check-fill size-lg f-main-color"></i>
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div class="flex-between">
                        <div class="card-property-title">
                            <strong>Expiry Date</strong>
                            <span>Enter the expiration date of the card</span>
                        </div>
                        <div class="card-property-value flex-vertical-center">
                            <div class="input-container half-width">
                                <input class="numbers" data-bound="mm_mock" data-def="00" type="number" min="1" max="12" step="1" placeholder="MM">
                            </div>
                            <span class="m-md">/</span>
                            <div class="input-container half-width">
                                <input class="numbers" data-bound="yy_mock" data-def="01" type="number" min="23" max="99" step="1" placeholder="YY">
                            </div>
                        </div>
                    </div>

                    <!-- CCV Number -->
                    <div class="flex-between">
                        <div class="card-property-title">
                            <strong>CVC Number</strong>
                            <span>Enter card verification code from the back of the card</span>
                        </div>
                        <div class="card-property-value">
                            <div class="input-container">
                                <input id="cvc" type="password">
                                <i id="cvc_toggler" data-target="cvc" class="ai-eye-open pointer"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="flex-between">
                        <div class="card-property-title">
                            <strong>Cardholder Name</strong>
                            <span>Enter cardholder's name</span>
                        </div>
                        <div class="card-property-value">
                            <div class="input-container">
                                <input id="name" name="cardHolder" data-bound="name_mock" data-def="Mr. Cardholder" type="text" class="uppercase" placeholder="CARDHOLDER NAME">
                                <i class="ai-person"></i>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="action flex-center">
                    <button type="submit" <?php if($checkSubscribed) echo "disabled"; ?> class="b-main-color pointer">
                        <?php
                        if ($checkSubscribed) {
                            echo "Already Subscribed";
                        } else {
                            if ($subscription) {
                                echo "Subscription added";
                            } else {
                                echo "Pay Now";
                            }
                        }
                        ?>
                    </button>
                </div>
            </div>


    </div>
    </div>

    <script>
        /* COPY INPUT VALUES TO CARD MOCKUP */
        const bounds = document.querySelectorAll('[data-bound]');

        for (let i = 0; i < bounds.length; i++) {
            const targetId = bounds[i].getAttribute('data-bound');
            const defValue = bounds[i].getAttribute('data-def');
            const targetEl = document.getElementById(targetId);
            bounds[i].addEventListener('keyup', () => targetEl.innerText = bounds[i].value || defValue);
        }


        /* TOGGLE CVC DISPLAY MODE */
        const cvc_toggler = document.getElementById('cvc_toggler');

        cvc_toggler.addEventListener('click', () => {
            const target = cvc_toggler.getAttribute('data-target');
            const el = document.getElementById(target);
            el.setAttribute('type', el.type === 'text' ? 'password' : 'text');
        });
    </script>
</body>

</html>