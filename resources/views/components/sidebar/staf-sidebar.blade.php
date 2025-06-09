<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard" title="Dashboard" />
    <x-sidebar-menu-dropdown-dashboard routeName="dashboard" title="Stok">
        <x-sidebar-menu-dropdown-item-dashboard routeName="dashboard" title="Barang Masuk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="dashboard" title="Barang Keluar" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="stock.opname.index" title="Opname">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock.opname.masuk" title="Opname Masuk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock.opname.keluar" title="Opname Keluar" />
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>