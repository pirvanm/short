<?php

namespace App\Services;
use App\Models\Url;
use Ariaieboy\LaravelSafeBrowsing\Facades\LaravelSafeBrowsing;

class UrlService
{
    public function generateHash(string $originalUrl): string
    {
        $this->isUrlSafe($originalUrl);

        $hash = substr(hash('sha256', $originalUrl),0,6);
 
        $url = Url::firstOrNew(
            ['original_url' => $originalUrl],
            ['hash' => $hash]
        );
         
        // Save the URL with its Hash Value
        $url->save();

        return $url->hash;
    }

    public function isUrlSafe(string $originalUrl): bool
    {
        $result = LaravelSafeBrowsing::isSafeUrl($originalUrl,true);

        if (!$result) {
            throw new \Exception('The URL is invalid');
        }

        return $result;
    }

    public function redirect(string $hash)
    {
        $url = Url::where('hash', $hash)->first();

        if (!$url) {
            abort(404);
        }
         
        $url->update([
            'clicks' => $url->clicks + 1
        ]);

        return $url;
    }
}