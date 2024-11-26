<?php

namespace App\Services;
class LogService
{
    function printInsideTheService()
    {
        var_dump("COOKED");
    }
}

class VehicleService
{
    public function __construct(){
        $this->logService = new LogService();
    }
    function printInsideTheService()
    {
        $this->logService->printInsideTheService();
        var_dump("We are using the functions inside the service");
    }
}


?>