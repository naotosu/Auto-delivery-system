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
              <a href="/incoming">入荷品登録</a>
            </li>
            </div>
            <div class="icon">
            <li>            
              <a href="/order">注文書登録</a>
            </li>
            </div>
            <div class="icon">
            <li>
              <a href="/compulsion">出荷指示強制編集</a>
            </li>
            </div>
            <div class="icon">
            <li>
              <a href="/temporaries">臨時出荷指示出力</a>
            </li>
            </div>
            <div class="icon"> 
            <li>
              <a href="/stock">在庫一覧・出荷実績</a>
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



