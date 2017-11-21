<?php

namespace Drutiny\Http\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;

abstract class Http extends Audit {

  protected function getHttpResponse(Sandbox $sandbox)
  {
    $url = $sandbox->getParameter('url');
    $method = $sandbox->getParameter('method', 'GET');
    $options = $sandbox->getParameter('options', []);

    $status_code = $sandbox->getParameter('status_code');

    $client = new \GuzzleHttp\Client();
    return $client->request($method, $url, $options);
  }
}


 ?>
