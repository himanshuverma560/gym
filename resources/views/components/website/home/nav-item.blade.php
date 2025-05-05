@php

    $mainMenu = menuGetBySlug('main-menu');

    $currentPath = request()->path();

    $currentPath = explode('/', $currentPath);
    $currentPath = end($currentPath);
@endphp

@foreach ($mainMenu as $menu)
    @php
        $currLink = explode('/', $menu['link']);
        $currLink = end($currLink);
        $isActive = $currLink === $currentPath;
        $link = $menu['link'];

        if (!isShopActive() && $currLink == 'shop') {
            continue;
        }
    @endphp
    @if (count($menu['child']))
        <li class="nav-item">
            <a class="nav-link" href="{{ $link == '#' ? 'javascript:;' : url($link) }}">{{ $menu['label'] }} <i
                    class="far fa-angle-down"></i></a>
            <ul class="wsus__droap_menu">
                @foreach ($menu['child'] as $child)
                    @php
                        $childLink = last(explode('/', $child['link']));
                        $isChildActive = $childLink === $currentPath;
                    @endphp
                    <li>
                        <a class="{{ $isChildActive ? 'active' : '' }}" aria-current="page"
                            href="{{ url($child['link']) }}">{{ $child['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        @if ($currLink != '')
            <li class="nav-item">
                <a href="/" class="nav-link {{ $isActive ? 'active' : '' }}" aria-current="page"
                    href="{{ url($link) }}">{{ $menu['label'] }}</a>
            </li>
        @else
            @if ($setting->home_theme == 'all')
                <li class="nav-item">
                    <a class="nav-link" href="/">{{ $menu['label'] }}</a>
                    
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link {{ $isActive ? 'active' : '' }}" aria-current="page"
                        href="{{ url($link) }}">{{ $menu['label'] }}</a>
                </li>
            @endif
        @endif
    @endif
@endforeach
