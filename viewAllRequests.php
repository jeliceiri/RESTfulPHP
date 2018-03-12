<?php
        session_start();

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
        $results = NULL;
        $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");
        $sql =  "SELECT user,
            SUM(IF(created=1,1,0)) as created,
            SUM(IF(readId=1,1,0)) as readId,
            SUM(IF(readAll=1,1,0)) as readAll,
            SUM(IF(updated=1,1,0)) as `update`,
            SUM(IF(deleted=1,1,0)) as `delete`

            from userRequests
            GROUP BY user
            ";

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try
        {
            $query = $db->prepare($sql);
            $query->execute();

            echo '<table>';
            echo '<tr><th>USER</th>';
            echo '<th>Created</th>';
            echo '<th>ReadById</th>';
            echo '<th>ReadAll</th>';
            echo '<th>Updated</th>';
            echo '<th>Deleted</th></tr>';

            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>';
                $username = $row['user'];
                echo '<td>';
                echo $username;
                echo '</td>';
                $create = $row['created'];
                echo '<td>';
                echo $create;
                echo '</td>';
                $readId = $row['readId'];
                echo '<td>';
                echo $readId;
                echo '</td>';
                $readAll = $row['readAll'];
                echo '<td>';
                echo $readAll;
                echo '</td>';
                $update = $row['update'];
                echo '<td>';
                echo $update;
                echo '</td>';

                $delete = $row['delete'];
                echo '<td>';
                echo $delete;
                echo '</td>';
                echo '</tr>';
            }
        }
        catch (Exception $ex)
        {
            echo "{$ex->getMessage()}<br/>";
        }
?>
