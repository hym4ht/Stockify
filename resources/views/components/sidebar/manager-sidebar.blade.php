<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="manager.dashboard" title="Dashboard" />
    <x-sidebar-menu-dropdown-dashboard routeName="manager.stok.*" title="Stok">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.stok.transaksi.masuk"
            title="Transaksi barang masuk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.stok.transaksi.keluar"
            title="Transaksi barang keluar" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.stok.opname.index" title="Stock opname" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.products.*" title="Produk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.products.index" title="Melihat daftar produk" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.suppliers.*" title="Supplier">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.suppliers.index" title="Daftar Supplier" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.reports.*" title="Laporan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.reports.index" title="Laporan Manager" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="manager.settings.*" title="Pengaturan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="manager.settings.index" title="Pengaturan Manager" />
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>
