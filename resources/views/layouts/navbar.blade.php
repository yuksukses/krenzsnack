<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle img-logo" src="{{ url($setting->path_logo) }}" width="50" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong
                                    class="font-bold">{{ strtoupper(auth()->user()->name) }}</strong>
                            </span> <span class="text-muted text-xs block">{{ ucwords(auth()->user()->level) }}<b
                                    class="caret"></b></span> </span>
                                  
                                              <a href="#"><i class="fa fa-circle text-sm text-success"></i> online</a>

                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('user.profil') }}">Profil</a></li>
                    </ul>
                </div>
                <div class="logo-element">

                    @php
                    $words = explode(' ', $setting->nama_perusahaan);
                    $word = '';
                    foreach ($words as $w) {
                    $word .= $w[0];
                    }
                    @endphp
                    {{ $word }}
                </div>
            </li>
            <li {{{ (Request::is('dashboard') ? 'class=active' : '') }}}>
                <a href="{{ route('dashboard') }}"><i class="fa fa-tachometer"></i> <span
                        class="nav-label">Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->level == 'admin')
            <li>
                <strong class="m-sm nav-label" style="color: lightgray">MASTER</strong>
            </li>
            <li {{{ (Request::is('kategori') ? 'class=active' : '') }}}>
                <a href="{{ route('kategori.index') }}"><i class="fa fa-cube"></i> <span
                        class="nav-label">Kategori</span>
                </a>
            </li>
            <li {{{ (Request::is('produk') ? 'class=active' : '') }}}>
                <a href="{{ route('produk.index') }}"><i class="fa fa-cubes"></i> <span
                        class="nav-label">Produk</span></a>
            </li>
            <li {{{ (Request::is('member') ? 'class=active' : '') }}}>
                <a href="{{ route('member.index') }}"><i class="fa fa-vcard"></i> <span
                        class="nav-label">Member</span></a>
            </li>
            <li {{{ (Request::is('supplier') ? 'class=active' : '') }}}>
                <a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> <span
                        class="nav-label">Supplier</span></a>
            </li>
            <li>
                <strong class="m-sm nav-label" style="color: lightgray">TRANSAKSI</strong>
            </li>
            <li {{{ (Request::is('transaksi') ? 'class=active' : '') }}}>
                <a href="{{ route('transaksi.baru') }}"><i class="fa fa-calculator"></i> <span class="nav-label">Point
                        Of Sales
                    </span></a>
            </li>
            <li {{{ (Request::is('penjualan') ? 'class=active' : '') }}}>
                <a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> <span
                        class="nav-label">Data
                        Penjualan</span></a>
            </li>
            <li {{{ (Request::is('pembelian') ? 'class=active' : '') }}}>
                <a href="{{ route('pembelian.index') }}"><i class="fa fa-download"></i> <span
                        class="nav-label">Pembelian Stok Produk</span></a>
            </li>
            <li {{{ (Request::is('pengeluaran') ? 'class=active' : '') }}}>
                <a href="{{ route('pengeluaran.index') }}"><i class="fa fa-money"></i> <span
                        class="nav-label">Pengeluaran Toko</span>
                </a>
            </li>
            <li {{{ (Request::is('pemasukan') ? 'class=active' : '') }}}>
                <a href="{{ route('pemasukan.index') }}"><i class="fa fa-money"></i> <span
                        class="nav-label">Pemasukan Toko</span>
                </a>
            </li>
            {{-- <li {{{ (Request::is('transaksi') ? 'class=active' : '') }}}>
            <a href="{{ route('transaksi.index') }}"><i class="fa fa-shopping-cart"></i> <span
                    class="nav-label">Transaksi
                    Aktif</span></a>
            </li> --}}
            <li>
                <strong class="m-sm nav-label" style="color: lightgray">REPORT</strong>
            </li>
            <li {{{ (Request::is('laporan') ? 'class=active' : '') }}}>
                <a href="{{ route('laporan.index') }}"><i class="fa fa-newspaper-o"></i> <span class="nav-label">Laporan
                        Transaksi</span>
                </a>
            </li>
            <li {{{ (Request::is('stok') ? 'class=active' : '') }}}>
                <a href="{{ route('produk.stok') }}"><i class="fa fa-cubes"></i> <span class="nav-label">laporan Stok
                        Barang</span></a>
            </li>
            <li>
                <strong class="m-sm nav-label" style="color: lightgray">PENGATURAN</strong>
            </li>
            <li {{{ (Request::is('user') ? 'class=active' : '') }}}>
                <a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span class="nav-label">User</span>
                </a>
            </li>
            <li {{{ (Request::is('setting') ? 'class=active' : '') }}}>
                <a href="{{ route('setting.index') }}"><i class="fa fa-cogs"></i> <span class="nav-label">Setting</span>
                </a>
            </li>
            @else
            <li {{{ (Request::is('transaksi') ? 'class=active' : '') }}}>
                <a href="{{ route('transaksi.baru') }}"><i class="fa fa-calculator"></i> <span class="nav-label">Point
                        Of Sales
                    </span></a>
            </li>
            <li {{{ (Request::is('penjualan') ? 'class=active' : '') }}}>
                <a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> <span
                        class="nav-label">Data
                        Penjualan</span></a>
            </li>
            @endif
        </ul>

    </div>
</nav>
