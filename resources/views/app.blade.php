<x-layout.head />
@if (!request()->routeIs('page.home'))
<x-layout.header />
@endif
<x-layout.main>
  @yield('content')
</x-layout.main>
<x-layout.footer />