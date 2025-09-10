<?php

namespace Webkul\Shop\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BrowserLocaleDetection
{
    /**
     * Handle an incoming request.
     *
     * This middleware detects browser language preferences for first-time visitors
     * and works in conjunction with Bagisto's built-in Locale middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only detect browser language for first-time visitors without locale parameter
        if (! session()->has('locale') && ! $request->has('locale')) {
            $browserLocale = $this->getBestMatchingLocale($request);

            if ($browserLocale) {
                // Redirect with locale parameter to let Bagisto's Locale middleware handle it
                $url = $request->fullUrl();
                $separator = strpos($url, '?') !== false ? '&' : '?';

                return redirect($url.$separator.'locale='.$browserLocale);
            }
        }

        return $next($request);
    }

    /**
     * Get the best matching locale from browser preferences.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    private function getBestMatchingLocale(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');

        if (empty($acceptLanguage)) {
            return null;
        }

        // Get supported locales from current channel
        $supportedLocales = $this->getSupportedLocales();

        if (empty($supportedLocales)) {
            return null;
        }

        // Parse Accept-Language header and get all languages with their weights
        $languages = $this->parseAcceptLanguage($acceptLanguage);

        // Sort by weight (descending)
        arsort($languages);

        // Try to match each language
        foreach ($languages as $lang => $weight) {
            // First try exact match (e.g., zh_CN)
            if (in_array($lang, $supportedLocales)) {
                return $lang;
            }

            // Then try language code match (e.g., zh matches zh_CN)
            $matchedLocale = $this->findLocaleByLanguageCode($lang, $supportedLocales);

            if ($matchedLocale) {
                return $matchedLocale;
            }
        }

        return null;
    }

    /**
     * Get supported locales from current channel.
     *
     * @return array
     */
    private function getSupportedLocales(): array
    {
        try {
            // Get supported locales from current channel
            $channel = core()->getCurrentChannel();

            return $channel ? $channel->locales->pluck('code')->toArray() : [];
        } catch (\Exception) {
            // Fallback to default supported locales if channel is not available
            return [
                'ar', 'bn', 'ca', 'de', 'en', 'es', 'fa', 'fr', 'he', 'hi_IN',
                'it', 'ja', 'nl', 'pl', 'pt_BR', 'ru', 'sin', 'tr', 'uk', 'zh_CN',
            ];
        }
    }

    /**
     * Parse Accept-Language header.
     *
     * @param  string  $acceptLanguage
     * @return array
     */
    private function parseAcceptLanguage(string $acceptLanguage): array
    {
        $languages = [];
        $locales = explode(',', $acceptLanguage);

        foreach ($locales as $locale) {
            $locale = trim($locale);

            if (strpos($locale, ';q=') !== false) {
                [$lang, $quality] = explode(';q=', $locale, 2);
                $quality = (float) $quality;
            } else {
                $lang = $locale;
                $quality = 1.0;
            }

            $lang = trim($lang);

            // Normalize locale format
            $lang = $this->normalizeLocale($lang);

            if ($lang) {
                $languages[$lang] = $quality;
            }
        }

        return $languages;
    }

    /**
     * Normalize locale format.
     *
     * @param  string  $locale
     * @return string|null
     */
    private function normalizeLocale(string $locale): ?string
    {
        if (empty($locale) || $locale === '*') {
            return null;
        }

        // Replace hyphens with underscores
        $locale = str_replace('-', '_', $locale);

        // Handle special formats like zh_CN, pt_BR
        if (strlen($locale) > 2) {
            $parts = explode('_', $locale);

            if (count($parts) === 2) {
                return strtolower($parts[0]).'_'.strtoupper($parts[1]);
            }
        }

        return strtolower($locale);
    }

    /**
     * Find locale by language code.
     *
     * @param  string  $languageCode
     * @param  array  $supportedLocales
     * @return string|null
     */
    private function findLocaleByLanguageCode(string $languageCode, array $supportedLocales): ?string
    {
        $languageCode = strtolower(substr($languageCode, 0, 2));

        foreach ($supportedLocales as $locale) {
            $localeLanguageCode = strtolower(substr($locale, 0, 2));

            if ($localeLanguageCode === $languageCode) {
                return $locale;
            }
        }

        return null;
    }
}