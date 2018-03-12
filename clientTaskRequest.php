<?php
    session_start();

    //log user in before proceeding
    if (!isset($_SESSION['username']))
    {
        echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
        exit();
    }
    else
    {
        require_once('navigation.php');
        require_once('header.php');
    }
    require_once('vendor/autoload.php');
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    //default guzzle client
    $client = new GuzzleHttp\Client(['auth' => [$username, $password]]);
    $url = "http://localhost/RESTfulPHP/WebServices/taskService.php";

    //1. REQUEST TO CREATE RECORD
    if (isset($_POST['create']) && !empty($_POST['create']))
    {
        $desc = $_POST['create'];
        try
        {
            $response = $client->request("POST", $url,
                [
                    'form_params'=>
                    [
                        'desc'=> $desc,
                    ]
                ]);
            $response_body = $response->getBody();
        }
        catch (RequestException $ex)
        {
            echo "HTTP Request failed\n<br/><pre>";
            print_r($ex->getRequest());
            echo "</pre>";

            if ($ex->hasResponse())
            {
                echo $ex->getResponse();
            }
        }

        echo "Here is the Task Service HTTP POST Response with the description = $desc<br/>";
        echo "<pre>";
        echo $response_body;
        echo "</pre>";
    }
    //2. REQUEST TO READ ALL RECORDS
    if (isset($_POST['readAll']) && !empty($_POST['readAll']))
    {
        try
        {
            $response = $client->request("GET", $url);
            $response_body = $response->getBody();
        }
        catch (RequestException $ex)
        {
            echo "HTTP Request failed\n<br/><pre>";
                print_r($ex->getRequest());
            echo "</pre>";
            if ($ex->hasResponse())
            {
                echo $ex->getResponse();
            }
        }
        echo "Here is the Task Service HTTP GET (READ ALL RECORDS) Response:<br/>";
        echo "<pre>";
        echo $response_body;
        echo "</pre>";
        //echo $decoded_body;
    }

    //3. REQUEST READ BY ID
    if (isset($_POST['readOne']) && !empty($_POST['readOne']))
    {
        $readOne = $_POST['readOne'];
        try
        {
            $response = $client->request("GET", $url, ['query'=>['id'=>$readOne]]);
            $response_body = $response->getBody();
        }
        catch (RequestException $ex)
        {
            echo "HTTP Request failed\n<br/><pre>";
            print_r($ex->getRequest());
            echo "</pre>";

            if ($ex->hasResponse())
            {
                echo $ex->getResponse();
            }
        }

        echo "Task Service HTTP GET Response with an ID:<br/>";
        echo "<pre>";
        echo $response_body;
        echo "</pre>";
    }

    //4. REQUEST TO UPDATE a record with ID and description
    if (isset($_POST['updateDesc']) && !empty($_POST['updateDesc']))
    {
        $id = $_POST['updateID'];
        $desc = $_POST['updateDesc'];

        try
        {
            $response = $client->request("PUT", $url,
                [
                'form_params'=>
                [
                    'id' => $id,
                    'desc' => $desc,
                ]
                ]);

            $response_body = $response->getBody();
        }
        catch (RequestException $ex)
        {
            echo "HTTP Request failed\n<br/><pre>";
            print_r($ex->getRequest());
            echo "</pre>";

            if ($ex->hasResponse())
            {
                echo $ex->getResponse();
            }
        }
        echo "Task Service HTTP PUT Response with id=$id, desc=$desc <br/>";
        echo "<pre>";
        echo $response_body;
        echo "</pre>";
    }
    //5. DELECT a record with an ID
    if (isset($_POST['deleteID']) && !empty($_POST['deleteID']))
    {
        $deleteID = $_POST['deleteID'];
        try
        {
            $response = $client->request("DELETE", $url,
                [
                    'form_params'=>
                    [
                        'id' => $deleteID
                    ]
                ]);
            $response_body = $response->getBody();
        }
        catch (RequestException $ex)
        {
            echo "HTTP Request failed\n<br/><pre>";
            print_r($ex->getRequest());
            echo "</pre>";
            if ($ex->hasResponse())
            {
                echo $ex->getResponse();
            }
        }
        echo "Task Service HTTP DELETE Response with id=$deleteID:<br/>";
        echo "<pre>";
        echo $response_body;
        echo "</pre>";
    }
?>
