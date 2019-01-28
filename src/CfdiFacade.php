
<?php
namespace Pixan\Cfdi;
use Illuminate\Support\Facades\Facade;
class CfdiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cfdi';
    }
}
