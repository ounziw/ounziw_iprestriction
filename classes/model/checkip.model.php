<?php

/**
 * Copyright Fumito MIZUNO
 * Lisence: MIT
 */
namespace Ounziw\Iprestriction;

class Model_Checkip extends \Fuel\Core\Model
{
    protected $check_array = array();
    protected $default_value = false;
    public function setCheckArray($array)
    {
        if (is_array($array))
        {
            $this->check_array = $array;
        }
    }
    public function setDefaultValue($bool)
    {
        $this->default_value = filter_var($bool,FILTER_VALIDATE_BOOLEAN);
    }
    public function validateUser($user_id, $ip)
    {
        // user_id : interger and >= 1
        $options = array(
            'options' => array(
                'min_range' => 1,
            )
        );
        if (!filter_var($user_id, FILTER_VALIDATE_INT,$options))
        {
            return false;
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP))
        {
            return false;
        }

        if (!is_array($this->check_array))
        {
            return (bool) $this->default_value;
        }

        if (!array_key_exists($user_id, $this->check_array))
        {
            return (bool) $this->default_value;
        }

        if (in_array($ip, (array)$this->check_array[$user_id]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}