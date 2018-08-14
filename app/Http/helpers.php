<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 12:21 PM
 */

/**
 * @param $email
 * @return bool
 */

function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}