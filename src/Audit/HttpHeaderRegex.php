<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpHeaderRegex extends Http {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    $regex = $sandbox->getParameter('regex');
    $regex = "/$regex/";
    $res = $this->getHttpResponse($sandbox);
    $header = $sandbox->getParameter('header');

    if (!$res->hasHeader($header)) {
      return FALSE;
    }
    $headers = $res->getHeader($header);
    return preg_match($regex, $headers[0]);
  }
}


 ?>
