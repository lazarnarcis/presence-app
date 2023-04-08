<?php
    class APIHandler {
        function getUsers() {
            $postfields = array(
                "goAction" => "goGetAllUsers.php"
            );
            return $this->API_Request("goUsers", $postfields);
        }

        function getDailyPresence() {
            $postfields = array(
                "goAction" => "goGetDailyPresence.php"
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function getMonthlyPresence() {
            $postfields = array(
                "goAction" => "goGetMonthlyPresence.php"
            );
            return $this->API_Request("goPresence", $postfields);
        }

        function siteURL() {
            $protocol = 'http://';
            $domainName = $_SERVER['HTTP_HOST'].'/';
            return $protocol.$domainName;
        }

        function API_Request($folder = NULL, $postfields = NULL) {
            $url = $this->siteURL()."presence-app/goAPI";
            error_log($url);
            foreach ($postfields as $key => $value) {
                if ($key == "goAction") {
                    $url .= "/".$folder."/".$value;
                } else {
                    $url .= "?".$key."=".$value;
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