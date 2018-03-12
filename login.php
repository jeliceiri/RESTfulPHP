<?php
    session_start();

    $error_msg = "";

    if (!isset($_SESSION['username']))
    {
        if (isset($_POST['submit']))
        {
            $db = new PDO("mysql:host=localhost;dbname=project4", "root", "root");

            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT username, password FROM users WHERE username=:user AND password=:pswd";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            try
            {
                $query = $db->prepare($sql);
                $query->bindParam(":user", $username);
                $query->bindParam(":pswd", $password);
                $query->execute();

                $results = $query->fetch();

                $_SESSION['username'] = $results['username'];
                $_SESSION['password'] = $results['password'];
            }
            catch (Exception $ex)
            {
                echo "{$ex->getMessage()}<br/>";
                exit();
            }
        }
        else
        {
        //$error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
    }
    require_once('navigation.php');
    require_once('header.php');

    if (empty($_SESSION['username']))
    {
        echo '<p>' . $error_msg . '</p>';
?>
    <form class="container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
            <label for="password">Password:</label>
            <input type="password" name="password" />
        </fieldset>
        <input type="submit" value="Log In" name="submit" />
    </form>
<?php
    }
    else
    {
    echo('<p>You are logged in as ' . $_SESSION['username'] . '.</p>');
    }
?>
<?php
    require_once('footer.php');
?>
