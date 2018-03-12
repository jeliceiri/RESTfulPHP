<?php
    require_once("authorize.php");
    require_once("TaskManager.php");

    $httpVerb = $_SERVER['REQUEST_METHOD']; // POST, GET, PUT, DELETE

    //get username from SESSION
    $username = $_SERVER['PHP_AUTH_USER'];
    $taskManager = new TaskManager();

    switch ($httpVerb)
    {
        case "POST":
            // Create
             if  (isset($_POST['desc']))
            {
                //grab the description
                $desc = $_POST['desc'];
                echo "\r\n";
                echo "The newly created task id is: " . $taskManager->create($username, $desc);
            }
            else
            {
                throw new Exception("Invalid HTTP POST request parameters.");
            }
            break;

        case "GET"://read
            header("Content-Type: application/json");
            if (isset($_GET['id'])) // Read (by Id)
            {
                echo $taskManager->readById($username, $_GET['id']);
            }
            else //Read all
            {
                echo $taskManager->read($username);
            }
            break;

        case "PUT"://Update

            parse_str(file_get_contents("php://input"), $putVars);
            if (isset($putVars['id']) && isset($putVars['desc']))
            {
                $id = $putVars['id'];
                $newDesc = $putVars['desc'];
                echo $taskManager->update($username, $id, $newDesc);
            }
            else
            {
                throw new Exception("Invalid HTTP PUT request parameters.");
            }
            break;

        case "DELETE"://delete
            parse_str(file_get_contents("php://input"), $deleteVars);
            if (isset($deleteVars['id']))
            {
                $id = $deleteVars['id'];
                echo $taskManager->delete($username, $id);
            }
            else
            {
                throw new Exception("Invalid HTTP DELETE request parameters.");
            }
            break;

        default:
            throw new Exception("Unsupported HTTP request.");
            break;
    }
?>
