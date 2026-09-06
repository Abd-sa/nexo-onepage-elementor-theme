# فاز ۲ — کیفیت محصول

نسخه: **1.5.0**

## انجام‌شده

| مورد | وضعیت |
|------|--------|
| 2.1 ویجت Elementor نمونه کارها | ✅ دسته NEXO → «NEXO نمونه کارها» |
| 2.1 ویجت Elementor نظرات | ✅ «NEXO نظرات مشتریان» |
| 2.2 Single پورتفولیو | ✅ `single-nexo_portfolio.php` |
| 2.3 Archive پورتفولیو | ✅ `archive-nexo_portfolio.php` |
| 2.4 فرم تماس واقعی | ✅ AJAX داخلی (بدون CF7) |
| 2.5 ریسپانسیو | ✅ breakpoint در enqueue + style |
| 2.6 RTL عمیق‌تر | ✅ `assets/css/rtl.css` گسترش یافت |
| 2.7 پرفورمنس | ✅ preconnect، defer، وزن فونت کمتر |
| 2.9 Child theme | پشتیبانی استاندارد وردپرس (child می‌تواند override کند) |
| 2.10 Elementor Free/Pro | ویجت‌ها روی API مشترک Elementor 3.x |

## تست Local

```bash
git pull origin main
```

1. Elementor → افزودن ویجت از دسته **NEXO**
2. باز کردن یک نمونه کار → صفحه single
3. آدرس `/portfolio/` → آرشیو
4. ارسال فرم تماس در فرانت (ایمیل ادمین Local ممکن است لاگ شود)
5. زبان فارسی → RTL هدر و سکشن‌ها

## بعدی — فاز ۳

مستندات PDF، اسکرین‌شات محصول، changelog، ZIP انتشار، screenshot.png
