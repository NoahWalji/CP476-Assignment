<ul class="nav justify-content-end">
    <li class="nav-item"><a class="nav-link active" href="/">Home</a>
    <?php
        $loggedIn = isset($_SESSION["loggedin"]) === true ? true : false;

        if ($loggedIn) {
        echo("<li class=\"nav-item dropdown\"><a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">My Account</a>");
        echo("<div class=\"dropdown-menu\"><a class=\"dropdown-item\" href=\"/settings\">Settings</a><a class=\"dropdown-item\" id=\"logoutButton\" href=\"#\">Logout</a></div></li>");
        }

        else {
        echo("<li class=\"nav-item\"><a class=\"nav-link active\" href=\"login\">Login</a>");
        }
    ?>
</ul>