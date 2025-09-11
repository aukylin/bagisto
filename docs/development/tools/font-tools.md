# 字体工具

## 📁 工具位置
```
scripts/fonts/
├── localize-fonts.sh     # 字体本地化
├── download-fonts.sh     # 字体下载（备用）
└── verify-fonts.php      # 字体验证
```

## 🔧 使用方法

### localize-fonts.sh - 字体本地化
下载Google Fonts到本地
```bash
chmod +x scripts/fonts/localize-fonts.sh
./scripts/fonts/localize-fonts.sh
```

### verify-fonts.php - 字体验证
检查字体文件和配置完整性
```bash
php scripts/fonts/verify-fonts.php
```

### 测试页面
浏览器测试字体效果
```
访问: http://your-domain/font-test.html
```

## 📊 验证输出示例
```
=== 字体文件验证脚本 ===

1. 检查字体文件:
   ✅ Poppins 400: 存在 (48.53 KB)
   ✅ Inter 400: 存在 (317.21 KB)
   ...

2. 检查CSS文件:
   ✅ Poppins CSS: 存在
   ...

3. 检查环境配置:
   ✅ 字体策略: 本地模式
```

## 🚀 快速使用
```bash
# 完整流程
./scripts/fonts/localize-fonts.sh
php scripts/fonts/verify-fonts.php
echo "FONT_STRATEGY=local" >> .env
php artisan config:clear
```

## 📚 相关文档
- [字体优化指南](../performance/font-optimization.md)
- [字体配置](../../configuration/fonts.md)