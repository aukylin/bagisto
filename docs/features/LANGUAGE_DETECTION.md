# Bagisto 浏览器语言自动检测功能

## 功能概述

这个功能为Bagisto添加了基于浏览器Accept-Language头的自动语言检测，与Bagisto内置的语言切换功能完美集成，为首次访问的用户提供更好的多语言体验。

## 功能特性

### 1. 智能浏览器语言检测
- **首次访问检测**: 仅在用户首次访问且未指定语言参数时触发
- **Accept-Language解析**: 智能解析浏览器发送的Accept-Language头
- **权重排序**: 根据浏览器语言偏好权重进行排序匹配
- **渠道语言限制**: 只匹配当前渠道支持的语言

### 2. 与Bagisto内置功能集成
- **无缝集成**: 与Bagisto的`Shop\Http\Middleware\Locale`中间件配合工作
- **URL参数兼容**: 通过重定向添加`?locale=xx`参数，使用Bagisto原生处理逻辑
- **Session管理**: 利用Bagisto现有的session存储机制
- **前端组件**: 使用Bagisto内置的`v-locale-switcher` Vue组件

### 3. 智能匹配算法
- **完全匹配**: 优先匹配完整的语言代码（如 zh_CN）
- **语言代码匹配**: 支持语言代码匹配（如 zh 匹配 zh_CN）
- **权重排序**: 按浏览器语言偏好权重排序
- **渠道限制**: 只在当前渠道支持的语言中匹配

## 技术实现

### 1. 浏览器语言检测中间件 (BrowserLocaleDetection)

位置: `packages/Webkul/Shop/src/Http/Middleware/BrowserLocaleDetection.php`

**核心功能:**
- 检测首次访问（无session且无URL参数）
- 解析Accept-Language头并匹配渠道支持的语言
- 通过重定向添加locale参数，交给Bagisto处理

**工作原理:**
```php
// 只在首次访问且没有URL参数时触发
if (!session()->has('locale') && !$request->has('locale')) {
    $browserLocale = $this->getBestMatchingLocale($request);
    
    if ($browserLocale) {
        // 重定向添加locale参数
        return redirect($url . '?locale=' . $browserLocale);
    }
}
```

### 2. Bagisto内置功能

**Shop\Http\Middleware\Locale** (Bagisto原生):
- 处理URL参数 `?locale=xx`
- 管理session存储
- 设置应用语言环境

**前端Vue组件** (Bagisto原生):
- `v-locale-switcher`: 语言切换下拉菜单
- 自动显示当前渠道支持的语言
- 点击切换时添加URL参数

## 中间件执行顺序

```
Shop中间件组执行顺序:
1. Theme → 设置主题
2. BrowserLocaleDetection → 检测首次访问，重定向添加locale参数  
3. Locale → 处理locale参数，设置语言
4. Currency → 设置货币
```

## 支持的语言

系统支持Bagisto的所有内置语言，具体取决于：
1. **渠道配置**: 在管理后台为每个渠道配置支持的语言
2. **语言文件**: `lang/` 目录下的语言文件夹

常见语言包括：
- Arabic (ar)
- Bengali (bn) 
- Catalan (ca)
- German (de)
- English (en)
- Spanish (es)
- Persian (fa)
- French (fr)
- Hebrew (he)
- Hindi (hi_IN)
- Italian (it)
- Japanese (ja)
- Dutch (nl)
- Polish (pl)
- Portuguese Brazil (pt_BR)
- Russian (ru)
- Sinhala (sin)
- Turkish (tr)
- Ukrainian (uk)
- Chinese Simplified (zh_CN)

## 安装配置

### 1. 中间件注册

中间件已注册到Shop包的中间件组，位置在 `packages/Webkul/Shop/src/Providers/ShopServiceProvider.php`：

```php
$router->middlewareGroup('shop', [
    Theme::class,
    BrowserLocaleDetection::class,  // 浏览器语言检测
    Locale::class,                  // Bagisto原生语言处理
    Currency::class,
]);

$router->aliasMiddleware('browser.locale', BrowserLocaleDetection::class);
```

### 2. 渠道语言配置

在Bagisto管理后台配置每个渠道支持的语言：
1. 进入 **Settings > Channels**
2. 编辑渠道
3. 在 **Locales** 部分选择支持的语言

