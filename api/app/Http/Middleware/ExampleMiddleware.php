<?php

namespace App\Http\Middleware;

use Barryvdh\Cors\HandleCors;
use Closure;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExampleMiddleware extends HandleCors
{



    public function handle($request, Closure $next)
    {
        if (! $this->cors->isCorsRequest($request)) {
            return $next($request);
        }

        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->handlePreflightRequest($request);
        }

        if ($request->isMethod('OPTIONS')){
            return new LaravelResponse('Not allowed.', 403);
        }

        if (! $this->cors->isActualRequestAllowed($request)) {
            return new LaravelResponse('Not allowed.', 403);
        }

        // Add the headers on the Request Handled event as fallback in case of exceptions
        if (class_exists(RequestHandled::class)) {
            $this->events->listen(RequestHandled::class, function (RequestHandled $event) {
                $this->addHeaders($event->request, $event->response);
            });
        } else {
            $this->events->listen('kernel.handled', function (Request $request, Response $response) {
                $this->addHeaders($request, $response);
            });
        }

        $response = $next($request);

        return $this->addHeaders($request, $response);
    }

    protected function addHeaders(Request $request, Response $response)
    {
        // Prevent double checking
        if (! $response->headers->has('Access-Control-Allow-Origin')) {
            $response = $this->cors->addActualRequestHeaders($response, $request);
        }

        return $response;
    }

}
