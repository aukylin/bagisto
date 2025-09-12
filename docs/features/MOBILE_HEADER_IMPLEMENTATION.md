# Bagisto 商品详情页移动端Header自适应功能

## 功能描述

在移动设备上访问商品详情页时，实现以下功能：
- 默认隐藏header
- 当用户向下滚动，商品图片不在可视范围时，显示header
- 当商品图片重新进入可视范围时，隐藏header
- 桌面端保持原有的header显示逻辑不变

## 修改的文件

### 1. 商品详情页主模板
**文件**: `packages/Webkul/Shop/src/Resources/views/products/view.blade.php`

**主要修改**:
- 为商品标题添加 `id="product-title"` 用于JavaScript定位
- 添加CSS样式控制移动端header的显示/隐藏
- 添加JavaScript代码实现基于商品标题位置的header控制逻辑

## 技术实现细节

### CSS样式
```css
#mobile-product-header {
    will-change: transform;
    backface-visibility: hidden;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    z-index: 9999 !important;
}
```

### JavaScript逻辑
1. **设备检测**: 仅在移动设备（宽度 < 1024px）上运行
2. **商品标题定位**: 查找商品标题元素作为触发参考点
3. **滚动监听**: 使用requestAnimationFrame和passive事件监听优化性能
4. **显示逻辑**: 
   - 当商品标题距离屏幕顶部100px以内时显示header
   - 当商品标题远离屏幕顶部时隐藏header
   - 备用方案：如果找不到标题，基于滚动距离触发
   - 默认状态：隐藏header

### 实现方式
- **CSS类控制**: 通过添加/移除body类 `show-mobile-header` 控制header显示
- **原生header**: 使用Bagisto原有的header结构，避免重复代码
- **事件节流**: 使用requestAnimationFrame提升滚动性能
- **响应式处理**: 监听窗口大小变化，确保桌面端正常显示

### 性能优化
- 使用 `requestAnimationFrame` 节流滚动事件
- 使用 `passive: true` 标志优化滚动监听
- 使用 `will-change` 和 `backface-visibility` 优化CSS动画性能
- 限制查找尝试次数避免无限循环

## 兼容性

- **移动设备**: iOS Safari, Android Chrome, 其他现代移动浏览器
- **桌面设备**: 保持原有功能不变
- **响应式**: 自动适应屏幕尺寸变化
- **Vue.js**: 兼容Bagisto的Vue组件异步渲染

## 故障排除

### 如果header没有显示：
1. 检查浏览器控制台是否有JavaScript错误
2. 确认在移动设备模式下测试（宽度 < 1024px）
3. 检查商品标题元素是否正确加载
4. 验证CSS类 `show-mobile-header` 是否正确添加到body元素

### 调试方法：
**浏览器控制台检查**：
```javascript
// 检查商品标题元素
console.log('Product title:', document.getElementById('product-title'));

// 检查body类
console.log('Body classes:', document.body.className);

// 检查header元素
console.log('Header element:', document.querySelector('header'));
```

### 测试步骤：
1. 在移动设备或浏览器开发者工具的移动模式下打开商品详情页
2. 确认页面加载时header是隐藏的
3. 向下滚动页面，当商品标题接近屏幕顶部时，header应该显示
4. 向上滚动让商品标题远离屏幕顶部，header应该重新隐藏
5. 在桌面模式下确认header保持原有行为不变

## 使用方法

1. 将修改应用到对应的Blade模板文件
2. 清除缓存：`php artisan cache:clear`
3. 重新编译前端资源（如果需要）：`npm run build`
4. 在移动设备上访问任意商品详情页测试功能

## 注意事项

- 此功能仅影响商品详情页，其他页面的header行为保持不变
- 确保Tailwind CSS类名在项目中可用
- 功能依赖于Vue.js组件的正确渲染
- 如果项目使用了自定义的CSS框架，可能需要调整类名
- 建议在实际移动设备上测试以确保最佳用户体验