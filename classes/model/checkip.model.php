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

        foreach ($this->check_array[$user_id] as $val)
        {
            if (strpos($val,'/') !== false)
            {
                if($this->check_ip_range($ip, $val))
                {
                    return true;
                }
            }
            else
            {
                if ($ip === $val)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function check_ip_range($ip, $val)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP))
        {
            return false;
        }
        if (strpos($val,'/') === false)
        {
            return false;
        }
        $checkip = explode('/',$val);
        if (!is_numeric($checkip[1]) || $checkip[1] < 1 || $checkip[1] > 32)
        {
            return false;
        }

        $ip_start = ip2long($checkip[0]);
        $ip_end = $ip_start + pow(2, 32-$checkip[1]) - 1;
        $options = array(
            'options' => array(
                'min_range' => $ip_start,
                'max_range' => $ip_end,
            )
        );
        if (filter_var(ip2long($ip), FILTER_VALIDATE_INT,$options))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}