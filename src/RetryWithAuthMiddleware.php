<?php
namespace Drutiny\Http;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Middleware that retries requests based on the boolean result of
 * invoking the provided "decider" function.
 */
class RetryWithAuthMiddleware
{
    /** @var callable  */
    private $nextHandler;

    /**
     * @param callable $nextHandler Next handler to invoke.
     */
    public function __construct(callable $nextHandler) {
        $this->nextHandler = $nextHandler;
    }

    /**
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return PromiseInterface
     */
    public function __invoke(RequestInterface $request, array $options)
    {

        $fn = $this->nextHandler;
        return $fn($request, $options)
            ->then(
                $this->onFulfilled($request, $options)
            );
    }

    private function onFulfilled(RequestInterface $request, array $options)
    {
        return function (ResponseInterface $response) use ($request, $options) {
            if (($response->getStatusCode() == 401) && $response->hasHeader('WWW-Authenticate')) {
              return $this->doRetry($request, $options, $response);
            }
            return $response;
        };
    }

    private function doRetry(RequestInterface $request, array $options, ResponseInterface $response = null)
    {
        $style = new SymfonyStyle(new ArgvInput(), new ConsoleOutput());
        $style->warning("HTTP request is blocked by HTTP Authorization: " . $request->getUri());
        $style->warning("Please provide the user name and password to access URI.");
        $username = $style->ask("Please provide the USERNAME for HTTP Authorization");
        $password = $style->ask("Please provide the PASSWORD for HTTP Authorization");
        return $this($request->withHeader('Authorization', 'Basic ' . base64_encode("$username:$password")), $options);
    }
}
