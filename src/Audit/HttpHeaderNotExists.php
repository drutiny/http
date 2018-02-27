<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;

class HttpHeaderNotExists extends HttpHeaderExists {

  /**
   *
   */
  public function audit(Sandbox $sandbox)
  {
    return !parent::audit($sandbox);
  }
}


 ?>
