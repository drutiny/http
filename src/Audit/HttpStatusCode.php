<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpStatusCode extends Http {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    $res = $this->getHttpResponse($sandbox);
    return $status_code == $res->getStatusCode();
  }
}


 ?>
