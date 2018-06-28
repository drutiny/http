<?php

namespace Drutiny\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Drutiny\Cache\LocalFsCacheItemPool as Cache;
use Drutiny\Container;

class Client extends GuzzleClient {
  public function __construct(array $config = [])
  {
    if (!isset($config['handler'])) {
        $config['handler'] = HandlerStack::create();
    }

    // Logging HTTP Requests.
    $logger = Middleware::log(
        Container::getLogger(),
        new MessageFormatter(__CLASS__ . " HTTP Request\n\n{req_headers}\n\n{res_headers}")
    );
    $config['handler']->push($logger);

    // Cache HTTP responses. Add to the bottom so other cache
    // handlers take priority if present.
    $config['handler']->unshift(cache_middleware(), 'cache');

    parent::__construct($config);
  }
}

function cache_middleware()
{
  static $middleware;
  if ($middleware) {
    return $middleware;
  }
  $cache = new Cache('http');
  $storage = new Psr6CacheStorage($cache);
  $middleware = new CacheMiddleware(new PrivateCacheStrategy($storage));
  return $middleware;
}

?>
