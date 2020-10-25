@extends('common')

@section('content')
@include('header')
  <div class="top-page">
    <div class="top_title">
      <h1>オートデリバリーシステム　TOP</h1>
      <h2>毎朝の事務作業から解放されるシステム　倉庫業様、商社様に！</h2>
      <h2>その効果は・・・・</h2>
      <img src="/Image/under.png" class="top_arrow">
      <h2>私の現職であれば、3時間/日　× 10人　× 20日間　＝　600時間の改善！</h2>
    </div>

       
    <div class = "description">
      <div class = "description-set">
        <div class="description-main">
          <div class = "description-title">
            <p>例えば導入前の朝は</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>注文書</li>
              <li>在庫</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>毎朝　8：30〜11：00 出荷指示作成</p>
            <p>先入先出、複雑なロット管理、手計算 etc</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>出荷指示</li>
            </ul>
            <img src="/Image/isogashii_woman.png" class = "img">
          </div>
        </div>
      
        <div class="description-main">
          <img src="/Image/under.png" class="under_arrow">
          <div class = "description-title">
            <p>導入後は・・・！</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>注文書</li>
              <li>在庫</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>自動で出荷指示書を作ります！</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>出荷指示</li>
            </ul>
            <img src="/Image/computer_laptop.png" class = "img">
            <img src="/Image/pose_happy_businesswoman_banzai.png" class = "img">
          </div>
        </div>
      </div>

      <div class = "description-set">
        <div class="description-main">
          <div class = "description-title">
            <p>例えば導入前の在庫管理は</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>入荷品 新しい</li>
              <li>入荷品 古い</li>
              <li>入荷品 新しい</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>自分で注文した物が入庫した際</p>
            <p>工場の製造日順とは限りません</p>
            <p>でも客先への先入先出は絶対です</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>在庫</li>
            </ul>
            <img src="/Image/necchusyou_face_girl5.png" class = "img">
          </div>
        </div>
      
        <div class="description-main">
          <img src="/Image/under.png" class="under_arrow">
          <div class = "description-title">
            <p>導入後は・・・！</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>順不動在庫</li>
              <li>■優先順位<br>チャージ<br>注文コード<br>etc</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>複雑なロット管理、先入先出、自動です！</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>出荷指示</li>
            </ul>
            <img src="/Image/computer_laptop.png" class = "img">
            <img src="/Image/pose_happy_businesswoman_banzai.png" class = "img">
          </div>
        </div>
      </div>

        <div class="description-main">
          <div class = "description-title">
            <p>例えば導入前の注文は</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>注文変更</li>
              <li>注文変更</li>
              <li>注文変更</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>何度も注文書が変わり、どれが最新か混乱する</p>
            <p>出荷直前まで何度も変更になることも珍しくない</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>最新は？</li>
            </ul>
            <img src="/Image/necchusyou_face_girl5.png" class = "img">
          </div>
        </div>
      
        <div class="description-main">
          <img src="/Image/under.png" class="under_arrow">
          <div class = "description-title">
            <p>導入後は・・・！</p>
          </div> 
          <div class = "description-left">
            <ul>
              <li>注文DB</li>
            </ul>
          </div>

          <div class = "description-middle">
            <img src="/Image/right.png" class="right_arrow">
            <p>注文データをDB登録しておけば</p>
            <p>最新の注文が簡単に管理出来ます！</p>
          </div>

          <div class = "description-right">
            <ul>
              <li>出荷指示</li>
            </ul>
            
            <img src="/Image/computer_laptop.png" class = "img">
            <img src="/Image/pose_happy_businesswoman_banzai.png" class = "img">
          </div>
        </div>

        <img src="/Image/under.png" class="under_arrow">
        <p>今すぐ使ってみよう！</p>
        <div class="top-icon">
          <a href="/csv_imports">CSVデータ登録 ＆ 出荷指示確認</a>
        </div>
    </div>
    <div class="top-footer">
      <p>本Webアプリケーションは、試作版です。今後下記の機能を実装予定です。</p>
      <ul>
          <li>ログインアカウント単位での権限作成、管理者権限（現在は権限未実装）</li>
          <li>アカウントに対するCRUD実装</li>
          <li>アイテム、商流データベースのCRUD実装</li>
          <li>機能改善希望の投稿掲示板設置</li>
          <li>古いスプレッドシートの自動消去</li>
          <li>発注元・発注先とAPI連携し、CSVファイル、スプレッドシートを不要にする</li>
      </ul>
    </div>
  </div>

@include('footer')
@endsection


