# VisionSY 官网 —— 本地开发指南

## 一、环境要求

| 软件 | 版本 |
| --- | --- |
| PHP | ≥ 8.2（含 `pdo_mysql`、`mbstring`、`openssl`、`sqlite3` 扩展，sqlite 供测试用） |
| Composer | 2.x |
| Node.js | ≥ 20 |
| Docker + Docker Compose | 任意近期版本（提供 MySQL 与 Mailpit） |

## 二、首次启动

```bash
cp .env.example .env
docker compose up -d            # MySQL(3306) + Mailpit(SMTP 1025 / UI 8025)
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run build                   # 或开发时 npm run dev
php artisan test                # 全部测试应通过（sqlite 内存库，不依赖 docker）
php artisan serve               # http://localhost:8000
```

想在浏览器里收注册验证邮件：把 `.env` 改为 `MAIL_MAILER=smtp`、`MAIL_HOST=127.0.0.1`、`MAIL_PORT=1025`，邮件会出现在 http://localhost:8025 。默认 `MAIL_MAILER=log` 时邮件写入 `storage/logs/laravel.log`，验证链接可从日志复制。

## 三、种子账号（密码均为 `<LOCAL_DEV_PASSWORD>`，由 `SEED_DEFAULT_PASSWORD` 控制）

| 邮箱 | 角色 | 状态 | 用途 |
| --- | --- | --- | --- |
| `admin@example.com` | system_admin | active | 管理后台 `/admin` |
| `media@example.com` | propaganda_member | active | 宣传部成员（原图下载组） |
| `teacher@example.com` | wechat_editor_teacher | active | 官微编辑老师 |
| `student@student.example.com` | normal_user | active | 已激活普通用户 |
| `pending@student.example.com` | normal_user | pending_activation | 演示校园 IP 激活流程 |

种子同时创建：校园网段 `10.20.0.0/16`、`10.30.0.0/16`（启用）与 `192.168.50.0/24`（禁用）、OAuth 客户端 `resourcespace`（secret 为 `.env` 的 `SEED_RS_CLIENT_SECRET`，默认 `<OAUTH_CLIENT_SECRET>`）、3 条审计日志样例。

## 四、本地模拟校园 IP 激活

测试环境信任 `127.0.0.1` 为代理（`TRUSTED_PROXY_IPS`），所以本机请求带 `X-Real-IP` 头即可模拟任意来源 IP：

```bash
# 用 pending@student.example.com 登录后，带头请求重检接口（或直接用浏览器插件改头）
curl -i -X POST http://localhost:8000/dashboard/recheck-activation \
  -H 'X-Real-IP: 10.20.1.2' \
  -b cookies.txt -H "X-CSRF-TOKEN: <从页面取>"
```

更直接的方式是跑测试：`tests/Feature/CampusActivationTest.php` 覆盖了命中 / 未命中 / 禁用网段 / 伪造头四种场景。

## 五、调试内部 API（transfer token）

```bash
SECRET='<INTERNAL_API_SECRET>'   # .env 的 INTERNAL_API_SECRET

# 生成（校外 IP -> 目标 files.example.com）
curl -s -X POST http://localhost:8000/api/transfer-tokens \
  -H "X-Internal-Secret: $SECRET" -H 'Content-Type: application/json' \
  -d '{"action":"download","original_method":"GET","client_ip":"8.8.8.8"}'

# 校验
curl -s "http://localhost:8000/api/transfer-tokens/validate?token=<上一步token>&host=files.example.com&action=download" \
  -H "X-Internal-Secret: $SECRET"

# 消费（一次性 token 第二次消费返回 403）
curl -s -X POST http://localhost:8000/api/transfer-tokens/consume \
  -H "X-Internal-Secret: $SECRET" -H 'Content-Type: application/json' \
  -d '{"token":"<token>"}'
```

## 六、常用命令

```bash
php artisan test                          # 全部测试
php artisan test --filter=OAuthFlowTest   # 只跑 OAuth 流程
npm run dev                               # Vite 热更新
php artisan migrate:fresh --seed          # 重置数据库
php artisan schedule:work                 # 本地跑调度（过期 token 清理）
```

## 七、沙箱 / 离线环境说明

本仓库代码在无网络环境中编写，`composer install`、`npm install` 与 `php artisan test` 需在你的本机（可联网）执行。若任何测试失败，优先检查 PHP 版本与扩展，其次按报错定位——所有测试都只依赖 sqlite 内存库，不需要 docker。
