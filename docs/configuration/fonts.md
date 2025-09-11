# 字体配置

## ⚙️ 环境配置

### .env 设置
```env
FONT_STRATEGY=local    # cdn, local, hybrid
FONT_TIMEOUT=3000      # 超时时间（毫秒）
```

### 策略说明
- **local**: 本地字体文件
- **cdn**: Google Fonts CDN
- **hybrid**: CDN优先，失败回退

## 🔧 配置文件

### config/fonts.php
```php
return [
    'strategy' => env('FONT_STRATEGY', 'cdn'),
    'timeout' => env('FONT_TIMEOUT', 3000),
    
    'fonts' => [
        'poppins' => [
            'family' => 'Poppins',
            'cdn_url' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
            'local_path' => '/fonts/poppins-local.css',
        ],
        // 其他字体...
    ],
    
    'fallback' => [
        'sans-serif' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
    ],
];
```

## 🎨 使用方法

### Blade模板
```blade
<x-shop::fonts />
```

### CSS中使用
```css
.heading {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
}
```

## 📂 文件结构
```
public/fonts/
├── files/                    # 字体文件
├── poppins-local.css         # 本地CSS
├── inter-local.css
└── dm-serif-display-local.css
```

## 🔄 策略切换

### 切换到本地字体
```bash
./scripts/fonts/localize-fonts.sh
echo "FONT_STRATEGY=local" >> .env
php artisan config:clear
```

### 切换到CDN
```bash
echo "FONT_STRATEGY=cdn" >> .env
php artisan config:clear
```

## 🎯 添加新字体

1. 更新 `config/fonts.php`
2. 下载字体文件到 `public/fonts/files/`
3. 创建本地CSS文件

## 🔍 验证配置
```bash
# 检查当前配置
php artisan tinker
>>> config('fonts.strategy')

# 验证文件
php scripts/fonts/verify-fonts.php
```

## 🚨 故障排除

### 字体不显示
```bash
php scripts/fonts/verify-fonts.php
php artisan config:clear
```

### 配置不生效
```bash
php artisan config:clear
php artisan cache:clear
```