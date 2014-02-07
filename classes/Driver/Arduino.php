<?php defined('SYSPATH') or die('No direct script access.');

class Driver_Arduino extends Dobby_Driver {


    public function getValue($address) {

        $address = $this->parseAddress($address);
        $value = null;
        if ($address[0] == 'http') {
            $value = file_get_contents('http://' . $address[1] . '/get' . ucfirst($address[2]));
        }
        return $value;
    }
}