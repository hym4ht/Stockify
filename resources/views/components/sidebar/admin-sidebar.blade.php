<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="admin.dashboard" title="Dashboard" />
    <x-sidebar-menu-dropdown-dashboard routeName="admin.products.*" title="Produk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.products.index" title="Daftar Produk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.product_attributes.index" title="Atribut produk" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.categories.index" title="Kategori Produk" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.transaksi.*" title="Transaksi">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.transaksi.index" title="Riwayat Transaksi" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.transaksi.create" title="Tambah Transaksi" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.stock.*" title="Stock">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.stock.info" title="Info Stock" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.stock.settings" title="Pengaturan Stock Minimum" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.suppliers.*" title="Supplier">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.suppliers.index" title="Daftar Supplier" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.users.*" title="Pengguna">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.users.index" title="Daftar Pengguna" />
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="admin.reports.*" title="Laporan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.reports.stock" title="Laporan Stok" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.reports.transactions" title="Laporan Transaksi" />
        <x-sidebar-menu-dropdown-item-dashboard routeName="admin.reports.user_activity"
            title="Laporan Aktivitas Pengguna" />
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>