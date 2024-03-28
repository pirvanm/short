<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlStoreRequest;
use App\Services\UrlService;

class UrlController extends Controller
{
    protected UrlService $service;

    public function __construct(UrlService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UrlStoreRequest $request)
    {
        try {
            $hash = $this->service->generateHash($request->validated('url'));
            return response()->json(['url' => url('/' . $hash)]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to shorten URL'], 400);
        }
    }
}
