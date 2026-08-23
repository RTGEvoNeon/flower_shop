@props([
    'src',
    'alt' => '',
    'loading' => 'lazy',
])

@php
    $webp = \App\Models\Product::webpForUrl($src);
    $hasWebp = $webp !== $src;
@endphp

<picture>
    @if($hasWebp)
        <source srcset="{{ $webp }}" type="image/webp">
    @endif
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        loading="{{ $loading }}"
        decoding="async"
        {{ $attributes }}
    >
</picture>
