<?php
namespace Pixan\Cfdi;
use Config;

class Cfdi
{

  protected $key;
  protected $certificate;
  protected $pem;

  const PROVIDERS = [
    'timbrador' => TimbradorExpressService::class,
    'forcogsa'  => ForcogsaService::class,
  ];

  public function __construct(array $config){

    // Config check
    if(!Config::has('cfdi')){
      abort(400, 'CFDI package configuration not found; config file has not been published');
    }
    if(!array_key_exists(config('cfdi.driver'), self::PROVIDERS)){
      abort(400, 'CFDI Driver \''.config('cfdi.driver').'\' does not exist or has not been implemented');
    }


    $this->pem = $config['pem'];
    $this->certificate = $config['certificate'];
  }

  public function seal($xml)
  {
    $xml = Cfdi::tidy($xml);

    $xsl = new \DomDocument;
    $xsl->load(__DIR__.'/xslt/cadenaoriginal_3_3.xslt');
    $xp = new \XsltProcessor();
    $xp->importStylesheet($xsl);

    libxml_use_internal_errors(true);

		$xml_doc = new \DomDocument;
		$xml_doc->strictErrorChecking = FALSE ;
		if($xml_doc->loadXML($xml) === false){
			// Abort, XML has errors

		}
		$xml_doc->saveXML();
    if (!($cadena = $xp->transformToXML($xml_doc))) {
      // Abort, error transforming to xslt
      die('abort');
    }

		$private_key = openssl_pkey_get_private($this->pem);
		openssl_sign($cadena, $signature, $private_key, OPENSSL_ALGO_SHA256);
    $seal = base64_encode($signature);
		return $seal;
  }

  public function stamp($xml)
  {
    $driver = self::PROVIDERS[config('cfdi.driver')];
    $stampService = new $driver;
    $xml = $stampService->stamp($xml);
    return Cfdi::tidy($xml);
  }

  static function tidy($xml)
  {
    $tidy = new \tidy();
		$xml = $tidy->repairString($xml, [
			'output-xml' => true,
			'input-xml' => true,
			'wrap' => 0,
			'literal-attributes' => true,
		], 'utf8');
    return $xml;
  }

  public function uuid($xml)
  {
    $xml = Cfdi::tidy($xml);
    $xml_doc = new \DomDocument;
    if($xml_doc->loadXML($xml) === false){
			// Abort, XML has errors
      $xml_doc = new \DomDocument;
        if($xml_doc->loadXML($xml) === false){
    			// Abort, XML has errors

    		}
    		$xml_doc->saveXML();
        return $xml_doc->getElementsByTagName('TimbreFiscalDigital')[0]->getAttribute('UUID');

		}
		$xml_doc->saveXML();
    return $xml_doc->getElementsByTagName('TimbreFiscalDigital')[0]->getAttribute('UUID');
  }
}
