# 字体加载优化

## 📋 解决方案

提供三种字体加载策略解决Google Fonts连接问题：

- **local**: 本地字体文件（推荐）
- **cdn**: 优化的CDN加载
- **hybrid**: CDN优先，失败时回退

## ⚙️ 配置

### 环境变量
```env
FONT_STRATEGY=local    # 字体策略
FONT_TIMEOUT=3000      # 超时时间（毫秒）
```

### 本地字体部署
```bash
# 下载字体文件
./scripts/fonts/localize-fonts.sh

# 验证安装
php scripts/fonts/verify-fonts.php

# 启用本地字体
echo "FONT_STRATEGY=local" >> .env
php artisan config:clear
```

## 📁 文件结构

```
public/fonts/
├── files/                         # 字体文件
│   ├── poppins-{400,500,600,700,800}.woff2
│   ├── inter-{400,500,600,700}.ttf
│   └── dm-serif-display-400.ttf
├── poppins-local.css              # 本地CSS
├── inter-local.css
└── dm-serif-display-local.css
```

## 🧪 测试验证

### 浏览器测试
访问 `http://your-domain/font-test.html` 测试字体加载效果

### 性能检查
```javascript
// 控制台检查字体状态
document.fonts.ready.then(() => {
    document.fonts.forEach(font => {
        console.log(`${font.family}: ${font.status}`);
    });
});
```

### 网络面板
1. 开发者工具 → Network
2. 筛选 "Font" 类型
3. 确认无外部字体请求（本地模式）

## 🔧 故障排除

### 字体不显示
```bash
# 验证文件
php scripts/fonts/verify-fonts.php

# 清除缓存
php artisan config:clear
php artisan cache:clear
```

### 配置不生效
```bash
# 检查配置
php artisan tinker
>>> config('fonts.strategy')
```

## 📚 相关文档

- [字体配置](../../configuration/fonts.md)
- [字体工具](../tools/font-tools.md)