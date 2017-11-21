<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpHeader extends Http {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    $res = $this->getHttpResponse($sandbox);
    return $res->hasHeader($sandbox->getParameter('header'));
  }
}


 ?>
