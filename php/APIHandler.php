<?php
    class APIHandler {
        function getUsers() {
            $postfields = array(
                "goAction" => "goGetAllUsers"
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getDailyPresence() {
            $postfields = array(
                "goAction" => "goGetDailyPresence"
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function getNews() {
            $postfields = array(
                "goAction" => "goGetNews"
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

        function editUser($user_id = NULL, $username = NULL, $name = NULL, $email = NULL) {
            $postfields = array(
                "goAction" => "goEditUser",
                "user_id" => $user_id,
                "username" => $username,
                "name" => $name,
                "email" => $email
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

        function getMonthlyPresence() {
            $postfields = array(
                "goAction" => "goGetMonthlyPresence"
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function siteURL() {
            $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
            $domainName = $_SERVER['HTTP_HOST'].'/';
            return $protocol.$domainName;
        }

        function API_Request($folder = NULL, $postfields = NULL) {
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