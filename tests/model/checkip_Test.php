<?php

/**
 * Copyright Fumito MIZUNO
 * Lisence: MIT
 */

/**
 * checkip class Tests
 *
 * @group checkip
 */
class checkip_Test extends TestCase
{
    protected $class;
    function setup()
    {
        $id_ip_list = array(
            '1' => array('127.0.0.1', '192.168.56.101'),
            '2' => array('127.0.0.1', '192.168.33.10'),
        );
        $this->class = new Model_Checkip();
        $this->class->setCheckArray($id_ip_list);
    }

    function test_OK()
    {
        $actual = $this->class->validateUser('1', '192.168.56.101');
        $this->assertTrue($actual);
    }

    function test_notOK()
    {
        $actual = $this->class->validateUser('2', '192.168.56.101');
        $this->assertFalse($actual);
    }

    function test_invalid_user()
    {
        $actual = $this->class->validateUser('-1', '127.0.0.1');
        $this->assertFalse($actual);
    }

    function test_default_false()
    {
        $actual = $this->class->validateUser('3', '127.0.0.1');
        $this->assertFalse($actual);
    }

    function test_default_true()
    {
        $this->class->setDefaultValue('yes');
        $actual = $this->class->validateUser('3', '127.0.0.1');
        $this->assertTrue($actual);
    }
}