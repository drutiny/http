<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpHeaderExists extends Http {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    $res = $this->getHttpResponse($sandbox);
    if ($has_header = $res->hasHeader($sandbox->getParameter('header'))) {
        $headers = $res->getHeader($sandbox->getParameter('header'));
        $sandbox->setParameter('header_value', $headers[0]);
    }
    return $has_header;
  }
}


 ?>
