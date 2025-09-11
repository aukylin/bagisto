# 性能优化最佳实践

## 🎯 字体优化

### 策略选择
| 场景 | 推荐策略 |
|------|----------|
| 生产环境，网络稳定 | `cdn` |
| 生产环境，网络不稳定 | `local` |
| 开发环境 | `hybrid` |

### 实施步骤
```bash
# 本地化字体
./scripts/fonts/localize-fonts.sh

# 验证配置
php scripts/fonts/verify-fonts.php

# 更新配置
echo "FONT_STRATEGY=local" >> .env
```

## 🚀 前端优化

### 资源加载
```html
<!-- 关键CSS预加载 -->
<link rel="preload" href="/css/critical.css" as="style">

<!-- 字体预加载 -->
<link rel="preload" href="/fonts/files/poppins-400.woff2" as="font" type="font/woff2" crossorigin>

<!-- 图片懒加载 -->
<img src="image.webp" loading="lazy" alt="描述">
```

### JavaScript优化
```javascript
// 防抖搜索
const debounce = (func, wait) => {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => func(...args), wait);
  };
};

// 动态导入
const loadModule = async () => {
  const { default: Module } = await import('./module.js');
  return new Module();
};
```

## 🗄️ 后端优化

### 数据库
```php
// 预加载关联
$products = Product::with(['categories', 'images'])->get();

// 查询缓存
$categories = Cache::remember('categories', 3600, function () {
    return Category::all();
});
```

### HTTP缓存
```php
// 响应缓存
return response($content)
    ->header('Cache-Control', 'public, max-age=3600')
    ->header('ETag', md5($content));
```

## 📊 性能监控

### 关键指标
```javascript
// Core Web Vitals
new PerformanceObserver((entryList) => {
  for (const entry of entryList.getEntries()) {
    console.log('LCP:', entry.startTime);
  }
}).observe({entryTypes: ['largest-contentful-paint']});
```

### 字体监控
```javascript
document.fonts.ready.then(() => {
  console.log('字体加载完成');
});
```

## 🎯 性能目标

| 指标 | 目标值 |
|------|--------|
| LCP | < 2.5s |
| FID | < 100ms |
| CLS | < 0.1 |
| 字体加载 | < 1s |

## 📋 检查清单

### 部署前
- [ ] 字体策略配置
- [ ] 静态资源压缩
- [ ] 图片优化
- [ ] 缓存配置

### 定期检查
- [ ] Core Web Vitals
- [ ] 字体加载时间
- [ ] 数据库性能
- [ ] 缓存命中率