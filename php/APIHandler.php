<?php
    class APIHandler {
        function getUsers() {
            $postfields = array(
                "goAction" => "goGetAllUsers"
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getDailyPresence($start_date = NULL, $end_date = NULL, $channel = NULL) {
            $postfields = array(
                "goAction" => "goGetDailyPresence",
                "start_date" => $start_date,
                "end_date" => $end_date,
                "channel" => $channel,
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function getDiscordMembers() {
            $postfields = array(
                "goAction" => "goGetDiscordMembers",
            );
            return $this->API_Request("goDiscord", $postfields);
        }

        function getUnauthorizedAccounts() {
            $postfields = array(
                "goAction" => "goGetUnauthorizedAccounts"
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getPublicHolidays() {
            $postfields = array(
                "goAction" => "goGetPublicHolidays"
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function authorizeUser($user_id = NULL, $session_user_id = NULL, $discord_user_id = NULL) {
            $postfields = array(
                "goAction" => "goAuthorizeUser",
                "user_id" => $user_id,
                "session_user_id" => $session_user_id,
                "discord_user_id" => $discord_user_id,
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function unauthorizeUser($user_id = NULL, $session_user_id = NULL) {
            $postfields = array(
                "goAction" => "goUnauthorizeUser",
                "user_id" => $user_id,
                "session_user_id" => $session_user_id
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getUserActivity($user = NULL) {
            $postfields = array(
                "goAction" => "goGetUserActivity",
                "user" => $user
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getHolidaysHistory($user = NULL, $session_user_id = NULL) {
            $postfields = array(
                "goAction" => "goGetHolidaysHistory",
                "user" => $user,
                "session_user_id" => $session_user_id
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getNews() {
            $postfields = array(
                "goAction" => "goGetNews"
            );
            return $this->API_Request("goNews", $postfields);
        }

        function getAllNews() {
            $postfields = array(
                "goAction" => "goGetAllNews"
            );
            return $this->API_Request("goNews", $postfields);
        }

        function updateNews($news = NULL, $session_user_name = null, $session_user_id = null) {
            $postfields = array(
                "goAction" => "goUpdateNews",
                "news" => $news,
                "session_user_name" => $session_user_name,
                "session_user_id" => $session_user_id,
            );
            return $this->API_Request("goNews", $postfields);
        }

        function loginUser($name = NULL, $password = NULL) {
            $postfields = array(
                "goAction" => "goLoginUser",
                "name" => $name,
                "password" => $password
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function forgotUser($name = NULL) {
            $postfields = array(
                "goAction" => "goForgotUser",
                "name" => $name,
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function changePasswordUser($uniqueid = NULL, $password = NULL) {
            $postfields = array(
                "goAction" => "goChangePasswordUser",
                "uniqueid" => $uniqueid,
                "password" => $password,
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getPasswordReset($uniqueid = NULL) {
            $postfields = array(
                "goAction" => "goGetPasswordReset",
                "uniqueid" => $uniqueid,
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function editUser($user_id = NULL, $username = NULL, $name = NULL, $email = NULL, $admin = NULL, $new_password = NULL, $discord_member = NULL) {
            $postfields = array(
                "goAction" => "goEditUser",
                "user_id" => $user_id,
                "username" => $username,
                "name" => $name,
                "email" => $email,
                "admin" => $admin,
                "password" => $new_password,
                "discord_member" => $discord_member
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getUserInfo($user_id = NULL) {
            $postfields = array(
                "goAction" => "goGetUserInfo",
                "user_id" => $user_id
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getDiscordRoles() {
            $postfields = array(
                "goAction" => "goGetUserRoles",
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function requestHolidays($reason = NULL, $holidays = [], $session_user_id = null, $session_user_name = null, $type = null) {
            $postfields = array(
                "goAction" => "goRequestHolidays",
                "reason" => $reason,
                "holidays" => json_encode($holidays),
                "session_user_id" => $session_user_id,
                "session_user_name" => $session_user_name,
                "type" => $type,
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function acceptDeclineHoliday($user_id = null, $year = null, $month = null, $day = null, $status = null, $session_user_id = null, $session_user_name = null) {
            $postfields = array(
                "goAction" => "goAcceptDeclineHoliday",
                "user_id" => $user_id,
                "year" => $year,
                "month" => $month,
                "day" => $day,
                "status" => $status,
                "session_user_id" => $session_user_id,
                "session_user_name" => $session_user_name,
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function getRequestHolidays($session_user_id = null, $admin = 0, $name = null) {
            $postfields = array(
                "goAction" => "goGetRequestHolidays",
                "session_user_id" => $session_user_id,
                "admin" => $admin,
                "name" => $name,
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function registerUser($name = NULL, $username = NULL, $email, $password = NULL) {
            $postfields = array(
                "goAction" => "goRegisterUser",
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "username" => $username
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getMonthlyPresence($start_date = NULL, $end_date = NULL, $channel = NULL) {
            $postfields = array(
                "goAction" => "goGetMonthlyPresence",
                "start_date" => $start_date,
                "end_date" => $end_date,
                "channel" => $channel,
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function siteURL() {
            $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
            $domainName = $_SERVER['HTTP_HOST'].'/';
            return $protocol.$domainName;
        }

        function API_Request($folder = NULL, $postfields = NULL) {
            if ((is_null($_SESSION) || count($_SESSION) == 0) && $postfields['goAction'] != "goLoginUser" && $postfields['goAction'] != "goRegisterUser" && $postfields['goAction'] != "goForgotUser" && $postfields['goAction'] != "goChangePasswordUser" && $postfields['goAction'] != "goGetPasswordReset") {
                $response = ['message' => "Please login to continue!"];
                echo json_encode($response);
                return;
            }
            $url = $this->siteURL();
            $whitelist = array('127.0.0.1', '::1');

            if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
                $url .= "presence-app/";
            }
            $url .= "goAPI";

            $limit = 0;
            foreach ($postfields as $key => $value) {
                if ($key == "goAction") {
                    $url .= "/".$folder."/".$value.".php";
                } else {
                    if ($limit == 0) {
                        $url .= "?".$key."=".urlencode($value);
                    } else {
                        $url .= "&".$key."=".urlencode($value);
                    }
                    $limit = 1;
                }
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
                exit;
            }
            curl_close($ch);
            $data = json_decode($response, true);
            return $data;
        }
    }
?>