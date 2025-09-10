<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     * 
     * 这个中间件专门处理首次访问时的浏览器语言检测
     * 与Bagisto内置的Shop\Http\Middleware\Locale中间件配合使用
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 只在首次访问且没有URL参数指定语言时进行浏览器语言检测
        if (!session()->has('locale') && !$request->has('locale')) {
            $browserLocale = $this->getBestMatchingLocale($request);
            
            if ($browserLocale) {
                // 通过重定向添加locale参数，让Bagisto的中间件处理
                $url = $request->fullUrl();
                $separator = strpos($url, '?') !== false ? '&' : '?';
                
                return redirect($url . $separator . 'locale=' . $browserLocale);
            }
        }

        return $next($request);
    }

    /**
     * 获取最佳匹配的语言
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

        // 获取当前渠道支持的语言
        $supportedLocales = $this->getSupportedLocales();
        
        if (empty($supportedLocales)) {
            return null;
        }

        // 解析Accept-Language头，获取所有语言及其权重
        $languages = $this->parseAcceptLanguage($acceptLanguage);

        // 按权重排序
        arsort($languages);

        // 尝试匹配每个语言
        foreach ($languages as $lang => $weight) {
            // 首先尝试完全匹配（如 zh_CN）
            if (in_array($lang, $supportedLocales)) {
                return $lang;
            }

            // 然后尝试语言代码匹配（如 zh 匹配 zh_CN）
            $matchedLocale = $this->findLocaleByLanguageCode($lang, $supportedLocales);
            if ($matchedLocale) {
                return $matchedLocale;
            }
        }

        return null;
    }

    /**
     * 获取当前渠道支持的语言列表
     *
     * @return array
     */
    private function getSupportedLocales(): array
    {
        try {
            // 获取当前渠道支持的语言
            $channel = core()->getCurrentChannel();
            return $channel ? $channel->locales->pluck('code')->toArray() : [];
        } catch (\Exception $e) {
            // 如果获取失败，返回默认支持的语言列表
            return [
                'ar', 'bn', 'ca', 'de', 'en', 'es', 'fa', 'fr', 'he', 'hi_IN',
                'it', 'ja', 'nl', 'pl', 'pt_BR', 'ru', 'sin', 'tr', 'uk', 'zh_CN'
            ];
        }
    }

    /**
     * 解析Accept-Language头
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
            
            // 标准化语言代码格式
            $lang = $this->normalizeLocale($lang);
            
            if ($lang) {
                $languages[$lang] = $quality;
            }
        }

        return $languages;
    }

    /**
     * 标准化语言代码格式
     *
     * @param  string  $locale
     * @return string|null
     */
    private function normalizeLocale(string $locale): ?string
    {
        if (empty($locale) || $locale === '*') {
            return null;
        }

        // 将连字符替换为下划线
        $locale = str_replace('-', '_', $locale);

        // 处理特殊格式
        if (strlen($locale) > 2) {
            $parts = explode('_', $locale);
            if (count($parts) === 2) {
                return strtolower($parts[0]) . '_' . strtoupper($parts[1]);
            }
        }

        return strtolower($locale);
    }

    /**
     * 根据语言代码查找匹配的locale
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