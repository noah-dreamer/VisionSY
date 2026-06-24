<footer class="border-t border-ink-100 bg-white">
    <div class="shell flex flex-col gap-6 py-10 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-3">
            <x-brand sub="校园媒体资产管理" />
            <p class="max-w-sm text-sm leading-relaxed text-ink-500">
                学校宣传部自托管媒体资产平台 · 统一归档、分级取用、校园网激活。
            </p>
        </div>
        <nav class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-ink-500" aria-label="页脚导航">
            <a href="https://example.com" class="transition hover:text-ink-900">example.com</a>
            <a href="{{ config('visionsy.urls.resourcespace') }}" class="transition hover:text-ink-900">媒体库 media.example.com</a>
            @auth
                <a href="{{ config('visionsy.urls.auth') }}/dashboard" class="transition hover:text-ink-900">控制台</a>
            @else
                <a href="{{ config('visionsy.urls.auth') }}/login" class="transition hover:text-ink-900">登录</a>
            @endauth
        </nav>
    </div>
    <div class="border-t border-ink-100">
        <div class="shell flex flex-col gap-1 py-5 text-xs text-ink-400 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ date('Y') }} VisionSY · 学校宣传部 校园媒体资产管理系统</p>
            <p>VSSY · Student Media Center</p>
        </div>
    </div>
</footer>
