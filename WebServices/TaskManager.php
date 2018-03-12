<?php
    require_once("ITaskManager.php");
    require_once("Task.php");

    class TaskManager implements ITaskManager
    {
        //CREATE a new record in database
        public function create($username, $desc)
        {
            $retVal = NULL;

            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $sql = "INSERT INTO tasks(`desc`) VALUES (:desc)";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            try
            {
                $query = $db->prepare($sql);
                $query->bindParam(":desc", $desc);
                $query->execute();

                $retVal = $db->lastInsertId();
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }

            // INSERT LOG INFO INTO DB userRequests table (CREATE)
            $create = 1;

            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO userRequests(`user`, `created`, `readId`, `readAll`, `updated`, `deleted`) VALUES (:username, :create, :readId, :readAll, :update, :delete)";

            try
            {
                $query = $db->prepare($sql);
                // ALternative syntax to bind parameters and execute query
                $query->execute(array(":username"=>$username, ":create"=>$create, ":readId"=>'0', ":readAll"=>'0',":update"=>'0', ":delete"=>'0'));
                //$query->execute();

                //echo $retVal;
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }

            return $retVal;
        }


        //READ by ID
        public function readById($username, $id)
        {
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM tasks WHERE id=:id";
            try
            {
                $query = $db->prepare($sql);
                $query->bindParam(":id", $id);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                $retVal = json_encode($results, JSON_PRETTY_PRINT);
            }
            catch(Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>\n";
            }

            //insert entry into tasks table
            $readId = 1;
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO userRequests(`user`, `created`, `readId`, `readAll`, `updated`, `deleted`) VALUES (:username, :create, :readId, :readAll, :update, :delete)";

            try
            {
                $query = $db->prepare($sql);
                $query->execute(array(":username"=>$username, ":create"=>'0', ":readId"=>$readId, ":readAll"=>'0',":update"=>'0', ":delete"=>'0'));
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }
            return $retVal;
        }

        //READ ALL
        public function read($username)
        {
            $retVal = NULL;

            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Read the id, desc for all records
            $sql = "SELECT * FROM tasks";

            try
            {
                $query = $db->prepare($sql);
                $query->execute();

                $results = $query->fetchAll(PDO::FETCH_ASSOC);

                $retVal = json_encode($results, JSON_PRETTY_PRINT);
            }
            catch(Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>\n";
            }

            // INSERT LOG INFO INTO TABLE readById
            $readAll = 1;

            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO userRequests(`user`, `created`, `readId`, `readAll`, `updated`, `deleted`) VALUES (:username, :create, :readId, :readAll, :update, :delete)";

            try
            {
                $query = $db->prepare($sql);
                // ALternative syntax to bind parameters and execute query
                $query->execute(array(":username"=>$username, ":create"=>'0', ":readId"=>'0', ":readAll"=>$readAll,":update"=>'0', ":delete"=>'0'));
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }
            return $retVal;
        }

        //UPDATE
        public function update($username, $id, $newDesc)
        {
            // Database type, Server, database, credentials: (user, password)
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");

            // Update a record
            $sql = "UPDATE tasks SET `desc`=:newDesc WHERE `id`=:id";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try
            {
                $query = $db->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":newDesc", $newDesc);
                $query->execute();
                $rowsAffected = $query->rowCount();
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }
            // INSERT LOG INFO INTO TABLE readById
            $update = 1;
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO userRequests(`user`, `created`, `readId`, `readAll`, `updated`, `deleted`) VALUES (:username, :create, :readId, :readAll, :update, :delete)";
            try
            {
                $query = $db->prepare($sql);
                // ALternative syntax to bind parameters and execute query
                $query->execute(array(":username"=>$username, ":create"=>'0', ":readId"=>'0', ":readAll"=>'0',":update"=>$update, ":delete"=>'0'));
                //$query->execute();

                //echo $retVal;
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }
            // Returns the number of rows UPDATED
            return $rowsAffected;
        }

        //DELETE A RECORD
        public function delete($username, $id)
        {
            // Database type, Server, database, credentials: (user, password)
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");

            // Delete a record
            $sql = "DELETE FROM tasks WHERE id=:id";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try
            {
                $query = $db->prepare($sql);
                $query->bindParam(":id", $id);
                $query->execute();
                $rowsAffected = $query->rowCount();
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }

            // INSERT LOG INFO INTO userRequests TABLE delete
            $delete = 1;
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO userRequests(`user`, `created`, `readId`, `readAll`, `updated`, `deleted`) VALUES (:username, :create, :readId, :readAll, :update, :delete)";
            try
            {
                $query = $db->prepare($sql);
                // ALternative syntax to bind parameters and execute query
                $query->execute(array(":username"=>$username, ":create"=>'0', ":readId"=>'0', ":readAll"=>'0',":update"=>'0', ":delete"=>$delete));
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
            }
            return $rowsAffected . ' row has been deleted'; // Returns the number of rows DELETED
        }
    }
?>
