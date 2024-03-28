<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Services\UrlService;

class UrlController extends Controller
{
    protected UrlService $service;

    public function __construct(UrlService $service)
    {
        $this->service = $service;
    }

    public function __invoke(string $hash)
    {
        try {
            $url = $this->service->redirect($hash);

            return redirect($url->original_url);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'URL not found'
            ], 404);
        }
    }
}
