<?php

namespace wdid;

require_once( 'Duck.class.php');

class Session extends Duck {
    public $username = '';
    public $passwordHashed = '';
    public $counter = 1;
    public $name = 'test_session_name';
}