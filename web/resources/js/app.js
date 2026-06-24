import Alpine from 'alpinejs';

/**
 * Hero 影像轮播。
 * 用法：x-data="heroCarousel(4)" —— 传入幻灯片数量。
 * 自动尊重 prefers-reduced-motion（关闭时不自动播放）。
 */
Alpine.data('heroCarousel', (count = 1, interval = 6000) => ({
    active: 0,
    count,
    timer: null,
    init() {
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!reduce && this.count > 1) {
            this.start();
            // 标签页隐藏时暂停，避免无谓动画
            document.addEventListener('visibilitychange', () => {
                document.hidden ? this.stop() : this.start();
            });
        }
    },
    start() {
        this.stop();
        this.timer = setInterval(() => this.next(), interval);
    },
    stop() {
        if (this.timer) clearInterval(this.timer);
        this.timer = null;
    },
    go(i) {
        this.active = (i + this.count) % this.count;
        if (this.timer) this.start();
    },
    next() { this.go(this.active + 1); },
    prev() { this.go(this.active - 1); },
}));

window.Alpine = Alpine;
Alpine.start();
