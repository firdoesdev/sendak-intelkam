<?php

namespace App\Services;

abstract class AccountServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public abstract function initAccount():void;

}
