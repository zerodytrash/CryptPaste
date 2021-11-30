<?php
require("./lib/php/cryptolib.php");
require("./lib/php/database.php");

$error = "";

if (isset($_POST["encryptedText"])) {
    if (isset($_POST["encryptedTextKey"])) {
        $cryptedTextStepOne = $_POST["encryptedText"];
        $encryptionKey = $_POST["encryptedTextKey"];
        $cryptedTextStepTwo = encrypt($cryptedTextStepOne, $encryptionKey);

        if (strlen($_POST["encryptedText"]) > 4) {
            if (strlen($_POST["encryptedTextKey"]) > 4) {
                createPaste($cryptedTextStepTwo);
                $error = "Paste has been uploaded.";
            } else {
                $error = "ERROR: Please use at least 5 Characters for the Key.";
            }
        } else {
            $error = "ERROR: Please use at least 5 Characters for the Text.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptPaste</title>

    <link rel="stylesheet" href="./lib/css/material.indigo-pink.min.css">
    <link rel="stylesheet" href="./lib/css/cryptpaste.css">
    <script src="./lib/js/aes.js"></script>


    <script>
        function process() {
            var key = document.getElementById("encryptionKey").value;
            var ciphertext = CryptoJS.AES.encrypt(document.getElementById("textInput").value, key);

            document.getElementById("encryptedText").value = ciphertext;
            document.getElementById("encryptedTextKey").value = key;
            document.processor.submit();
        }
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</head>

<body>

    <noscript>
        <h1 style="color: red;">This website only works with JavaScript!</h1>
        <h2 style="color: red">We first encrypt the text in your browser before it is processed by our web server.</h2>
    </noscript>

    <div class="content">
        <h4><?php echo $error ?></h4>
        <textarea class="mdl-textfield__input" type="text" name="textInput" id="textInput" placeholder="Paste your Text here"></textarea> <br>
        <input class="mdl-textfield__input" type="password" name="encryptionKey" id="encryptionKey" placeholder="Encryption key"> <br>
        <p>(Note: We do not store this key. If you lose it, your text is gone. Make sure you keep it safe!)</p> <br>
        <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="button" value="Encrypt" name="submitButton" onclick="process();">

        <form action="post.php" method="post" name="processor" id="processor">
            <input type="hidden" name="encryptedTextKey" id="encryptedTextKey" value="--">
            <input type="hidden" name="encryptedText" id="encryptedText" value="--">
        </form>
        <a href="<?php require("./admin/config.php");
                    echo $imprint_url ?>">Imprint</a>
        <a href="<?php require("./admin/config.php");
                    echo $privacy_policy_url ?>">Privacy Policy</a>
    </div>


</body>

</html>
