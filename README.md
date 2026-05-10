# Hướng Dẫn Cài Đặt Và Sử Dụng - Tran Anh Holding

Tài liệu này hướng dẫn cách cài đặt, cấu hình và vận hành dự án Website Tran Anh Holding. Hệ thống được xây dựng trên nền tảng **Laravel** (Backend) kết hợp với **Vue.js & Inertia.js** (Frontend) và **Tailwind CSS**.

## Yêu cầu hệ thống (Prerequisites)

Để chạy dự án này, máy chủ hoặc máy cá nhân của bạn cần cài đặt các phần mềm sau:

- **PHP**: Phiên bản >= 8.1 (Khuyến nghị 8.2 trở lên)
- **Composer**: Trình quản lý thư viện của PHP (https://getcomposer.org/)
- **Node.js**: Trình quản lý gói Javascript, bao gồm `npm` (https://nodejs.org/) - Khuyến nghị bản LTS
- **Cơ sở dữ liệu**: MySQL hoặc MariaDB

## Các bước cài đặt (Installation)

### 1. Giải nén mã nguồn
Giải nén (hoặc clone) thư mục mã nguồn dự án vào thư mục web server của bạn (ví dụ: `htdocs` đối với XAMPP, `www` đối với Laragon/WAMP).

### 2. Cài đặt các thư viện PHP (Backend)
Mở Terminal (hoặc Command Prompt) tại thư mục gốc của dự án và chạy lệnh sau để cài đặt các thư viện cho Laravel:
```bash
composer install
```

### 3. Cài đặt các thư viện Node.js (Frontend)
Tiếp tục trong Terminal, chạy lệnh sau để cài đặt các package cần thiết cho giao diện Vue.js:
```bash
npm install
```

### 4. Cấu hình file môi trường (.env)
- Sao chép file `.env.example` và đổi tên thành `.env` (Nếu chưa có file `.env`).
```bash
cp .env.example .env
```
- Mở file `.env` bằng trình soạn thảo văn bản và cập nhật cấu hình Cơ sở dữ liệu (Database) cho phù hợp với máy của bạn:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tran_anh_holding_db  # Thay bằng tên database thực tế
DB_USERNAME=root                 # Tên user database
DB_PASSWORD=                     # Mật khẩu database
```

### 5. Tạo Application Key
Chạy lệnh sau để tạo khóa bảo mật cho ứng dụng Laravel:
```bash
php artisan key:generate
```

### 6. Chạy Migration (Tạo các bảng trong CSDL)
Đảm bảo bạn đã tạo Database với tên tương ứng trong file `.env`. Sau đó chạy lệnh sau để tạo các bảng:
```bash
php artisan migrate
```
*(Nếu hệ thống có file dữ liệu mẫu (Seeder), bạn có thể chạy `php artisan migrate --seed` để khởi tạo dữ liệu).*

### 7. Link thư mục Storage
Chạy lệnh sau để tạo đường dẫn (symlink) cho thư mục lưu trữ file/hình ảnh:
```bash
php artisan storage:link
```

## Khởi chạy dự án (Running the application)

Để hệ thống hoạt động hoàn chỉnh (bao gồm cả Backend và Frontend) trên môi trường phát triển (Local/Development), bạn cần chạy song song 2 lệnh sau ở 2 cửa sổ Terminal khác nhau:

**Terminal 1 (Khởi chạy server backend Laravel):**
```bash
php artisan serve
```
*Mặc định website sẽ chạy tại địa chỉ: `http://localhost:8000`*

**Terminal 2 (Khởi chạy server frontend Vite/Vue.js):**
```bash
npm run dev
```

Sau khi cả 2 server đều đang chạy, bạn hãy mở trình duyệt và truy cập vào địa chỉ: **http://localhost:8000** để xem và thao tác với website.

## Chuyển sang môi trường Production (Triển khai lên Hosting/VPS)

Khi muốn đưa website lên môi trường chạy thật (Production) hoặc deploy lên hosting, bạn không sử dụng lệnh `npm run dev` nữa, mà cần build giao diện web ra các file tĩnh (assets):

1. Chạy lệnh build Frontend:
```bash
npm run build
```
2. Đảm bảo cấu hình trong file `.env` trên server production đã được điều chỉnh chuẩn xác:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```
3. Chạy các lệnh tối ưu hóa của Laravel để tăng tốc độ load website:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Các công nghệ sử dụng trong dự án
- [Laravel](https://laravel.com/) - Framework PHP
- [Vue.js 3](https://vuejs.org/) - Framework Javascript (Frontend)
- [Inertia.js](https://inertiajs.com/) - Kết nối Backend và Frontend không cần tạo API
- [Tailwind CSS 4](https://tailwindcss.com/) - Utility-first CSS framework
- [Vite](https://vitejs.dev/) - Trình build tool siêu tốc cho Frontend
