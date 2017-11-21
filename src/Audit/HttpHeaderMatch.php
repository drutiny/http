<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpHeaderMatch extends Http {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    $value = $sandbox->getParameter('header_value');
    $res = $this->getHttpResponse($sandbox);
    $header = $sandbox->getParameter('header');

    if (!$res->hasHeader($header)) {
      return FALSE;
    }
    $headers = $res->getHeader($header);
    return $value == $headers[0];
  }
}


 ?>
