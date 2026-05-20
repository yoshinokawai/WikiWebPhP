# VTuber Wiki Theme

> **A premium, community-driven WordPress encyclopedia theme for Virtual YouTubers (VTubers).**
> Built with a focus on aesthetics, performance, and an intuitive management experience — from browsing to administration.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Directory Structure](#directory-structure)
- [Custom Post Types](#custom-post-types)
- [ACF Custom Fields](#acf-custom-fields)
- [Page Templates](#page-templates)
- [Archive Templates](#archive-templates)
- [Core Modules (`/inc`)](#core-modules-inc)
- [Assets](#assets)
- [Design System](#design-system)
- [Custom Dropdown Component](#custom-dropdown-component)
- [Dashboard (Admin Panel)](#dashboard-admin-panel)
- [Routing & Navigation](#routing--navigation)
- [Search](#search)
- [Dark Mode](#dark-mode)
- [Database](#database)
- [Development Notes](#development-notes)
- [Changelog](#changelog)

---

## Overview

**VTuber Wiki Theme** là một WordPress theme tùy chỉnh được xây dựng hoàn toàn từ đầu, không phụ thuộc vào theme cha (parent theme). Mục tiêu là tạo ra một nền tảng bách khoa toàn thư mở, hiện đại, giúp cộng đồng khám phá thông tin về các VTuber và các tổ chức/agency quản lý họ.

Theme được thiết kế theo phong cách **glassmorphism + dark-mode-first**, với màu sắc chủ đạo là tím lavender (`#994ce6`) và tối ưu cho trải nghiệm người dùng trên cả desktop lẫn mobile.

---

## Features

### 🎨 Giao diện & Thiết kế
- **Dark / Light Mode** — Tự động theo system preference, lưu vào `localStorage`
- **Glassmorphism Navigation** — Thanh điều hướng sticky với hiệu ứng `backdrop-blur`
- **Dot pattern background** — Nền chấm chấm tím động theo theme
- **Gradient text & glow effects** — Logo, tiêu đề và các nút CTA được làm nổi bật
- **Smooth animations** — Fade-in, slide, float, pulse-border
- **Fully responsive** — Mobile-first, hỗ trợ tất cả kích thước màn hình
- **Premium Typography** — Font [Be Vietnam Pro](https://fonts.google.com/specimen/Be+Vietnam+Pro) & [Material Symbols Rounded](https://fonts.google.com/icons)

### 📁 Quản lý Nội dung
- **Custom Post Type: VTuber Wiki** (`vtuber_wiki`) — Hồ sơ từng VTuber
- **Custom Post Type: Agency** (`vtuber_agency`) — Hồ sơ từng công ty/tổ chức
- **ACF Integration** — Quản lý metadata phong phú (agency, debut date, language, artwork, lore...)
- **Custom Taxonomy: Agency Focus** (`vtuber_agency_focus`) — Phân loại agency

### 🔍 Tìm kiếm & Bộ lọc
- **Global search** — Trang `search.php` với kết quả chia tab (VTubers / Agencies)
- **Client-side filtering** — Lọc theo Agency, Ngôn ngữ, Khu vực, Sắp xếp mà không cần reload trang
- **Custom Dropdown Component** — Bộ lọc đẹp, animated, đồng nhất trên tất cả các trang
- **Deep-link via URL params** — `?agency=123&lang=Japanese` đồng bộ hóa với bộ lọc

### 🛠 Dashboard Quản trị (Front-end)
- Quản lý VTubers và Agencies ngay trên website (không cần vào WP Admin)
- Thêm / chỉnh sửa / xóa VTuber và Agency trực tiếp
- Bảng dữ liệu có tìm kiếm + lọc theo Agency, Status, Region
- Form nhập liệu đầy đủ với custom dropdown đẹp

### 📄 Trang nội dung
- 19+ page templates đã được xây dựng sẵn
- Tự động tạo và gán template cho các trang thiết yếu khi kích hoạt theme

---

## Tech Stack

| Công nghệ | Mục đích |
|---|---|
| **WordPress** (≥ 6.0) | CMS nền tảng |
| **PHP** (≥ 8.0) | Backend / template engine |
| **Tailwind CSS** (CDN v3) | Utility-first styling |
| **Vanilla CSS** (`style.css`) | Global styles, custom components |
| **Vanilla JavaScript** | Filtering, dark mode, dropdowns, mobile menu |
| **Advanced Custom Fields (ACF)** | Custom metadata cho CPTs |
| **Google Fonts** | Be Vietnam Pro, Material Symbols Rounded |
| **MySQL (via wpdb)** | Custom table: `vtuber_donations` |

---

## Requirements

- **WordPress**: 6.0 trở lên
- **PHP**: 8.0 trở lên
- **Plugin bắt buộc**: [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) — phiên bản miễn phí hoặc Pro
- **Local environment**: [Local by Flywheel](https://localwp.com/) hoặc bất kỳ stack PHP/MySQL nào

---

## Installation

1. **Clone hoặc copy** thư mục theme vào:
   ```
   wp-content/themes/vtuber-wiki-theme/
   ```

2. **Kích hoạt theme** trong WordPress Admin → Appearance → Themes

3. **Cài đặt ACF plugin** nếu chưa có:
   - WP Admin → Plugins → Add New → Tìm "Advanced Custom Fields" → Install & Activate

4. **Flush Permalinks**: WP Admin → Settings → Permalinks → Save Changes
   (Bắt buộc để CPT slugs hoạt động đúng)

5. **Các trang thiết yếu** sẽ được tự động tạo khi vào WP Admin lần đầu tiên sau khi kích hoạt theme (xem `navigation-setup.php`).

---

## Directory Structure

```
vtuber-wiki-theme/
│
├── style.css                    # Theme header + global CSS + custom dropdown component
├── functions.php                # Theme setup, enqueue scripts/styles, include modules
├── index.php                    # Fallback template
├── header.php                   # <head>, Tailwind config, Navigation bar
├── footer.php                   # Footer, JS scripts, custom dropdown JS handler
├── front-page.php               # Trang chủ
├── search.php                   # Trang kết quả tìm kiếm toàn cục
│
├── single-vtuber_wiki.php       # Chi tiết một VTuber
├── single-vtuber_agency.php     # Chi tiết một Agency
├── archive-vtuber_wiki.php      # Danh sách VTubers (có filter)
├── archive-vtuber_agency.php    # Danh sách Agencies (có filter)
│
├── inc/
│   ├── post-types.php           # Đăng ký CPTs: vtuber_wiki, vtuber_agency
│   ├── acf-fields.php           # Đăng ký ACF fields cho 2 CPTs
│   ├── custom-functions.php     # Breadcrumbs, vtwiki_page_url(), vtwiki_active_page()
│   ├── helpers.php              # Agency shortname, color palette, activity icons
│   ├── navigation-setup.php     # Tự động tạo & gán template cho các trang
│   └── db-setup.php             # Tạo custom table: vtuber_donations
│
├── templates/
│   ├── page-home.php            # Trang chủ (alternate)
│   ├── page-explore.php         # Khám phá tất cả VTubers
│   ├── page-agencies.php        # Danh sách Agencies
│   ├── page-independent.php     # VTubers độc lập (Indie)
│   ├── page-dashboard.php       # Dashboard quản trị front-end
│   ├── page-about.php           # Giới thiệu
│   ├── page-guidelines.php      # Quy tắc cộng đồng
│   ├── page-editor-hub.php      # Trung tâm biên tập
│   ├── page-fan-tools.php       # Công cụ fan
│   ├── page-help-center.php     # Trung tâm hỗ trợ
│   ├── page-donate.php          # Trang ủng hộ
│   ├── page-translation.php     # Dự án dịch thuật
│   ├── page-recent-changes.php  # Thay đổi gần đây
│   ├── page-random-profile.php  # Trang ngẫu nhiên
│   ├── page-wiki-forum.php      # Wiki Forum
│   ├── page-community-forum.php # Community Forum
│   ├── page-discord.php         # Discord
│   ├── page-login.php           # Đăng nhập
│   └── page-register.php        # Đăng ký
│
├── assets/
│   ├── css/
│   │   ├── home.css             # Styles trang chủ
│   │   ├── explore.css          # Styles trang Explore
│   │   ├── agencies.css         # Styles trang Agencies
│   │   ├── independent.css      # Styles trang Indie
│   │   ├── dashboard.css        # Styles trang Dashboard
│   │   ├── fan-tools.css        # Styles trang Fan Tools
│   │   └── ...                  # (các trang còn lại)
│   ├── js/
│   │   └── lang.js              # Dark mode, mobile menu, i18n placeholder
│   └── imgs/                    # Hình ảnh tĩnh (logo, placeholder...)
│
└── template-parts/              # Partial templates (cards, widgets...)
```

---

## Custom Post Types

### `vtuber_wiki` — VTuber Profile
| Thuộc tính | Giá trị |
|---|---|
| Slug (archive) | `/vtuber-wiki/` |
| Public | ✅ |
| Supports | title, editor, thumbnail, excerpt, custom-fields, revisions |
| REST API | ✅ (Gutenberg enabled) |
| Menu icon | `dashicons-video-alt3` |

### `vtuber_agency` — Agency Profile
| Thuộc tính | Giá trị |
|---|---|
| Slug (archive) | `/agency/` |
| Public | ✅ |
| Supports | title, editor, thumbnail, excerpt |
| REST API | ✅ |
| Menu icon | `dashicons-groups` |

### Taxonomy: `vtuber_agency_focus`
- Gắn với `vtuber_agency`
- Hierarchical (như category)
- Ví dụ: Gaming, Music, Variety...

---

## ACF Custom Fields

### VTuber Details (gắn với `vtuber_wiki`)

| Field Name | Field Key | Loại | Mô tả |
|---|---|---|---|
| `is_featured` | `field_vtuber_is_featured` | True/False | Hiển thị trong mục Spotlight |
| `agency_ref` | `field_vtuber_agency_obj` | Post Object | Liên kết tới Agency (CPT `vtuber_agency`) |
| `lore` | `field_vtuber_lore` | Textarea | Tiểu sử / lore nhân vật |
| `debut_date` | `field_vtuber_debut_date` | Date Picker | Ngày ra mắt (`Y-m-d`) |
| `birthday_text` | `field_vtuber_birthday` | Text | Sinh nhật (dạng text, ví dụ: "22 tháng 3") |
| `language` | `field_vtuber_language` | Text | Ngôn ngữ chính (ví dụ: Japanese, English) |
| `youtube_url` | `field_vtuber_youtube` | URL | Link kênh YouTube |
| `artwork_link` | `field_vtuber_artwork` | URL | Link ảnh artwork chính |
| `generation` | `field_vtuber_generation` | Text | Thế hệ / nhóm (ví dụ: Gen 1, Myth) |

### Agency Details (gắn với `vtuber_agency`)

| Field Name | Field Key | Loại | Mô tả |
|---|---|---|---|
| `logo_url` | `field_agency_logo` | URL | Link logo agency |
| `region` | `field_agency_region` | Select | Khu vực: Japan / US / Canada / Global |
| `talent_count` | `field_agency_talent_count` | Number | Số lượng tài năng |
| `social_links` | `field_agency_social` | Textarea | Danh sách links (cách nhau bằng dấu phẩy) |

---

## Page Templates

Tất cả templates nằm trong thư mục `templates/` và được gán tự động qua `navigation-setup.php`.

| Template File | URL Slug | Mô tả |
|---|---|---|
| `page-home.php` | `/` | Trang chủ |
| `page-explore.php` | `/explore/` | Khám phá VTubers với tìm kiếm & bộ lọc |
| `page-agencies.php` | `/agencies/` | Danh sách các Agency với bộ lọc Region & Sort |
| `page-independent.php` | `/independent/` | VTubers không thuộc Agency nào |
| `page-dashboard.php` | `/dashboard/` | Dashboard quản trị front-end |
| `page-about.php` | `/about/` | Giới thiệu về dự án |
| `page-guidelines.php` | `/guidelines/` | Quy tắc đóng góp cộng đồng |
| `page-editor-hub.php` | `/editor-hub/` | Trung tâm biên tập viên |
| `page-fan-tools.php` | `/fan-tools/` | Công cụ cho fans |
| `page-help-center.php` | `/help-center/` | Trung tâm hỗ trợ (có search) |
| `page-donate.php` | `/donate/` | Trang ủng hộ |
| `page-translation.php` | `/translation/` | Dự án dịch thuật |
| `page-recent-changes.php` | `/recent-changes/` | Lịch sử thay đổi gần đây |
| `page-random-profile.php` | `/random-profile/` | Redirect tới VTuber ngẫu nhiên |
| `page-wiki-forum.php` | `/wiki-forum/` | Diễn đàn wiki |
| `page-community-forum.php` | `/community-forum/` | Diễn đàn cộng đồng |
| `page-discord.php` | `/discord/` | Thông tin Discord server |
| `page-login.php` | `/login/` | Trang đăng nhập |
| `page-register.php` | `/register/` | Trang đăng ký tài khoản |

---

## Archive Templates

| File | Slug | Mô tả |
|---|---|---|
| `archive-vtuber_wiki.php` | `/vtuber-wiki/` | Archive CPT VTuber — có full filter (Agency, Language, Sort) |
| `archive-vtuber_agency.php` | `/agency/` | Archive CPT Agency — có filter (Region, Sort) |
| `single-vtuber_wiki.php` | `/vtuber-wiki/{slug}/` | Chi tiết VTuber — avatar, lore, links, debut |
| `single-vtuber_agency.php` | `/agency/{slug}/` | Chi tiết Agency — logo, danh sách talents |

---

## Core Modules (`/inc`)

### `post-types.php`
Đăng ký 2 CPTs (`vtuber_wiki`, `vtuber_agency`) và taxonomy `vtuber_agency_focus`. Tự động flush rewrite rules khi kích hoạt theme.

### `acf-fields.php`
Đăng ký toàn bộ ACF field groups **lập trình** (programmatically) — không cần import JSON, không phụ thuộc vào ACF UI. Fields được đăng ký qua hook `acf/init`.

### `custom-functions.php`
- `vtwiki_breadcrumbs()` — Tạo breadcrumb navigation tự động
- `vtwiki_asset(string $path)` — Trả về URL đầy đủ tới file trong `/assets/`
- `vtwiki_active_page()` — Trả về slug của trang hiện tại (dùng để highlight nav link)
- `vtwiki_page_url(string $slug)` — Trả về URL chính xác cho một trang bất kỳ, ưu tiên custom page rồi mới fallback về CPT archive

### `helpers.php`
- `vtwiki_get_agency_shortname(string $name)` — Tạo chữ viết tắt từ tên Agency (ví dụ: "Hololive Production" → "HP")
- `vtwiki_get_agency_color(int $index)` — Màu sắc theo index từ palette: `#2fb4d6, #ff7300, #ff0066, #8a2be2, #ffaccf`
- `vtwiki_get_activity_icon(string $type, string $action)` — Trả về tên Material Symbol icon theo loại hoạt động
- `vtwiki_get_activity_bg_class(string $action)` — Trả về Tailwind class màu nền cho badge hoạt động

### `navigation-setup.php`
Hook vào `admin_init`, tự động kiểm tra và tạo các trang thiết yếu (14 trang) nếu chưa tồn tại, đồng thời gán đúng page template (`_wp_page_template`).

**Danh sách trang được tự động tạo:**
`about`, `guidelines`, `editor-hub`, `wiki-forum`, `community-forum`, `help-center`, `donate`, `translation`, `fan-tools`, `random-profile`, `dashboard`, `explore`, `independent`, `agencies`

### `db-setup.php`
Tạo custom table `{prefix}_vtuber_donations` khi kích hoạt theme:
```sql
CREATE TABLE wp_vtuber_donations (
    id          mediumint(9)    AUTO_INCREMENT PRIMARY KEY,
    vtuber_id   bigint(20)      NOT NULL,
    donor_name  varchar(100)    NOT NULL,
    amount      decimal(10,2)   NOT NULL,
    currency    varchar(10)     DEFAULT 'VND',
    donation_date datetime      DEFAULT CURRENT_TIMESTAMP,
    message     text
);
```
Helper functions: `vtwiki_record_donation()`, `vtwiki_get_donations()`

---

## Assets

### CSS (`assets/css/`)
Mỗi trang có file CSS riêng, chỉ được load khi người dùng ở đúng trang đó (lazy load via `functions.php`).

Global styles (custom dropdown, scrollbar, animations) được đặt trong `style.css` gốc và được load trên tất cả các trang.

### JavaScript (`assets/js/lang.js`)
Script toàn cục được load trên mọi trang:
- Dark/Light mode toggle & persistence (`localStorage`)
- Mobile menu toggle
- Placeholder cho hệ thống đa ngôn ngữ (i18n)

### JavaScript inline (trong `footer.php`)
- Dark mode initialization
- Mobile menu
- Scroll shadow cho header
- **Custom Dropdown handler** — Xử lý tất cả `.custom-dropdown` components trên toàn site

---

## Design System

### Color Palette
```
--primary:        #994ce6   (Tím lavender chính)
--primary-dark:   #7e37c3   (Hover/Active state)
--primary-light:  #b97ef0   (Accent nhẹ hơn)
--bg-light:       #fdfcff   (Nền sáng)
--bg-dark:        #0e0b15   (Nền tối)
--surface-light:  #ffffff
--surface-dark:   #18112a
--surface-dark-2: #1f1635
--lavender:       #efe9f9   (Background nhạt)
```

### Border Radius Scale (custom Tailwind)
```
DEFAULT → 0.375rem (6px)
lg      → 0.75rem  (12px)
xl      → 1rem     (16px)
2xl     → 1.5rem   (24px)
3xl     → 2rem     (32px)
full    → 9999px
```

### Box Shadow
```
glow-sm → 0 0 12px rgba(153,76,230,0.25)
glow    → 0 0 24px rgba(153,76,230,0.35)
card    → 0 4px 24px rgba(0,0,0,0.08)
nav     → 0 8px 32px rgba(0,0,0,0.12)
```

### Typography
- Font chính: **Be Vietnam Pro** (weights: 300, 400, 500, 600, 700, 800, 900)
- Icon font: **Material Symbols Rounded**

---

## Custom Dropdown Component

Theme sử dụng **custom dropdown** thay cho thẻ `<select>` mặc định của trình duyệt để đảm bảo giao diện đồng nhất và đẹp hơn trên mọi trình duyệt/OS.

### Cấu trúc HTML
```html
<div class="custom-dropdown select-none">
    <!-- Trigger button -->
    <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 ...">
        <span class="selected-label">Tất cả</span>
        <span class="material-symbols-rounded ...">expand_more</span>
    </button>

    <!-- Dropdown menu -->
    <div class="custom-dropdown-menu">
        <button type="button" data-value="all" class="custom-dropdown-item">
            <span class="item-label">Tất cả</span>
            <span class="material-symbols-rounded hidden check-icon text-primary">check</span>
        </button>
        <!-- thêm các item khác -->
    </div>

    <!-- Hidden input để sync value (dùng cho filter hoặc form submit) -->
    <input type="hidden" id="my-filter" value="all" onchange="myFilterFn()">
</div>
```

### Cách hoạt động
1. Click **trigger** → thêm class `.is-open` vào `.custom-dropdown` → menu slide-fade in
2. Click **item** → cập nhật `.selected-label`, ghi giá trị vào `input[type="hidden"]`, dispatch event `change` → trigger filter function
3. Click **bên ngoài** → đóng tất cả dropdowns
4. **Reset** → function reset thủ công tìm đúng hidden input, set lại value, re-sync label và check icon

### CSS States
- `.custom-dropdown.is-open .custom-dropdown-menu` — Hiện menu
- `.custom-dropdown.is-open .custom-dropdown-trigger span.material-symbols-rounded` — Xoay icon 180°
- `.custom-dropdown-item.is-selected` — Highlight item đang chọn
- `.check-icon` (`.hidden` / show) — Dấu tích bên phải item

---

## Dashboard (Admin Panel)

Trang `/dashboard/` (`templates/page-dashboard.php`) là một **front-end admin panel** đầy đủ chức năng:

### Tabs
1. **Overview** — Thống kê tổng quan: tổng VTubers, Agencies, các hoạt động gần đây
2. **VTubers** — Bảng danh sách với search + filter (Agency, Status) + nút Edit/Delete
3. **Agencies** — Bảng danh sách với search + filter (Region, Status) + nút Edit/Delete
4. **Add VTuber** — Form đầy đủ để thêm VTuber mới
5. **Add Agency** — Form đầy đủ để thêm Agency mới

### Form Fields — Add VTuber
- Tên VTuber (required)
- Agency (custom dropdown → ghi vào `agency_ref`)
- Ngày Debut (date picker)
- Sinh nhật (text)
- Ngôn ngữ (text)
- Thế hệ / Generation (text)
- Trạng thái xuất bản (custom dropdown → `publish` / `draft`)
- Featured/Spotlight (checkbox)
- YouTube URL, Artwork URL
- Lore / Tiểu sử (textarea)
- Tóm tắt ngắn (textarea)

### Form Fields — Add Agency
- Tên Agency (required)
- Logo URL
- Khu vực (custom dropdown → Japan / US / Canada / Global)
- Số lượng tài năng (number)
- Trạng thái xuất bản (custom dropdown)
- Social Links (textarea)
- Mô tả (textarea)

---

## Routing & Navigation

### `vtwiki_page_url(string $slug)`
Hàm trung tâm để resolve URL cho bất kỳ slug nào:
1. Tìm page bằng `get_page_by_path($slug)`
2. Nếu không có page, fallback về CPT archive link (cho `agencies`, `explore`, `independent`)
3. Nếu vẫn không có, trả về `home_url('/?page=' . $slug)`

### `vtwiki_active_page()`
Trả về slug của trang hiện tại bằng cách parse template slug từ `get_page_template_slug()`. Dùng để thêm class `nav-link-active` vào nav item tương ứng.

### Navigation Header
Được định nghĩa trong `header.php` với:
- **Logo** + tên site
- **Primary Nav** — Explore, Agencies, Indie, Fan Tools, Recent Changes
- **Search bar** — Submit tới `/?s=` (WordPress native search)
- **Dark mode toggle**
- **Mobile hamburger menu**
- **Dropdown menus** — Hover-based với animation fade-in-down

---

## Search

### Global Search (`search.php`)
- URL: `/?s={query}` hoặc `/search?q={query}`
- Tìm kiếm đồng thời trong cả 2 CPTs (`vtuber_wiki` và `vtuber_agency`)
- Kết quả chia làm 2 tab riêng biệt
- Hiển thị avatar, tên, agency, excerpt

### Page-level Filtering
Mỗi trang directory (Explore, Agencies, Independent, Archive) đều có bộ lọc client-side:
- **Dữ liệu được load server-side** qua `WP_Query` và ghi vào `data-*` attributes trên các card HTML
- **JavaScript lọc** các card bằng cách ẩn/hiện dựa trên `data-*` attributes
- **Không reload trang** — trải nghiệm SPA-like

---

## Dark Mode

Theme sử dụng Tailwind's `darkMode: "class"` strategy:
- Class `dark` được thêm vào `<html>` element
- Script khởi tạo ở `<head>` (trước khi Tailwind render) để tránh FOUC (Flash of Unstyled Content)
- Preference được lưu vào `localStorage` với key `vtwiki-theme`
- Fallback theo `prefers-color-scheme` của OS nếu chưa có preference

---

## Database

### WordPress Default Tables
Theme sử dụng toàn bộ hạ tầng WordPress:
- `wp_posts` — Lưu VTubers và Agencies (CPTs)
- `wp_postmeta` — Lưu ACF custom fields (debut_date, language, artwork_link, v.v.)
- `wp_terms`, `wp_term_taxonomy` — Taxonomy `vtuber_agency_focus`

### Custom Table: `wp_vtuber_donations`
Được tạo tự động khi kích hoạt theme. Dùng để ghi nhận donations cho từng VTuber:
```
id | vtuber_id | donor_name | amount | currency | donation_date | message
```

---

## Development Notes

### Thêm trang mới
1. Tạo file template `templates/page-{slug}.php`
2. Thêm entry vào `$pages` array trong `inc/navigation-setup.php`
3. (Tùy chọn) Tạo file CSS riêng `assets/css/{slug}.css` và thêm vào map trong `functions.php`

### Thêm Custom Field mới
Thêm vào array `fields` trong `inc/acf-fields.php` → sẽ tự động xuất hiện trong WP Admin.

### Thêm Route mới vào `vtwiki_page_url()`
Trong `inc/custom-functions.php`, thêm block `if ($slug === 'new-slug')` nếu slug có logic đặc biệt.

### Lưu ý Custom Dropdown trong Form
Khi dùng custom dropdown trong `<form>`, giá trị phải được ghi vào `<input type="hidden" name="...">` với đúng `name` attribute — không dùng `name` trên `<button>` hoặc `.custom-dropdown`.

---

## Changelog

### v1.0.0 (2026-05)
- ✅ Khởi tạo theme từ đầu
- ✅ Đăng ký CPT `vtuber_wiki` và `vtuber_agency`
- ✅ ACF fields cho 2 CPTs
- ✅ Toàn bộ 19 page templates
- ✅ Archive templates có filter client-side
- ✅ Global search (`search.php`)
- ✅ Front-end Dashboard (`page-dashboard.php`)
- ✅ Dark/Light mode
- ✅ Responsive navigation với mobile menu
- ✅ Custom Dropdown Component toàn site
- ✅ Auto page creation via `navigation-setup.php`
- ✅ Custom table `vtuber_donations`
- ✅ Premium glassmorphism design system

---

## License

GNU General Public License v2 or later.
See [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

---

> Made with 💜 by the VTuber Wiki Team — *Discover, Learn, Contribute.*
