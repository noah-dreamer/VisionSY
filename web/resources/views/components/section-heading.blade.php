@props(['eyebrow' => null, 'invert' => false, 'center' => false])
<div class="{{ $center ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if($eyebrow)
        <p class="{{ $invert ? 'eyebrow-light' : 'eyebrow' }} mb-4">{{ $eyebrow }}</p>
    @endif
    <h2 class="h-section {{ $invert ? 'text-white' : 'text-ink-950' }}">{{ $title ?? $slot }}</h2>
    @isset($description)
        <p class="mt-4 text-base leading-relaxed {{ $invert ? 'text-white/60' : 'text-ink-600' }}">{{ $description }}</p>
    @endisset
</div>
