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
                <a href="{{ route('guru_masterpiece.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-voice"></i>
                    <div data-i18n="Notifications">Data User Guru Masterpiece</div>
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
                <a href="{{ route('materi_program.index') }}" class="menu-link">
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
        <span class="menu-header-text">Pengaturan Web</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('landing.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Atur Website Utama</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('lp_programs.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Atur Landing Page Program</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('lp_mitra.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Atur Landing Page Mitra</div>
        </a>
    </li>


    <li class="menu-item">
        <a href="{{ route('buat_form.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Buat Formulir</div>
        </a>
    </li>

    <li class="menu-item has-sub">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-book-open"></i>
            <div data-i18n="Book Masterpiece">Book Masterpiece</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('bonus.index') }}" class="menu-link">
                    <div data-i18n="Landing Utama">Bonus</div>
                </a>
            </li>


        </ul>
    </li>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Transaksi</span>
    </li>
    <li class="menu-item">
        <a href="{{ route('pesanan_masuk.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Orders Buku Masuk</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('pesanan_program.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Orders Program Masuk</div>
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
