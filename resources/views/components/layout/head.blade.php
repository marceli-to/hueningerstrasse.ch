@php
  $appName = config('app.name', 'Hüningerstrasse 40');
  $defaultDescription = config('app.description', 'An der Hüningerstrasse 40 in Basel entsteht nach einem hochwertigen Umbau ein attraktives Wohn- und Gewerbeprojekt im Herzen des Volta-Quartiers.');
  $pageTitle = trim($__env->yieldContent('meta_title'));
  $fullTitle = $pageTitle !== '' ? $pageTitle.' – '.$appName : $appName.' – Wohnen und Arbeiten im Volta-Quartier Basel';
  $ogTitle = $pageTitle !== '' ? $pageTitle.' – '.$appName : $appName;
  $description = trim($__env->yieldContent('meta_description', $defaultDescription));
  $ogImage = asset('img/og-image.jpg');
  $currentUrl = url()->current();
@endphp
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $currentUrl }}" />
<meta name="theme-color" content="#e0e9eb" />

{{-- Favicons --}}
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" href="/favicon.ico" sizes="32x32" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="{{ $appName }}" />

{{-- Open Graph --}}
<meta property="og:title" content="{{ $ogTitle }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $currentUrl }}" />
<meta property="og:site_name" content="{{ $appName }}" />
<meta property="og:locale" content="de_CH" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:secure_url" content="{{ $ogImage }}" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Hüningerstrasse 40 – Wohn- und Gewerbeprojekt im Volta-Quartier Basel" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $ogTitle }}" />
<meta name="twitter:description" content="{{ $description }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />
<meta name="twitter:image:alt" content="Hüningerstrasse 40 – Wohn- und Gewerbeprojekt im Volta-Quartier Basel" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Google Analytics (nur wenn GOOGLE_ANALYTICS_ID gesetzt ist) --}}
@if ($gaId = config('services.google_analytics.id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $gaId }}');
</script>
@endif
</head>
