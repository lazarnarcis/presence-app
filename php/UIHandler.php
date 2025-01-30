<?php
    class UIHandler {
        function getNav() {
            $admin_links = NULL;
            $user_info = $GLOBALS['api']->getUserInfo($_SESSION['user_id']);
            $admin = $user_info['admin'];
            $curr_file = basename($_SERVER["SCRIPT_FILENAME"], '.php');
            $my_user_id = $_SESSION['user_id'];

            if ($admin > 0) {
                $admin_links .= '
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger '.(($curr_file == "admin") ? "active-btn" : "").'" href="admin.php">Admin</a>
                    </li>
                ';
            }
            $logo_name = "logo-1.png";
            if ($curr_file != "index") {
                $logo_name = "logo.png";
            }
            echo '<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
                <div class="container">
                    <a class="navbar-brand js-scroll-trigger" href="/">
                        <img class="img-fluid" src="images/'.$logo_name.'" alt="" />
                    </a>
                    <button class="navbar-toggler navbar-toggler-right" style="color: black; border: 1px solid black;" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        Menu
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav text-uppercase ml-auto">
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "index") ? "active-btn" : "").'" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "daily-presence") ? "active-btn" : "").'" href="daily-presence.php">Daily Presence</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "monthly-presence") ? "active-btn" : "").'" href="monthly-presence.php">Monthly Presence</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "holidays") ? "active-btn" : "").'" href="holidays.php">Holidays</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "public_holidays") ? "active-btn" : "").'" href="public_holidays.php">Public Holidays</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "profile") ? "active-btn" : "").'" href="profile.php?id='.$my_user_id.'">Profile</a>
                            </li>
                            '.$admin_links.'
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "news") ? "active-btn" : "").'" href="news.php">News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger '.(($curr_file == "logout") ? "active-btn" : "").'" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>';
        }
        function getFooter() {
            $admin_links = NULL;
            $user_info = $GLOBALS['api']->getUserInfo($_SESSION['user_id']);
            $admin = $user_info['admin'];
            $curr_file = basename($_SERVER["SCRIPT_FILENAME"], '.php');

            if ($admin > 0) {
                $admin_links .= '
                    <a href="admin.php">Admin</a>
                ';
            }

            $my_user_id = $_SESSION['user_id'];
            $version = $_ENV["VERSION"];
            echo '<div class="copyrights">
                    <div class="container">
                        <div class="footer-distributed">
                            <a href="index.php"><img src="images/logo-1.png" alt="" /></a>
                            <div class="footer-center">
                                <p class="footer-links">
                                    <a href="index.php">Home</a>
                                    <a href="daily-presence.php">Daily Presence</a>
                                    <a href="monthly-presence.php">Monthly Presence</a>
                                    <a href="holidays.php">Holidays</a>
                                    <a href="public_holidays.php">Public Holidays</a>
                                    <a href="profile.php?id='.$my_user_id.'">Profile</a>
                                    '.$admin_links.'
                                    <a href="news.php">News</a>
                                    <a href="logout.php">Logout</a>
                                </p>
                                <p class="footer-company-name">All Rights Reserved. &copy; 2024 - '.date("Y").' - Presence v'.$version.'</p>
                            </div>
                        </div>
                    </div><!-- end container -->
                </div><!-- end copyrights -->';
        }
    } 
?>