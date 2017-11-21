<?php

namespace Drutiny\Http\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;


abstract class Http extends Audit {

  protected function getHttpResponse(Sandbox $sandbox)
  {
    $url = $sandbox->getParameter('url', $sandbox->getTarget()->uri());
    $method = $sandbox->getParameter('method', 'GET');
    $options = $sandbox->getParameter('options', []);

    $status_code = $sandbox->getParameter('status_code');

    $stack = HandlerStack::create();
    $stack->push(
        Middleware::log(
            $sandbox->logger(),
            new MessageFormatter(__CLASS__ . " HTTP Request\n\n{req_headers}\n\n{res_headers}")
        )
    );

    $options['handler'] = $stack;

    $client = new \GuzzleHttp\Client($options);
    return $client->request($method, $url);
  }
}


 ?>
