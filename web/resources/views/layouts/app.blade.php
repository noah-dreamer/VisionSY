<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="VisionSY 校园媒体资产管理系统 · 统一归档、分级取用、校园网激活。">
    <title>@yield('title', 'VisionSY · 校园媒体资产管理系统')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-ink-50 text-ink-900">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:shadow-lift">跳转到主要内容</a>

    @php $overHero = trim($__env->yieldContent('over-hero')) === '1'; @endphp

    <header
        x-data="{ scrolled: false, menu: false }"
        @scroll.window="scrolled = window.scrollY > 8"
        class="fixed inset-x-0 top-0 z-50 transition-colors duration-300"
        :class="(scrolled || menu) ? 'border-b border-ink-100 bg-white/85 backdrop-blur-xl' : '{{ $overHero ? 'border-b border-transparent' : 'border-b border-ink-100 bg-white/85 backdrop-blur-xl' }}'">
        <div class="shell flex h-16 items-center justify-between">
            {{-- 品牌：在 Hero 上方且未滚动时用浅色字 --}}
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2.5">
                <span class="brand-mark h-9 w-9 text-sm" aria-hidden="true">V</span>
                <span class="flex flex-col leading-none">
                    <span class="text-[15px] font-semibold tracking-tight transition-colors"
                          :class="(scrolled || menu) ? 'text-ink-900' : '{{ $overHero ? 'text-white' : 'text-ink-900' }}'">VisionSY</span>
                    <span class="mt-0.5 hidden text-[11px] uppercase tracking-[0.12em] transition-colors sm:block"
                          :class="(scrolled || menu) ? 'text-ink-400' : '{{ $overHero ? 'text-white/55' : 'text-ink-400' }}'">校园媒体资产管理</span>
                </span>
            </a>

            {{-- 桌面操作区 --}}
            <nav class="hidden items-center gap-2 sm:flex" aria-label="主导航">
                @auth
                    <a href="{{ config('visionsy.urls.auth') }}/dashboard"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition"
                       :class="(scrolled || menu) ? 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' : '{{ $overHero ? 'text-white/80 hover:bg-white/10 hover:text-white' : 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' }}'">控制台</a>
                    @if (auth()->user()->isSystemAdmin())
                        <a href="{{ config('visionsy.urls.auth') }}/admin"
                           class="rounded-lg px-3 py-2 text-sm font-medium transition"
                           :class="(scrolled || menu) ? 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' : '{{ $overHero ? 'text-white/80 hover:bg-white/10 hover:text-white' : 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' }}'">管理后台</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="ml-1">
                        @csrf
                        <button type="submit"
                                :class="(scrolled || menu) ? 'btn-secondary btn-sm' : '{{ $overHero ? 'btn-on-dark btn-sm' : 'btn-secondary btn-sm' }}'">退出</button>
                    </form>
                @else
                    <a href="{{ config('visionsy.urls.auth') }}/login"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition"
                       :class="(scrolled || menu) ? 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' : '{{ $overHero ? 'text-white/80 hover:bg-white/10 hover:text-white' : 'text-ink-600 hover:bg-ink-100 hover:text-ink-900' }}'">登录</a>
                    <a href="{{ config('visionsy.urls.auth') }}/register"
                       :class="(scrolled || menu) ? 'btn-primary btn-sm' : '{{ $overHero ? 'btn-light btn-sm' : 'btn-primary btn-sm' }}'">注册账号</a>
                @endauth
            </nav>

            {{-- 移动端菜单按钮 --}}
            <button type="button" class="-mr-2 inline-flex h-10 w-10 items-center justify-center rounded-lg sm:hidden"
                    @click="menu = !menu" :aria-expanded="menu" aria-label="打开菜单"
                    :class="(scrolled || menu) ? 'text-ink-700' : '{{ $overHero ? 'text-white' : 'text-ink-700' }}'">
                <svg x-show="!menu" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="menu" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        {{-- 移动端抽屉 --}}
        <div x-show="menu" x-cloak x-transition.opacity.duration.150ms class="border-t border-ink-100 bg-white sm:hidden">
            <nav class="shell flex flex-col gap-1 py-4" aria-label="移动端导航">
                @auth
                    <a href="{{ config('visionsy.urls.auth') }}/dashboard" class="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 hover:bg-ink-100">控制台</a>
                    @if (auth()->user()->isSystemAdmin())
                        <a href="{{ config('visionsy.urls.auth') }}/admin" class="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 hover:bg-ink-100">管理后台</a>
                    @endif
                    <a href="{{ config('visionsy.urls.resourcespace') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 hover:bg-ink-100">媒体库</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button type="submit" class="btn-secondary w-full">退出登录</button>
                    </form>
                @else
                    <a href="{{ config('visionsy.urls.resourcespace') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 hover:bg-ink-100">媒体库</a>
                    <a href="{{ config('visionsy.urls.auth') }}/login" class="btn-secondary mt-1 w-full">登录</a>
                    <a href="{{ config('visionsy.urls.auth') }}/register" class="btn-primary w-full">注册账号</a>
                @endauth
            </nav>
        </div>
    </header>

    <main id="main" class="flex-1 {{ $overHero ? '' : 'pt-16' }}">
        @if (session('status'))
            <div class="shell pt-6">
                <div class="alert-success" role="status">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <x-site-footer />
</body>
</html>
