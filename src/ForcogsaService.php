<?php
namespace Pixan\Cfdi;

class ForcogsaService implements StampServiceInterface
{

  const DEVELOPMENT_ENDPOINT  = 'http://dev33.facturacfdi.mx/WSTimbradoCFDIService?wsdl';
  const PRODUCTION_ENDPOINT   = 'https://v33.facturacfdi.mx/WSTimbradoCFDIService?wsdl';

  public function __construct(){
    if(!config('cfdi.drivers.forcogsa.username', false) || !config('cfdi.drivers.forcogsa.password', false))
    {
      abort(400, "Credentials for Formas Digitales have not been set in configuration file");
    }
  }

  public function stamp($xml){
    // Call web service
    $client = new \SoapClient(config('cfdi.sandbox') ? self::DEVELOPMENT_ENDPOINT : self::PRODUCTION_ENDPOINT);

		$accesos = new \stdClass();
		$accesos->usuario = config('cfdi.drivers.forcogsa.username');
		$accesos->password = config('cfdi.drivers.forcogsa.password');
    $paramsTimbrado = new \stdClass();
    $paramsTimbrado->accesos = $accesos;
    $paramsTimbrado->comprobante = $xml;
		$rTimbrado = $client->TimbrarCFDI($paramsTimbrado);
    if(empty($rTimbrado->acuseCFDI->xmlTimbrado)){
      // Abort, repsonse was not successful
      abort(400, (!empty($rTimbrado->acuseCFDI->codigoError) ? $rTimbrado->acuseCFDI->codigoError.": " : "").$rTimbrado->acuseCFDI->error);
		}
    $finalXml = new \DomDocument;
    $finalXml->loadXML($rTimbrado->acuseCFDI->xmlTimbrado);
    return $finalXml->saveXML();
  }

}
