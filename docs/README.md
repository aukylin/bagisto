# Bagisto 项目文档

这个目录包含了Bagisto项目的扩展功能和自定义开发文档。

## 📁 目录结构

```
docs/
├── README.md                    # 文档索引（本文件）
├── api/                         # API文档和参考
├── deployment/                  # 部署指南和配置
├── development/                 # 开发指南和最佳实践
│   ├── performance/             # 性能优化指南
│   │   ├── font-optimization.md      # 字体优化指南
│   │   └── font-status-report.md     # 字体状态报告
│   └── tools/                   # 开发工具和脚本
│       └── font-tools.md        # 字体工具文档
├── features/                    # 功能特性文档
│   └── LANGUAGE_DETECTION.md    # 浏览器语言自动检测功能
└── configuration/               # 配置指南和参考
    └── fonts.md                 # 字体配置文档
```

## 🚀 功能特性

### [浏览器语言自动检测](features/LANGUAGE_DETECTION.md)
为Bagisto添加基于浏览器Accept-Language头的自动语言检测功能，与内置语言切换系统完美集成。

### [字体加载优化](development/performance/font-optimization.md)
解决Google Fonts加载缓慢问题，提供CDN、本地、混合三种字体加载策略。

**主要特性:**
- 智能检测首次访问用户的浏览器语言偏好
- 与Bagisto现有语言切换功能无缝集成
- 支持多渠道语言配置
- 遵循Bagisto包架构设计

**技术实现:**
- 位置: `packages/Webkul/Shop/src/Http/Middleware/BrowserLocaleDetection.php`
- 集成: Shop包中间件组
- 兼容: 与Bagisto原生Locale中间件协同工作

## ⚡ 性能优化

### [字体加载优化](development/performance/font-optimization.md)
解决Google Fonts加载缓慢问题，支持CDN、本地、混合三种策略。

**相关文档:**
- [字体配置](configuration/fonts.md) - 配置说明
- [字体工具](development/tools/font-tools.md) - 脚本使用
- [性能最佳实践](development/performance/best-practices.md) - 优化建议

---

## 📝 文档贡献

如果你添加了新的功能或改进，请：

1. 在相应的目录下创建文档文件
2. 更新本README文件的索引
3. 遵循现有的文档格式和风格
4. 包含完整的使用说明和技术细节

## 📋 文档规范

### 功能文档应包含：
- **功能概述**: 简要说明功能用途
- **技术实现**: 详细的技术架构和实现方式
- **安装配置**: 安装和配置步骤
- **使用方法**: 具体的使用示例
- **测试验证**: 测试方法和验证步骤
- **故障排除**: 常见问题和解决方案

### 文件命名规范：
- 使用大写字母和下划线：`FEATURE_NAME.md`
- 功能文档放在 `features/` 目录
- API文档放在 `api/` 目录（如需要）
- 部署文档放在 `deployment/` 目录（如需要）

---

*最后更新: 2025年1月*