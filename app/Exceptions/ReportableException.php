<?php


namespace App\Exceptions;

use Exception;

class ReportableException extends Exception
{
    public function render()
    {
        return response(['message'=>$this->getMessage()], 500);
    }

    public function report()
    {

    }
}

