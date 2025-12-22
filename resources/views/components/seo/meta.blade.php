{{-- SEO Meta Tags Component --}}
@php
    use App\Facades\Seo;
@endphp

@push('seo')
    {!! Seo::renderMetaTags() !!}
@endpush

@push('schema')
    {!! Seo::renderSchema() !!}
@endpush
