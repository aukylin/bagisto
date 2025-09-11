# 项目脚本

本目录包含项目相关的脚本和工具。

## 📁 目录结构

```
scripts/
└── fonts/                    # 字体相关脚本
    ├── localize-fonts.sh     # 字体本地化脚本
    ├── download-fonts.sh     # 字体下载脚本（备用）
    └── verify-fonts.php      # 字体验证脚本
```

## 🔧 字体脚本

### localize-fonts.sh
自动下载Google Fonts字体文件到本地，支持Poppins、DM Serif Display和Inter字体。

**使用方法**:
```bash
chmod +x scripts/fonts/localize-fonts.sh
./scripts/fonts/localize-fonts.sh
```

### verify-fonts.php
验证字体文件和配置的完整性，检查所有必需的文件是否存在。

**使用方法**:
```bash
php scripts/fonts/verify-fonts.php
```

### download-fonts.sh
备用的字体下载脚本，仅下载CSS文件。

**使用方法**:
```bash
chmod +x scripts/fonts/download-fonts.sh
./scripts/fonts/download-fonts.sh
```

## 📚 相关文档

- [字体工具文档](../docs/development/tools/font-tools.md)
- [字体优化指南](../docs/development/performance/font-optimization.md)
- [字体配置文档](../docs/configuration/fonts.md)

## 🚀 快速开始

如果遇到字体加载问题：

1. **本地化字体**:
   ```bash
   ./scripts/fonts/localize-fonts.sh
   ```

2. **验证安装**:
   ```bash
   php scripts/fonts/verify-fonts.php
   ```

3. **配置环境**:
   ```bash
   echo "FONT_STRATEGY=local" >> .env
   ```

4. **清除缓存**:
   ```bash
   php artisan config:clear
   ```