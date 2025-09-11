@props([
    'strategy' => config('fonts.strategy', 'cdn')
])

@php
    $fonts = config('fonts.fonts', []);
    $timeout = config('fonts.timeout', 3000);
@endphp

@if($strategy === 'cdn' || $strategy === 'hybrid')
    <!-- DNS预解析和预连接优化 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    @foreach($fonts as $font)
        <!-- 异步加载字体 -->
        <link
            rel="preload"
            href="{{ $font['cdn_url'] }}"
            as="style"
            onload="this.onload=null;this.rel='stylesheet'"
        >
        <noscript>
            <link rel="stylesheet" href="{{ $font['cdn_url'] }}">
        </noscript>
    @endforeach
    
    @if($strategy === 'hybrid')
        <!-- 字体加载超时处理 -->
        <script>
            (function() {
                const timeout = {{ $timeout }};
                const fallbackFonts = @json(config('fonts.fallback'));
                
                setTimeout(function() {
                    // 检查字体是否加载成功
                    const testElement = document.createElement('div');
                    testElement.style.fontFamily = 'Poppins, sans-serif';
                    testElement.style.position = 'absolute';
                    testElement.style.visibility = 'hidden';
                    testElement.innerHTML = 'Test';
                    document.body.appendChild(testElement);
                    
                    const computedFont = window.getComputedStyle(testElement).fontFamily;
                    document.body.removeChild(testElement);
                    
                    if (!computedFont.includes('Poppins')) {
                        // 字体加载失败，应用回退样式
                        const style = document.createElement('style');
                        style.textContent = `
                            body, * {
                                font-family: ${fallbackFonts['sans-serif']} !important;
                            }
                        `;
                        document.head.appendChild(style);
                        console.warn('Google Fonts failed to load, using system fonts');
                    }
                }, timeout);
            })();
        </script>
    @endif
    
@elseif($strategy === 'local')
    @foreach($fonts as $font)
        <link rel="stylesheet" href="{{ asset($font['local_path']) }}">
    @endforeach
@endif