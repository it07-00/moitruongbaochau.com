@props(['items'])

<ul class="header-submenu-list">
  @foreach ($items as $item)
    <li class="{{ $item->children->isNotEmpty() ? 'header-submenu-group' : '' }}">
      <a href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}" @if ($item->target === '_blank') rel="noopener noreferrer" @endif>{{ $item->label }}</a>
      @if ($item->children->isNotEmpty())
        <x-frontend.desktop-menu-children :items="$item->children" />
      @endif
    </li>
  @endforeach
</ul>
