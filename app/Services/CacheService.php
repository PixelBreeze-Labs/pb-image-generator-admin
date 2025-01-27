<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * Default cache duration in minutes
     */
    private const DEFAULT_DURATION = 60;

    /**
     * Get item from cache or store it
     */
    public function remember(string $key, callable $callback, int $duration = self::DEFAULT_DURATION)
    {
        try {
            return Cache::remember($key, now()->addMinutes($duration), $callback);
        } catch (\Exception $e) {
            Log::warning("Cache operation failed for key: {$key}", [
                'error' => $e->getMessage()
            ]);

            // If caching fails, just execute the callback
            return $callback();
        }
    }

    /**
     * Store item in cache
     */
    public function put(string $key, $value, int $duration = self::DEFAULT_DURATION): bool
    {
        try {
            return Cache::put($key, $value, now()->addMinutes($duration));
        } catch (\Exception $e) {
            Log::warning("Failed to store in cache: {$key}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get item from cache
     */
    public function get(string $key, $default = null)
    {
        try {
            return Cache::get($key, $default);
        } catch (\Exception $e) {
            Log::warning("Failed to retrieve from cache: {$key}", [
                'error' => $e->getMessage()
            ]);
            return $default;
        }
    }

    /**
     * Remove item from cache
     */
    public function forget(string $key): bool
    {
        try {
            return Cache::forget($key);
        } catch (\Exception $e) {
            Log::warning("Failed to remove from cache: {$key}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Clear entire cache
     */
    public function flush(): bool
    {
        try {
            return Cache::flush();
        } catch (\Exception $e) {
            Log::error("Failed to flush cache", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Generate cache key
     */
    public function generateKey(string $prefix, array $params = []): string
    {
        $paramString = empty($params) ? '' : '_' . md5(json_encode($params));
        return "{$prefix}{$paramString}";
    }

    /**
     * Remember forever
     */
    public function rememberForever(string $key, callable $callback)
    {
        try {
            return Cache::rememberForever($key, $callback);
        } catch (\Exception $e) {
            Log::warning("Cache forever operation failed for key: {$key}", [
                'error' => $e->getMessage()
            ]);
            return $callback();
        }
    }

    /**
     * Has cache key
     */
    public function has(string $key): bool
    {
        try {
            return Cache::has($key);
        } catch (\Exception $e) {
            Log::warning("Cache check failed for key: {$key}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}