<?php

    $successful = false;

    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
    {
        // Grab User name and password
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        // Database type, Server, database, credentials: (user, password)
        $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");

        // Insert a new record
        $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try
        {
            $query = $db->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":password", $password);
            $query->execute();

            $rowsAffected = $query->rowCount();
        }
        catch (Exception $ex)
        {
            echo "{$ex->getMessage()}<br/>";
        }

        // Returns the number of rows SELECTED
        if ($rowsAffected == 1)
        {
        $successful = TRUE;
        echo "You have been authenticated";
        echo "\r\n";
        }
    }

    if (!$successful)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="RESTful API CRUD"');
        exit('<h2>Sorry, you must enter a valid user name and password to access this page.</h2>');
    }
?>
