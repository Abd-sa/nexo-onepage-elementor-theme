# NEXO OnePage – Personal Portfolio WordPress Theme

قالب حرفه‌ای وان‌پیج شخصی / رزومه / پورتفولیو برای وردپرس + المنتور  
آماده برای فروش در راست‌چین

**Repository:** https://github.com/Abd-sa/nexo-onepage-elementor-theme

---

## ویژگی‌های کلیدی

- **پایه سبک** – سازگار با Hello Elementor و استفاده به صورت مستقل
- **پنل تنظیمات اختصاصی** (منوی «NEXO Settings» در ادمین)
  - رنگ‌های اصلی (Primary, Secondary, Accent, Text, Background)
  - فونت‌های فارسی (Vazirmatn, IRANSans, Shabnam, ...)
  - سایز تیترها و متن
  - محتوای Hero، لینک‌های شبکه‌های اجتماعی
  - تعداد نمایش نمونه کار و نظرات
  - Custom CSS / JS
- **Custom Post Type**
  - `Portfolio` + دسته‌بندی (برای فیلتر)
  - `Testimonials` + فیلدهای نقش مشتری و امتیاز
- **نمایش داینامیک** نمونه کار و نظرات در صفحه اصلی
- **RTL کامل** + فونت Vazirmatn به صورت پیش‌فرض
- **سازگاری کامل با Elementor Free و Pro**
- **بهینه‌سازی سرعت** (کد تمیز، CSS Variables، بدون وابستگی سنگین)
- **ساختار آماده دمو و مستندات**

---

## ساختار فایل‌ها

```
nexo-onepage-elementor-theme/
├── style.css
├── functions.php
├── index.php
├── front-page.php          ← قالب وان‌پیج
├── header.php / footer.php
├── page.php / 404.php
├── inc/
│   ├── setup.php
│   ├── enqueue.php
│   ├── cpt.php             ← Portfolio + Testimonials
│   ├── options.php         ← پنل تنظیمات
│   ├── elementor.php
│   └── helpers.php
├── template-parts/
│   ├── hero.php
│   ├── about.php
│   ├── services.php
│   ├── portfolio.php       ← داینامیک
│   ├── testimonials.php    ← داینامیک
│   ├── pricing.php
│   └── faq-contact.php
├── assets/
│   ├── css/rtl.css
│   └── js/main.js
└── README.md
```

---

## نصب و راه‌اندازی

1. پوشه تم را در `wp-content/themes/` آپلود کنید.
2. از **ظاهر → پوسته‌ها** تم **NEXO OnePage** را فعال کنید.
3. (پیشنهادی) افزونه **Elementor** را نصب و فعال کنید.
4. به منوی **NEXO Settings** بروید و رنگ‌ها، فونت‌ها و محتوای Hero را تنظیم کنید.
5. از منوی **Portfolio** و **Testimonials** نمونه کار و نظرات مشتریان را اضافه کنید.
6. یک منو بسازید و به موقعیت **Primary Menu** اختصاص دهید.
7. صفحه اصلی را روی «آخرین نوشته‌ها» یا یک صفحه استاتیک با قالب پیش‌فرض بگذارید (قالب `front-page.php` خودکار بارگذاری می‌شود).

### استفاده با Elementor

- می‌توانید کل صفحه را با Elementor Canvas طراحی کنید.
- یا فقط بخش‌های خاص را با المنتور جایگزین کنید.
- CPTها با Dynamic Tags المنتور Pro یا ویجت‌های Query قابل استفاده هستند.

---

## پنل تنظیمات (NEXO Settings)

| بخش            | امکانات                                      |
|----------------|-----------------------------------------------|
| Colors         | Primary, Secondary, Accent, Text, Background |
| Typography     | فونت تیتر و متن + سایز H1/H2/Body             |
| Hero Section   | Badge, Title, Subtitle, Description           |
| Social Links   | LinkedIn, Behance, Dribbble, Instagram        |
| General        | عرض محتوا، تعداد Portfolio/Testimonials، انیمیشن |
| Custom Code    | CSS و JS سفارشی                               |

---

## افزودن محتوا

### نمونه کار (Portfolio)
1. از منوی **Portfolio → Add New**
2. عنوان، تصویر شاخص، محتوا و دسته را وارد کنید.
3. در متاباکس «Project Details» نام مشتری و لینک پروژه را پر کنید.

### نظرات مشتریان (Testimonials)
1. از منوی **Testimonials → Add New**
2. نام مشتری را در عنوان بنویسید.
3. متن نظر را در ویرایشگر بنویسید.
4. تصویر آواتار را به عنوان Featured Image بگذارید.
5. نقش/شرکت و امتیاز را در متاباکس وارد کنید.

---

## توسعه بیشتر (پیشنهاد برای نسخه تجاری)

- [ ] اضافه کردن Codestar Framework (CSF) برای پنل تنظیمات پیشرفته‌تر
- [ ] One-Click Demo Import
- [ ] ویجت‌های اختصاصی Elementor برای Portfolio و Testimonials
- [ ] حالت تاریک (Dark Mode)
- [ ] چند دمو (Designer / Developer / Photographer)
- [ ] فایل‌های JSON تمپلیت المنتور
- [ ] مستندات و ویدیوی نصب فارسی

---

## نیازمندی‌ها

- WordPress 6.0+
- PHP 7.4+
- Elementor (پیشنهادی)

---

## لایسنس

GPL v2 or later

---

ساخته شده برای فروش در **راست‌چین** با تمرکز روی کیفیت، سرعت و تجربه کاربری فارسی.
