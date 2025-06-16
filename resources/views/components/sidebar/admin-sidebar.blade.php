<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="admin.dashboard" title="Dashboard"/>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.products.*" title="Produk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.products.index" title="Produk"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.categories.index" title="Detail Produk"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.stock.*" title="Stock">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.stock.index" title="Transaksi Barang Masuk"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.stock.create" title="Transaksi Barang Keluar"/>
         <x-sidebar-menu-dropdown-item-dashboard routeName="admin.stock-opname.index" title="Stock Opname"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.suppliers.*" title="Supplier">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.suppliers.index" title="Daftar Supplier"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.reports.*" title="Laporan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.reports.stock" title="Laporan Stok"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.reports.transactions" title="Laporan Barang Masuk Dan Keluar"/>
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>
-
