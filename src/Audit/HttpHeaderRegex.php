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
    return preg_match($regex, $res->getHeader($sandbox->getParameter('header')));
  }
}


 ?>
