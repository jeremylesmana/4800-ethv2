<li class="nav-item dropdown ">
    <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">
        <?php
        if (isset($_SESSION["loggedin"])) {
            echo $_SESSION["username"];
        };
        ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="profile.php"> View Profile </a></li>
        <li><a class="dropdown-item" href="logout.php"> Logout </a></li>
    </ul>
</li>