# VTuber Wiki & Forum - WordPress Theme

Dự án chuyển đổi hệ thống Wiki & Forum VTuber từ nền tảng ASP.NET MVC sang WordPress. Theme được thiết kế hiện đại, tối ưu cho cộng đồng VTuber với khả năng quản lý hồ sơ nhân vật và tổ chức (Agency) linh hoạt.

## 🚀 Tính năng nổi bật

- **Custom Post Types**: Đã đăng ký `vtuber_wiki` và `vtuber_agency` để quản lý chuyên sâu.
- **Spotlight Slider**: Hệ thống slide trang chủ động, mượt mà, cho phép hiển thị các VTuber nổi bật.
- **Agency Branding**: Logic tự động tạo tên viết tắt (Shortname) và màu sắc đặc trưng cho từng Agency (Ported từ C#).
- **ACF Integration**: Tích hợp sâu với Advanced Custom Fields để lưu trữ thông tin Lore, Debut, Social links...
- **Automated Setup**: Tự động tạo các trang thiết yếu (About, Guidelines, Help Center) khi kích hoạt theme.
- **Modern UI**: Sử dụng Tailwind CSS, Material Symbols và Google Fonts (Be Vietnam Pro).

## 🛠 Yêu cầu hệ thống

Để theme hoạt động hoàn hảo, bạn cần cài đặt các Plugin sau:
1. **Advanced Custom Fields (ACF)**: Bắt buộc (Để quản lý dữ liệu nhân vật).
2. **bbPress**: Khuyên dùng (Để kích hoạt tính năng Diễn đàn).
3. **Ultimate Member**: Khuyên dùng (Để có trang profile thành viên đẹp).

## 📂 Cấu trúc thư mục chính

- `/inc/post-types.php`: Đăng ký các loại bài viết tùy chỉnh.
- `/inc/acf-fields.php`: Cấu hình các trường dữ liệu cho VTuber và Agency.
- `/inc/helpers.php`: Chứa các hàm logic về thương hiệu Agency và icon hoạt động.
- `/inc/navigation-setup.php`: Script tự động tạo trang và menu.
- `/template-parts/home/`: Chứa các thành phần giao diện của trang chủ.
- `front-page.php`: Giao diện trang chủ tùy chỉnh với Slider.

## ⚙️ Cài đặt & Sử dụng

1. Copy folder theme vào `wp-content/themes/`.
2. Kích hoạt theme trong giao diện quản trị WordPress.
3. Cài đặt và kích hoạt Plugin **Advanced Custom Fields**.
4. (Tùy chọn) Chạy file `create-sample-data.php` trên trình duyệt để nạp dữ liệu mẫu nhanh.

## 📝 Tác giả
Dự án được thực hiện nhằm mang lại trải nghiệm Wiki VTuber chuyên nghiệp và dễ sử dụng nhất trên nền tảng WordPress.

---
*© 2026 VTWiki Project. Hướng tới cộng đồng VTuber Việt Nam và Quốc tế.*
