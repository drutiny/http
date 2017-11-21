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
    return $value == $res->getHeader($sandbox->getParameter('header'));
  }
}


 ?>
