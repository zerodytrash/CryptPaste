<?php

if (isset($_GET["id"])) {
    require("./admin/config.php");
    try {

        if (isset($_GET["key"])) {
            $key = $_GET["key"];
            $mysql = new PDO("mysql:host=$mysql_host;dbname=$mysql_databasename", $mysql_username, $mysql_password);

            $stmt = $mysql->prepare("SELECT * FROM cryptpaste_pastes WHERE id = :id");
            $stmt->bindParam(":id", $_GET["id"]);
            $stmt->execute();
            $idcount = $stmt->rowCount();

            if ($idcount == 0) {
                echo "ID not found.";
                exit;
            }

            require("./lib/php/cryptolib.php");

            while ($row = $stmt->fetch()) {
                $stepOne = decrypt($row["encrypted_text"], $_GET["key"]);
            }
        } else {
            echo "Key is missing! Just put &key=YOURKEY at the end of the URL in the URL-Bar. That way we dont need to store anything and be 100% encrypted on our side.";
            exit;
        }
    } catch (PDOException $e) {
        echo "</br>" . $e;
        exit;
    }
} else {
    echo "ID not found.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./lib/js/aes.js"></script>

    <link rel="stylesheet" href="./lib/css/material.indigo-pink.min.css">
    <link rel="stylesheet" href="./lib/css/cryptpaste.css">
    <title>CryptPaste</title>
</head>

<body>

    <noscript>
        <h1 style="color: red;">This website only works with JavaScript!</h1>
        <h2 style="color: red">We first encrypt the text in your browser before it is processed by our web server.</h2>
    </noscript>

    <div class="mdl-layout content">
        <h6>Since we do not store keys ourselves, we have no way of knowing whether the key was correct or incorrect. If the field below is empty, the key will be wrong. If you see text below that makes sense, then the key was correct.</h6>
        <textarea name="result" id="result" cols="80" rows="30" disabled>If you can see this, then the decryption-key was wrong.</textarea>
        <script>
            var ciphertext = CryptoJS.AES.decrypt(<?php echo json_encode($stepOne) ?>, <?php echo json_encode($key) ?>);
            document.getElementById("result").value = ciphertext.toString(CryptoJS.enc.Utf8);
        </script>
        <a href="<?php echo $web_url ?>">Click here to upload your own encrypted Paste!</a>
        <a href="<?php require("./admin/config.php");
                    echo $imprint_url ?>">Imprint</a>
        <a href="<?php require("./admin/config.php");
                    echo $privacy_policy_url ?>">Privacy Policy</a>
    </div>
</body>

</html>
