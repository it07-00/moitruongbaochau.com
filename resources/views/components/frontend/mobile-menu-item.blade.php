@props(['item'])

<li class="{{ $item->children->isNotEmpty() ? 'has-submenu' : '' }}">
  <div class="header-mobile-row">
    <a href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}" @if ($item->target === '_blank') rel="noopener noreferrer" @endif class="mobile-nav-link">{{ $item->label }}</a>
    @if ($item->children->isNotEmpty())
      <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-controls="mobile-submenu-{{ $item->id }}" aria-label="Mở mục {{ $item->label }}">
        <svg class="submenu-chevron" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6" /></svg>
      </button>
    @endif
  </div>
  @if ($item->children->isNotEmpty())
    <ul id="mobile-submenu-{{ $item->id }}" class="submenu hidden header-mobile-submenu">
      @foreach ($item->children as $child)
        <x-frontend.mobile-menu-item :item="$child" />
      @endforeach
    </ul>
  @endif
</li>
