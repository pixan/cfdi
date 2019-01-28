<?php
namespace Pixan\Cfdi;

class TimbradorExpressService implements StampServiceInterface
{

  const DEVELOPMENT_ENDPOINT  = 'https://dev.advans.mx/ws/awscfdi.php?wsdl';
  const PRODUCTION_ENDPOINT   = 'https://ws33.advans.mx/ws/awscfdi.php?wsdl';

  public function stamp($xml){
    // Call web service
    $client = new \SoapClient(config('cfdi.sandbox') ? self::DEVELOPMENT_ENDPOINT : self::PRODUCTION_ENDPOINT);
    $params = [
      'credential'  => config('cfdi.drivers.timbrador.API_KEY'),
      'cfdi'        => $xml
    ];

    $response = $client->__soapCall('timbrar', $params);
    if(intval($response->Code) !== 200){
      // Abort, repsonse was not successful
      abort(400, $response->Code.(!empty($response->SubCode) ? "-".$response->SubCode : "").": ".$response->Message);
    }

    $finalXml = new \DomDocument;
    $finalXml->loadXML($xml);
    $complementoNode = $finalXml->getElementsByTagName('Complemento');
    if($complementoNode->length == 0){
      // Create node and save
      $newNode = $finalXml->createElement("cfdi:Complemento");
      $finalXml->documentElement->appendChild($newNode);
    }
    $complementoNode = $finalXml->getElementsByTagName('cfdi:Complemento')->item(0);

    $stampXml = new \DomDocument;
    $stampXml->loadXML($response->Timbre);

    $complementoNode->appendChild(
      $finalXml->importNode($stampXml->documentElement, TRUE)
    );

    return $finalXml->saveXML();
  }

}
