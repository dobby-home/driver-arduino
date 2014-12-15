<?php defined('SYSPATH') or die('No direct script access.');

class Driver_Arduino extends Dobby_Driver {


    public function getValue($address) {

        $addr = $this->parseAddress($address);
        $value = null;
        if ($addr[0] == 'http') {
            if (!isset($addr[2])){
                Kohana::$log->add(LOG::ERROR, 'UNKNOWN ADDRESS "'.$address.'"');
            }
            $url = 'http://' . $addr[1] . '/get' . ucfirst($addr[2]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $value = curl_exec($ch);

            $error = curl_error($ch);
            if (!empty($error)) {
                throw new Exception($error);
            }
            curl_close($ch);
        } else {
            Kohana::$log->add(LOG::ERROR, 'UNKNOWN ADDRESS "'.$address.'"');
        }
        return $value;
    }


    public function setValue($address, $value) {

        $addr = $this->parseAddress($address);
        if ($addr[0] == 'http') {
            if (!isset($addr[2])){
                Kohana::$log->add(LOG::ERROR, 'UNKNOWN ADDRESS "'.$address.'"');
            }
            $url = 'http://' . $addr[1] . '/set' . ucfirst($addr[2]) . ':' . $value;
            var_dump($url);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $res = curl_exec($ch);

            $error = curl_error($ch);
            if (!empty($error)) {
                throw new Exception($error);
            }
            curl_close($ch);
        } else {
            Kohana::$log->add(LOG::ERROR, 'UNKNOWN ADDRESS "'.$address.'"');
        }
    }
}