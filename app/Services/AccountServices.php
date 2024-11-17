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

    protected abstract function createRole():void;
    protected abstract function additionalPermissions():array;
    public abstract function assignPermission() : void ;

    protected abstract function createMenu():void;

    public abstract function createAccount():void;

}
