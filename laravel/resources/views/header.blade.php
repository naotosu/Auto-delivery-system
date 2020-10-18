@section('header')

      <div class="header">
        <div class="header-menus">

          <ul>
            <div class="icon">
            <li>
              <a href="/">TOP</a>
            </li>
            </div>
            <div class="icon">
            <li>
              <a href="/csv_imports">CSVデータ登録</a>
            </li>
            </div>
            <div class="icon">
            <li>            
              <a href="/orders">注文データ照会</a>
            </li>
            </div>
            <div class="icon"> 
            <li>
              <a href="/inventories">在庫一覧・出荷実績</a>
            </li>
            </div>
            <div class="icon">
            <li>
              <a href="/shipment/temporaries">臨時出荷指示</a>
            </li>
            </div>
            <div class="icon">
            <li>
              <a href="/inventory/shipment/cancels">出荷指示取消</a>
            </li>
            </div>
          </ul>
        </div>
        <div class="header-right">


              @guest                            
              @else                        
                <div class="icon">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('ログアウト') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
              @endguest
            
              @if (Route::has('login'))
                
                    @auth
                      <div class="icon">
                        <a href="{{ url('/home') }}">ユーザー：{{ Auth::user()->name }}</a>
                      </div>
                    @else
                      <div class="icon">
                        <a href="{{ route('login') }}">ログイン</a>
                      </div>

                        @if (Route::has('register'))
                      <div class="icon">
                        <a href="{{ route('register') }}">ユーザー登録</a>
                        @endif
                      </div>
                    @endauth
                </div>
              @endif
            </div>
        </div>
      </div>
 
 
@endsection



