<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="manager.dashboard" title="Dashboard" />
    <x-sidebar-menu-dropdown-dashboard routeName="stock.opname.*" title="Opname Stok">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock.opname.index" title="Daftar Opname" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock.opname.masuk" title="Opname Masuk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock.opname.keluar" title="Opname Keluar" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.reports.*" title="Laporan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.reports.index" title="Laporan Manager" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.settings.*" title="Pengaturan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.settings.index" title="Pengaturan Manager" />
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>