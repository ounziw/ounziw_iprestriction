# Ip Restriction

Author: [Fumito Mizuno](http://twitter.com/ounziw)

IP Restriction allows you to restrict the logins.
You can define the list of IPs, the users are allowed to login only when his/her IP is on the list.
Each user has his/her own list of IPs.

##Installation

Copy the application into a folder 'local/application'
Activate this application in the admin area.

##Usage

You can define the list of IPs in config/id_ip.config.php

    return array(
        // user_id 1 can login from either 127.0.0.1 or 192.168.33.10
        '1' => array('127.0.0.1','192.168.33.10'),
    );

    return array(
        // user_id 1 can login from 127.0.0.1
        // user_id 2 can login from either 127.0.0.1 or 192.168.33.10
        '1' => array('127.0.0.1'),
        '2' => array('127.0.0.1','192.168.33.10'),
    );

If the user_id is not listed, he/she is allowed to login from everywhere.
If you want to reject the user who is not listed, edit bootstrap.php
    $class->setDefaultValue(false);

##Japanese Description
http://ounziw.com/2014/08/19/ip-restriction/
