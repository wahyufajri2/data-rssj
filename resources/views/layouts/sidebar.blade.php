@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
@endphp

<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200 dark:border-gray-800"
    x-data="{
        openSubmenus: {},
    
        init() {
            this.initializeActiveMenus();
        },
    
        initializeActiveMenus() {
            const currentPath = window.location.pathname;
    
            @foreach ($menuGroups as $groupIndex => $menuGroup)
                @foreach ($menuGroup['items'] as $itemIndex => $item)
                    @if (!empty($item['subItems']) && is_array($item['subItems']))
                        @foreach ($item['subItems'] as $subItem)
                            // PERBAIKAN: Cek apakah path saat ini DIAWALI dengan path submenu
                            // Tambahkan '/' di akhir path submenu agar tidak salah match (misal /user vs /users)
                            // Kecuali pathnya persis sama
                            if (this.isActive('{{ $subItem['path'] }}')) {
                                this.openSubmenus['{{ $groupIndex }}-{{ $itemIndex }}'] = true;
                            } @endforeach
            @endif
            @endforeach
            @endforeach
        },
    
        toggleSubmenu(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            const newState = !this.openSubmenus[key];
    
            // Close all other submenus when opening a new one (Optional, remove if you want multiple open)
            if (newState) {
                // Jika ingin hanya satu submenu yang terbuka, uncomment baris bawah
                // this.openSubmenus = {}; 
            }
    
            this.openSubmenus[key] = newState;
        },
    
        isSubmenuOpen(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            return this.openSubmenus[key] || false;
        },
    
        // PERBAIKAN UTAMA: Fungsi isActive yang lebih fleksibel
        isActive(path) {
            const currentPath = window.location.pathname;
    
            // Jika path sama persis
            if (currentPath === path) return true;
    
            // Jika path adalah root dashboard, harus exact match agar tidak aktif di semua halaman
            if (path === '/mahasiswa/dashboard' || path === '/admin/dashboard') {
                return currentPath === path;
            }
    
            // Untuk submenu lain, cek apakah currentPath dimulai dengan path menu
            // Contoh: currentPath = '/mahasiswa/ajukan-prestasi/form/1'
            //         path        = '/mahasiswa/ajukan-prestasi'
            //         Hasil       = true
            return currentPath.startsWith(path);
        }
    }"
    :class="{
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    <!-- Background Gradient & Wave -->
    <div class="absolute inset-0 z-[-1] bg-gradient-to-b from-green-50/50 to-white dark:from-green-900/20 dark:to-gray-900 overflow-hidden pointer-events-none transition-colors duration-300">
        <!-- Top Left Leaf (Soft) -->
        <div class="absolute top-0 left-0 w-48 h-48 opacity-30 dark:opacity-10">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full transform -translate-x-10 -translate-y-10">
                <path d="M0,0 L200,0 C200,0 180,60 120,100 C60,140 0,200 0,200 L0,0 Z" fill="url(#sidebar-leaf-1)" />
                <path d="M0,0 L150,0 C150,0 130,40 80,80 C30,120 0,150 0,150 L0,0 Z" fill="url(#sidebar-leaf-2)" />
                <defs>
                    <linearGradient id="sidebar-leaf-1" x1="0" y1="0" x2="200" y2="200" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#4ade80" stop-opacity="0.6"/>
                        <stop offset="1" stop-color="#166534" stop-opacity="0.8"/>
                    </linearGradient>
                    <linearGradient id="sidebar-leaf-2" x1="0" y1="0" x2="150" y2="150" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#a3e635" stop-opacity="0.7"/>
                        <stop offset="1" stop-color="#15803d" stop-opacity="0.9"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <!-- Bottom Right Leaf -->
        <div class="absolute bottom-0 right-0 w-48 h-48 opacity-30 dark:opacity-10">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full transform translate-x-10 translate-y-10 rotate-180">
                <path d="M0,0 L200,0 C200,0 180,60 120,100 C60,140 0,200 0,200 L0,0 Z" fill="url(#sidebar-leaf-1)" />
                <path d="M0,0 L150,0 C150,0 130,40 80,80 C30,120 0,150 0,150 L0,0 Z" fill="url(#sidebar-leaf-2)" />
            </svg>
        </div>
    </div>

    {{-- ... (Bagian Logo tetap sama) ... --}}
    <div class="pt-8 pb-7 flex"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
        'xl:justify-center' :
        'justify-start'">
        <a href="/">
            <img x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="dark:hidden" src="{{ asset('images/logo/leaf-text.svg') }}" alt="Logo RSSJ" width="140" height="35" />
            <img x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="hidden dark:block" src="{{ asset('images/logo/leaf-text.svg') }}" alt="Logo RSSJ" width="140" height="35" />
            <img x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                src="{{ asset('images/logo/leaf.svg') }}" alt="Logo RSSJ" width="32" height="32" />
        </a>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                @foreach ($menuGroups as $groupIndex => $menuGroup)
                    <div>
                        <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                            'lg:justify-center' : 'justify-start'">
                            <template
                                x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>{{ $menuGroup['title'] }}</span>
                            </template>
                            <template
                                x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                                        fill="currentColor" />
                                </svg>
                            </template>
                        </h2>

                        <ul class="flex flex-col gap-1">
                            @foreach ($menuGroup['items'] as $itemIndex => $item)
                                <li>
                                    {{-- JIKA ADA SUBMENU --}}
                                    @if (!empty($item['subItems']) && is_array($item['subItems']))
                                        {{-- 
                                            Cek apakah salah satu subItem aktif agar parent menu terbuka dan aktif.
                                            Kita gunakan PHP helper sementara di sini untuk logic class awal, 
                                            tapi AlpineJS akan menangani interaktivitasnya.
                                        --}}
                                        @php
                                            $isActiveParent = false;
                                            foreach ($item['subItems'] as $sub) {
                                                // Logic PHP check startWith
                                                if (str_starts_with(request()->path(), ltrim($sub['path'], '/'))) {
                                                    $isActiveParent = true;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <button @click="toggleSubmenu({{ $groupIndex }}, {{ $itemIndex }})"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <span
                                                :class="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>

                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                {{ $item['name'] }}
                                            </span>

                                            <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-auto w-5 h-5 transition-transform duration-200"
                                                :class="{
                                                    'rotate-180 text-brand-500': isSubmenuOpen({{ $groupIndex }},
                                                        {{ $itemIndex }})
                                                }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div
                                            x-show="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)">
                                            <ul class="mt-2 space-y-1 ml-9">
                                                @foreach ($item['subItems'] as $subItem)
                                                    <li>
                                                        <a href="{{ $subItem['path'] }}" class="menu-dropdown-item"
                                                            :class="isActive('{{ $subItem['path'] }}') ?
                                                                'menu-dropdown-item-active' :
                                                                'menu-dropdown-item-inactive'">
                                                            {{ $subItem['name'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        {{-- JIKA MENU TUNGGAL (Tanpa Submenu) --}}
                                        <a href="{{ $item['path'] }}" class="menu-item group"
                                            :class="[
                                                isActive('{{ $item['path'] }}') ? 'menu-item-active' :
                                                'menu-item-inactive',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store
                                                    .sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'
                                            ]">

                                            <span
                                                :class="isActive('{{ $item['path'] }}') ? 'menu-item-icon-active' :
                                                    'menu-item-icon-inactive'">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>

                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                {{ $item['name'] }}
                                            </span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>
</aside>

<div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)"
    class="fixed z-50 h-screen w-full bg-gray-900/50"></div>
