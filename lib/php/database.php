<?php

function setup()
{
    require("./admin/config.php");
    try {
        $mysql = new PDO("mysql:host=$mysql_host;dbname=$mysql_databasename", $mysql_username, $mysql_password);
        echo "Generating Table.. </br>";

        $stmt = $mysql->prepare("CREATE TABLE `cryptpaste_pastes` (
            `id` INT(255) NOT NULL AUTO_INCREMENT,
            `encrypted_text` VARCHAR(1000) NOT NULL,
            PRIMARY KEY (`id`)
        );");

        echo "Done creating Table! </br>";
        echo "Setup completed! </br> Thanks for using CryptPaste <3 </br>";

        $stmt->execute();
    } catch (PDOException $e) {
        echo "</br>" . $e;
    }

    $installerFile = "install.php";
    if (!unlink($installerFile)) {
        echo ("$file_pointer cannot be deleted due to an error. Please delete the install.php file yourself.");
    } else {
        echo ("$installerFile has been deleted!");
    }
}

function createPaste($text)
{
    require("./admin/config.php");
    try {
        $mysql = new PDO("mysql:host=$mysql_host;dbname=$mysql_databasename", $mysql_username, $mysql_password);
        $stmt = $mysql->prepare("INSERT INTO cryptpaste_pastes (encrypted_text) VALUES (:text)");
        $stmt->bindParam(":text", $text);
        $stmt->execute();

        $stmt = $mysql->prepare("SELECT * FROM cryptpaste_pastes WHERE encrypted_text = :text");
        $stmt->bindParam(":text", $text);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            echo "<h4>Use this URL to share the Paste: <a href='"  .  $web_url . "/view.php?id=" . $row["id"] . "'>" . $web_url . "/view.php?id=" . $row["id"] . "</a></h4>";
        }
    } catch (PDOException $e) {
        echo "</br>" . $e;
    }
}