## 使用方法

### 1. 自动检测（无需操作）
- 用户首次访问时自动检测浏览器语言
- 匹配成功则自动切换到对应语言
- 后续访问使用用户上次选择的语言

### 2. 手动切换语言

使用Bagisto内置的语言切换器：

```blade
<!-- 在模板中已经包含，通常在header中 -->
<v-locale-switcher></v-locale-switcher>
```

### 3. 程序化切换

```php
// 通过URL参数
$url = request()->fullUrl() . '?locale=zh_CN';

// 通过JavaScript
window.location.href = window.location.href + '?locale=zh_CN';
```

## 工作流程

```
用户首次访问
    ↓
检查是否有session['locale']? → 是 → 使用Bagisto原生逻辑
    ↓ 否
检查URL是否有?locale参数? → 是 → 使用Bagisto原生逻辑  
    ↓ 否
解析Accept-Language头
    ↓
匹配当前渠道支持的语言
    ↓
找到匹配? → 否 → 使用Bagisto原生逻辑（默认语言）
    ↓ 是
重定向添加?locale=xx参数
    ↓
Bagisto原生中间件处理
    ↓
设置语言并保存到session
```

## 测试验证

### 1. 浏览器测试
1. 清除浏览器cookies和session
2. 设置浏览器语言偏好
3. 访问网站首页
4. 验证是否自动切换到对应语言

### 2. 开发者工具测试
```bash
# 模拟不同的Accept-Language头
curl -H "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8" http://your-site.com
curl -H "Accept-Language: fr-FR,fr;q=0.9,en;q=0.8" http://your-site.com
```

### 3. 多渠道测试
1. 配置不同渠道支持不同语言
2. 测试在不同渠道下的语言检测
3. 验证只匹配当前渠道支持的语言

## 注意事项

### 1. 性能考虑
- 只在首次访问时触发，不影响后续请求性能
- 使用重定向方式，确保URL参数正确传递

### 2. SEO友好
- 通过URL参数方式，搜索引擎可以正确识别语言
- 保持与Bagisto原生SEO策略一致

### 3. 缓存兼容
- 与Bagisto的缓存机制完全兼容
- 不会影响页面缓存和静态资源缓存

### 4. 多渠道支持
- 自动获取当前渠道支持的语言列表
- 不会匹配到当前渠道不支持的语言

## 故障排除

### 1. 语言检测不工作
- 检查中间件是否正确注册
- 确认渠道配置了多种语言
- 验证浏览器发送了Accept-Language头

### 2. 重定向循环
- 确保Bagisto的Locale中间件正常工作
- 检查session配置是否正确

### 3. 语言不匹配
- 验证语言代码格式是否正确
- 确认语言文件夹存在于`lang/`目录
- 检查渠道是否配置了该语言

## Bagisto 架构集成

### 1. 包结构
按照Bagisto的包架构，中间件放置在Shop包中：
```
packages/Webkul/Shop/src/Http/Middleware/BrowserLocaleDetection.php
```

### 2. 服务提供者注册
在`ShopServiceProvider`中注册中间件：
```php
// 中间件组注册
$router->middlewareGroup('shop', [
    Theme::class,
    BrowserLocaleDetection::class,  // 在Locale之前执行
    Locale::class,
    Currency::class,
]);

// 别名注册
$router->aliasMiddleware('browser.locale', BrowserLocaleDetection::class);
```

### 3. 执行顺序
确保浏览器检测在Bagisto的Locale中间件之前执行，这样可以：
- 先检测浏览器语言偏好
- 通过重定向添加locale参数
- 让Bagisto原生中间件处理语言设置

## 扩展开发

### 1. 自定义匹配逻辑
可以修改`getBestMatchingLocale`方法来实现自定义的语言匹配逻辑。

### 2. 添加日志记录
```php
// 在中间件中添加日志
\Log::info('Browser language detected', [
    'accept_language' => $request->header('Accept-Language'),
    'matched_locale' => $browserLocale,
    'supported_locales' => $supportedLocales
]);
```

### 3. 集成用户偏好
可以扩展功能，将注册用户的语言偏好存储到数据库中。

### 4. 自定义中间件别名使用
```php
// 在路由中单独使用
Route::middleware(['browser.locale'])->group(function () {
    // 只需要浏览器检测的路由
});
```