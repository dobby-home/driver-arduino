<?php defined('SYSPATH') or die('No direct script access.');

class Driver_Arduino extends Dobby_Driver {


    public function getValue($address) {

        $address = $this->parseAddress($address);
        $value = null;
        if ($address[0] == 'http') {

            $url = 'http://' . $address[1] . '/get' . ucfirst($address[2]);
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
        }
        return $value;
    }


    public function setValue($address, $value) {

        $address = $this->parseAddress($address);
        if ($address[0] == 'http') {

            $url = 'http://' . $address[1] . '/set' . ucfirst($address[2]) . ':' . $value;
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
        }
    }
}