<?php
    if (isset($_SESSION['username']))
    {
        echo '<ul>';
        echo '<li><a href="viewAllRequests.php">View All User Requests</a> &nbsp;</a></li>';
        echo '<li><a href="createRequest.html">Create A Request</a></li>';
        echo '<li><a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a></li>';
        echo '</ul>';
    }
    else
    {
        echo '<ul>';
        echo '<li><a href="login.php">Log In</a> &nbsp;</a></li>';
        echo '<li><a href="signup2.php">Sign Up</a></li>';
        echo '</ul>';
    }
    echo '<hr />';  
?>
