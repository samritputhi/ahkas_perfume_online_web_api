<?php

namespace App\Ahkas\Application\Cart\Exceptions;

use Exception;

class InvalidQtyOrder extends Exception
{
    public function __construct()
    {
        parent::__construct("Qty order must be greater than zero");
    }
}
