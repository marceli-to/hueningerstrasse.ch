@php
  $appName = config('app.name', 'Hüningerstrasse 40');
  $defaultDescription = config('app.description', 'An der Hüningerstrasse 40 in Basel entsteht nach einem hochwertigen Umbau ein attraktives Wohn- und Gewerbeprojekt im Herzen des Volta-Quartiers.');
@endphp
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="view-transition" content="same-origin">
<title>@hasSection('meta_title')@yield('meta_title') – {{ $appName }}@else{{ $appName }} – Wohnen und Arbeiten im Volta-Quartier Basel {{-- --}}@endif</title>
<meta name="description" content="@yield('meta_description', $defaultDescription)">
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="{{ $appName }}" />
<meta property="og:title" content="@hasSection('meta_title')@yield('meta_title') – {{ $appName }}@else{{ $appName }}@endif" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ asset('img/startbild.jpg') }}" />
<meta property="og:description" content="@yield('meta_description', $defaultDescription)" />
<meta property="og:site_name" content="{{ $appName }}" />
<meta property="og:locale" content="de_CH" />
<meta name="twitter:card" content="summary_large_image" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
