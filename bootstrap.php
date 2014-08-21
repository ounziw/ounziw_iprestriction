<?php


/**
 * Copyright Fumito MIZUNO
 * Lisence: AGPL ver.3 or later
 */
namespace Ounziw\Iprestriction;

\Event::register('admin.loginSuccess', '\Ounziw\Iprestriction\disconnect_from_invalid_ip');
\Event::register('admin.loginSuccessWithCookie', '\Ounziw\Iprestriction\disconnect_from_invalid_ip');

// invalid ip user will be redirected
function disconnect_from_invalid_ip() {
    \Config::load('ounziw_iprestriction::id_ip', 'id');
    // IP check class
    $class = new \Ounziw\Iprestriction\Model_Checkip();
    $class->setCheckArray(\Config::get('id'));

    // true : if user_id is not present in Config, pass the user.
    $class->setDefaultValue(true);

    // user id
    $user = \Session::user();

    if (!$class->validateUser($user->user_id, \Input::ip()))
    {
        // You can override the default process.
        if (\Event::has_events('ounziw_iprestriction_invalid')) {
            \Event::trigger('ounziw_iprestriction_invalid');
        }
        else // Do default
        {
            \Log::warning('invalid access ID: ' . $user->user_id . ' IP: ' . \Input::ip());
            \Nos\Auth::disconnect();
            \Response::redirect('/');
        }
    }
}