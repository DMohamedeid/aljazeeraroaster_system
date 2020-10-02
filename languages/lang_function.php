<?php

    function pr($str, $exit_tag = 0, $ex = false){
        if ($ex == true) {
            \print_r(\var_export($str));
        } else {
            echo '<meta charset="UTF-8"><pre style="direction: ltr;text-align: left;color:#000;border: 1px #b1b1b1 dashed;background-color: #ddffe4;text-shadow: 0px 0px 1px #ffffff;border-radius: 4px;display: block;clear: both;z-index: 90;position: relative;width: 99%;margin: 4px auto;overflow-y: scroll;word-break: break-word;padding: 4px 8px;">';
            \print_r($str);
            echo '</pre>';
        }

        if ($exit_tag != 0) {
            exit();
        }
    }

    $base_url = "http://aljazeeraroastery.com/";

    $lang_cookie = 'en';
    if (isset($_COOKIE['site_lang'])) {
        $lang_cookie = $_COOKIE['site_lang'];
    }

    if ($lang_cookie == "ar") {
        include('languages/ar.php');
    } else {
        include('languages/en.php');
    }
    function lang($lang_key = ''){
        global $site_lang;
        return (isset($site_lang[$lang_key]) == true) ? $site_lang[$lang_key] : $lang_key;
    }

    function ChangeLanguage(){
        global $base_url;
        if (!empty(\trim($_GET['change_lang']))) {
            $change_lang = ($_GET['change_lang'] == 'en' ? 'en' : 'ar');
            setcookie("site_lang", $change_lang, time() + 60 * 60 * 24 * 2, '/');
            \Redirect($base_url, 1);
            exit();
        }
        return false;
    }

    function GetLang($name = ''){
        global $lang_cookie;
        return ($lang_cookie == 'en') ? $name . '_en' : $name . '_ar';
    }

    /**
     *
     * @param type $array_data [
     * to => ?,
     * subject => ?,
     * message => ?,
     * ]
     * @return boolean
     */
    function SendMail($array_data = []){
        $to = '';
        $subject = '';
        $message = '';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'User-Agent: Roundcube Webmail/' . phpversion();
        $headers[] = 'X-Sender: admin@aljazeeraroastery.com';
        $headers[] = 'From: Aljazeera Roastery  aljazeeraroastery@aljazeeraroastery.com';
        $headers[] = 'Reply-To: admin@aljazeeraroastery.com';
        $headers = implode("\r\n", $headers);
        if (is_array($array_data)) {
            if (isset($array_data['to'])) {
                $to = $array_data['to'];
            }
            if (isset($array_data['subject'])) {
                $subject = $array_data['subject'];
            }
            if (isset($array_data['message'])) {
                $message = \preg_replace('/\n/iUs', '<br>', $array_data['message']);
            }
            return mail($to, $subject, $message, $headers);
        } else {
            return false;
        }
    }

    function Redirect($url = '', $time = 0){
        global $base_url;
        $header_type = true;
        $header_list = [];
        if (\headers_sent()) {
            $header_type = false;
        }

        if (isset($url) && !empty($url)) {
            if (\strtolower($url) == 'goback') {
                if (\intval($time) > 0) {
                    $header_list['refresh'] = $time . ";url=" . $_SERVER['HTTP_REFERER'];
                } else {
                    $header_list['Location'] = $_SERVER['HTTP_REFERER'];
                }
            } else {
                $parse_url = \parse_url($url);
                if (!isset($parse_url['scheme'])) {
                    if (!empty($parse_url['path']) && \preg_match('/\./iUs', $parse_url['path'])) {
                        $url = 'http://' . $parse_url['path'];
                    } else {
                        $url = $base_url . $url;
                    }
                }
                if (\intval($time) > 0) {
                    $header_list['refresh'] = $time . ";url=" . $url;
                } else {
                    $header_list['Location'] = $url;
                }
            }
        } else {
            $header_list['Location'] = $base_url;
        }
        if (\count($header_list) > 0) {
            foreach ($header_list as $key => $value) {
                if ($header_type) {
                    \header($key . ':' . $value);
                } else {
                    echo '<meta http-equiv = "' . $key . '" content = "' . $value . '">';
                }
            }
        }
        return true;
    }
