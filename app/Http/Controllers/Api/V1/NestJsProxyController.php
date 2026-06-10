<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NestJsProxyController extends Controller
{
    public function __invoke(Request $request, string $path = '')
    {
        $base = rtrim(config('services.nestjs.url'), '/');
        $target = $base.'/api/v1/'.ltrim($path, '/');

        if ($request->getQueryString()) {
            $target .= '?'.$request->getQueryString();
        }

        $forward = Http::withHeaders($this->forwardHeaders($request))
            ->withBody($request->getContent(), $request->header('Content-Type', 'application/json'));

        $response = $forward->send(strtoupper($request->method()), $target);

        return response($response->body(), $response->status())
            ->withHeaders(array_filter([
                'Content-Type' => $response->header('Content-Type'),
            ]));
    }

    /**
     * @return array<string, string>
     */
    private function forwardHeaders(Request $request): array
    {
        $headers = [];

        foreach (['Accept', 'Content-Type', 'X-Requested-With', 'X-CSRF-TOKEN'] as $name) {
            $value = $request->header($name);
            if ($value !== null && $value !== '') {
                $headers[$name] = $value;
            }
        }

        return $headers;
    }
}
