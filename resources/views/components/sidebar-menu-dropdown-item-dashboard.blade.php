@props(['icon' => null, 'routeName' => null, 'title' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="text-base text-black-900 rounded-lg flex items-center p-2 group hover:bg-black-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700
    {{ request()->routeIs($routeName) ? 'bg-black-200 dark:bg-black-700' : '' }}">
        {{ $title }}
    </a>
</li>
