@extends('layouts.app')

@section('title', 'VisionSY · 校园媒体资产管理系统')
@section('over-hero', '1')

@section('content')
    {{-- ============================ HERO ============================ --}}
    <section class="relative min-h-[92svh] overflow-hidden bg-ink-950 text-white"
             x-data="heroCarousel(4)">
        {{-- 影像轮播背景 --}}
        <div class="absolute inset-0" aria-hidden="true">
            @foreach (['slide-1', 'slide-2', 'slide-3', 'slide-4'] as $i => $slide)
                <div class="absolute inset-0 bg-cover bg-center transition-all duration-[1200ms] ease-out"
                     :class="active === {{ $i }} ? 'opacity-100 scale-100' : 'opacity-0 scale-105'"
                     style="background-image:url('{{ asset('images/slides/'.$slide.'.svg') }}')"></div>
            @endforeach
            {{-- 压暗渐变，保证文字可读 --}}
            <div class="absolute inset-0 bg-gradient-to-r from-ink-950 via-ink-950/80 to-ink-950/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-transparent to-ink-950/40"></div>
            <div class="absolute inset-0 bg-grid-dark opacity-40"></div>
        </div>

        <div class="relative flex min-h-[92svh] items-end">
            <div class="shell w-full pb-20 pt-32 sm:pb-24">
                <div class="max-w-3xl animate-fade-up">
                    <p class="eyebrow-light mb-6">VisionSY · 宣传部数字门户</p>
                    <h1 class="h-hero text-white">
                        校园影像，<br class="hidden sm:block">
                        <span class="text-gradient">统一归档、分级取用</span>。
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/70 sm:text-lg">
                        面向学校宣传部、官微编辑老师与全校师生的校园媒体资产管理系统。素材集中存储、元数据可检索；
                        原图与水印图按角色分级下发，校园网环境一次登录即可完成账号激活。
                    </p>

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ config('visionsy.urls.auth') }}/dashboard" class="btn-light">进入控制台</a>
                        @else
                            <a href="{{ config('visionsy.urls.auth') }}/register" class="btn-light">邮箱注册</a>
                            <a href="{{ config('visionsy.urls.auth') }}/login" class="btn-on-dark">已有账号，登录</a>
                        @endauth
                        <a href="#capabilities" class="btn-on-dark">了解平台</a>
                    </div>

                    <div class="mt-12 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-medium uppercase tracking-[0.18em] text-white/45">
                        <span>Photo</span><span aria-hidden="true">·</span>
                        <span>Video</span><span aria-hidden="true">·</span>
                        <span>Design</span><span aria-hidden="true">·</span>
                        <span>Resource</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 轮播控制 --}}
        <div class="absolute bottom-8 right-5 z-10 flex items-center gap-3 sm:right-8" aria-label="影像轮播控制">
            <div class="flex items-center gap-2">
                @foreach (range(0, 3) as $i)
                    <button type="button" @click="go({{ $i }})"
                            class="h-1.5 rounded-full transition-all duration-300"
                            :class="active === {{ $i }} ? 'w-7 bg-white' : 'w-1.5 bg-white/40 hover:bg-white/70'"
                            aria-label="切换到第 {{ $i + 1 }} 张"></button>
                @endforeach
            </div>
            <div class="flex gap-1.5">
                <button type="button" @click="prev()" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 bg-white/5 text-white/80 transition hover:bg-white/15" aria-label="上一张">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" @click="next()" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 bg-white/5 text-white/80 transition hover:bg-white/15" aria-label="下一张">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </section>

    {{-- 信任信息条 --}}
    <section class="border-b border-ink-100 bg-white">
        <div class="shell grid gap-px py-8 sm:grid-cols-3">
            @php
                $trust = [
                    ['k' => '公开展示', 'v' => '校园影像作品集与团队项目第一印象'],
                    ['k' => '成员入口', 'v' => '登录后进入服务导航与使用指南'],
                    ['k' => '校园网激活', 'v' => '一次校内登录即可解锁媒体库'],
                ];
            @endphp
            @foreach ($trust as $t)
                <div class="px-2 py-1 text-center sm:text-left">
                    <p class="text-sm font-semibold text-ink-900">{{ $t['k'] }}</p>
                    <p class="mt-1 text-sm text-ink-500">{{ $t['v'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================ 能力 ============================ --}}
    <section id="capabilities" class="bg-ink-50">
        <div class="shell py-20 sm:py-24">
            <x-section-heading eyebrow="Platform">
                <x-slot:title>一套自托管平台，解决素材散落与外流</x-slot:title>
                <x-slot:description>统一归档、分级管理、实名准入、零客户端。师生通过浏览器直接访问，运维经带外专网管理。</x-slot:description>
            </x-section-heading>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $features = [
                        ['title' => '分级下载', 'desc' => '宣传部与官微老师下载无水印原图，普通师生获取带水印压缩图，权限由用户组自动决定。', 'path' => 'M3 16.5V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18v-1.5M12 3v13.5m0 0-3.75-3.75M12 16.5l3.75-3.75'],
                        ['title' => '自动水印', 'desc' => '预览与压缩图实时叠加水印，原图仅授权账号可取，素材外流可追溯。', 'path' => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.96 11.96 0 0 1 3.6 6.4 12 12 0 0 0 12 21a12 12 0 0 0 8.4-14.6A11.96 11.96 0 0 1 12 2.714Z'],
                        ['title' => '校园 IP 激活', 'desc' => '邮箱自助注册后，在校园网环境登录一次即自动激活，把账号基本限定在校内人员。', 'path' => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.95 8.95 0 0 0 4.5-1.2M3.6 9h16.8M3.6 15h16.8M12 3a13.4 13.4 0 0 1 0 18 13.4 13.4 0 0 1 0-18Z'],
                        ['title' => '统一媒体库', 'desc' => '官网账号一键 SSO 免密进入 ResourceSpace 媒体库，角色与用户组自动同步。', 'path' => 'M2.25 12.76V19.5a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25v-6.74M21 8.25 12 13 3 8.25 12 3.5l9 4.75Z'],
                    ];
                @endphp
                @foreach ($features as $f)
                    <div class="card card-hover group p-6">
                        <x-feature-icon :path="$f['path']" class="transition group-hover:bg-brand-600 group-hover:text-white group-hover:ring-brand-600" />
                        <h3 class="mt-5 h-card">{{ $f['title'] }}</h3>
                        <p class="mt-2 prose-muted">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================ 面向不同角色 ============================ --}}
    <section class="border-t border-ink-100 bg-white">
        <div class="shell py-20 sm:py-24">
            <div class="grid gap-12 lg:grid-cols-2">
                <x-section-heading eyebrow="Who it's for">
                    <x-slot:title>为不同角色而设计</x-slot:title>
                    <x-slot:description>从拍摄、归档到分发，每一类用户都有清晰的权限边界与使用路径。</x-slot:description>
                </x-section-heading>

                <div class="grid gap-4 sm:grid-cols-2">
                    @php
                        $roles = [
                            ['name' => '普通师生', 'tone' => 'amber', 'desc' => '邮箱注册 + 校园网激活，浏览并下载带水印压缩图。'],
                            ['name' => '宣传部成员', 'tone' => 'blue', 'desc' => '实名账号，上传素材、下载无水印原图。'],
                            ['name' => '官微编辑老师', 'tone' => 'green', 'desc' => '实名账号，下载无水印原图用于官方发布。'],
                            ['name' => '系统管理员', 'tone' => 'gray', 'desc' => '管理用户、校园网段、OAuth 客户端与审计日志。'],
                        ];
                    @endphp
                    @foreach ($roles as $r)
                        <div class="card-quiet p-5">
                            <x-badge :tone="$r['tone']">{{ $r['name'] }}</x-badge>
                            <p class="mt-3 prose-muted">{{ $r['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ 项目展示 ============================ --}}
    <section id="projects" class="bg-ink-950 text-white">
        <div class="shell py-20 sm:py-24">
            <x-section-heading eyebrow="Selected Work" invert>
                <x-slot:title>把资源、活动与作品集中呈现</x-slot:title>
                <x-slot:description>校园活动图库、宣传片、大型活动影像记录 —— 沉淀为可公开展示、可长期检索的影像资产。</x-slot:description>
            </x-section-heading>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @php
                    $projects = [
                        ['tag' => 'ResourceSpace', 'title' => '校园活动图库', 'desc' => '集中归档照片、视频与设计素材，便于成员检索、复用与交接。', 'slide' => 'slide-1'],
                        ['tag' => 'Video', 'title' => '宣传片与专题短片', 'desc' => '围绕学校品牌、重大活动与人物故事，制作更具传播力的视觉内容。', 'slide' => 'slide-4'],
                        ['tag' => 'Event', 'title' => '大型活动影像记录', 'desc' => '为典礼、比赛、晚会与展演提供拍摄支持，沉淀可展示的作品集。', 'slide' => 'slide-3'],
                    ];
                @endphp
                @foreach ($projects as $p)
                    <article class="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] transition duration-300 hover:-translate-y-1 hover:border-white/20">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('images/slides/'.$p['slide'].'.svg') }}" alt="{{ $p['title'] }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-6">
                            <span class="inline-flex rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-medium text-white/80">{{ $p['tag'] }}</span>
                            <h3 class="mt-3 text-lg font-semibold tracking-tight">{{ $p['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/55">{{ $p['desc'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================ 三步流程 ============================ --}}
    <section class="border-t border-ink-100 bg-white">
        <div class="shell py-20 sm:py-24">
            <x-section-heading eyebrow="How it works" center>
                <x-slot:title>三步开始使用</x-slot:title>
            </x-section-heading>

            <div class="relative mx-auto mt-14 grid max-w-4xl gap-8 sm:grid-cols-3">
                <div class="absolute left-0 right-0 top-5 hidden h-px bg-gradient-to-r from-transparent via-ink-200 to-transparent sm:block" aria-hidden="true"></div>
                @php
                    $steps = [
                        ['t' => '注册与验证', 'd' => '使用邮箱注册账号并完成邮箱验证。'],
                        ['t' => '校园网激活', 'd' => '连接校园网后登录官网一次，系统自动完成账号激活。'],
                        ['t' => '进入媒体库', 'd' => '点击进入媒体库，免密直达 media.example.com 检索与下载。'],
                    ];
                @endphp
                @foreach ($steps as $i => $s)
                    <div class="relative text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full border border-ink-200 bg-white text-sm font-semibold text-brand-600 shadow-soft">{{ $i + 1 }}</div>
                        <h3 class="mt-4 h-card">{{ $s['t'] }}</h3>
                        <p class="mx-auto mt-2 max-w-xs prose-muted">{{ $s['d'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                @guest
                    <a href="{{ config('visionsy.urls.auth') }}/register" class="btn-primary">立即注册</a>
                @else
                    <a href="{{ config('visionsy.urls.auth') }}/dashboard" class="btn-primary">前往控制台</a>
                @endguest
            </div>
        </div>
    </section>

    {{-- ============================ CTA ============================ --}}
    <section class="bg-ink-50">
        <div class="shell pb-24 pt-4">
            <div class="relative overflow-hidden rounded-4xl bg-ink-950 px-8 py-14 text-center sm:px-12">
                <div class="absolute inset-0 bg-[radial-gradient(40rem_24rem_at_50%_-20%,rgba(53,118,245,0.4),transparent)]" aria-hidden="true"></div>
                <div class="relative mx-auto max-w-2xl">
                    <h2 class="h-section text-white">准备好集中管理校园影像了吗？</h2>
                    <p class="mt-4 text-base leading-relaxed text-white/60">注册账号，连接校园网激活，即可免密进入 ResourceSpace 媒体库。</p>
                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        @guest
                            <a href="{{ config('visionsy.urls.auth') }}/register" class="btn-light">邮箱注册</a>
                            <a href="{{ config('visionsy.urls.auth') }}/login" class="btn-on-dark">登录</a>
                        @else
                            <a href="{{ config('visionsy.urls.auth') }}/dashboard" class="btn-light">进入控制台</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
