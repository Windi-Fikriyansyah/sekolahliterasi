<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
        <a href="{{ route('owner.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Data Master</span>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Account Settings">Data Master</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-id-card"></i>
                    <div data-i18n="Notifications">Data Admin</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('pengguna.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Notifications">Data User</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('kategori.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Notifications">Data Kategori</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('kategori_buku.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Notifications">Data Kategori Buku</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manajemen Produk Digital</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('produk.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Data Produk Digital</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Account Settings">Data Detail</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('materi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-id-card"></i>
                    <div data-i18n="Notifications">Data E-book & Kelas Video</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Notifications">Data Program</div>
                </a>
            </li>
        </ul>
    </li>


    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manajemen Buku Fisik</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('produk_buku.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Data Buku Fisik</div>
        </a>
    </li>





    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Laporan</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('withdraw.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Laporan Withdrawl</div>
        </a>
    </li>


</ul>
