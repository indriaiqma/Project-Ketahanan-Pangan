@props(['eyebrow' => null, 'title', 'description' => null, 'compact' => false])

<section {{ $attributes->class(['page-head', 'page-head--compact' => $compact]) }}>
    <div>
        @isset($breadcrumb)
            <nav class="breadcrumb" aria-label="Breadcrumb">{{ $breadcrumb }}</nav>
        @endisset
        @if ($eyebrow)
            <div class="eyebrow">{{ $eyebrow }}</div>
        @endif
        <h1>{{ $title }}</h1>
        @if ($description)
            <p>{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="actions">{{ $actions }}</div>
    @endisset
</section>
