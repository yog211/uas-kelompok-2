<div class="quixnav">
  <div class="quixnav-scroll">
    <ul class="metismenu" id="menu">
      <li class="nav-label first">Main Menu</li>

      <li><a href="{{route('dashboard')}}" aria-expanded="false"><i class="icon icon-chart-bar-33"></i><span
        class="nav-text">Dashboard</span></a></li>

      <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
        class="icon icon-app-store"></i><span class="nav-text">Menu Uang</span></a>
        <ul aria-expanded="false">
          <li><a href="{{route('uang_masuk.index')}}">Uang Masuk</a></li>
          <li><a href="{{route('uang_keluar.index')}}">Uang Keluar</a></li>
        </ul>
      </li>

    </ul>
  </div>
</div>