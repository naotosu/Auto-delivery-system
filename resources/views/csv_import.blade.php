@extends('common')

@section('content')
@include('header')
  
    <div class="main">
        @if (session('flash_message'))
          <div class="flash_message">
              {{ session('flash_message') }}
          </div>
        @endif
          <H3>CSVデータ登録</H3>
            <form role="form" method="post" action="{{url('/order_imports')}}" enctype="multipart/form-data">
          <p>■注文データ登録(CSVファイルを選んで下さい)</p>
                {{ csrf_field() }}
          <p><input type="file" name="csv_file" id="csv_file">
            <button type="submit" class="btn btn-default btn-success">登録</button></p>     
        </form><br>

        <form role="form" method="post" action="{{url('/inventory_imports')}}" enctype="multipart/form-data">
          <p>■入荷品在庫データ登録(CSVファイルを選んで下さい)</p>
                {{ csrf_field() }}
            <p><input type="file" name="csv_file" id="csv_file">
                <button type="submit" class="btn btn-default btn-success">登録</button></p>     
        </form>

        <div class="main2">
          <h3>使い方</h3>
            <div class="manual">
              <ul>
                <li>注文書のCSVデータをインポート</li>
                <li>在庫CSVデータをインポート</li>
                <li>客先納入日の2日前の10：00に、自動で出荷指示書を生成</li>
                <li>先入先出し、ロット管理の優先順位も自動</li>
                <li>（優先順位 チャージCode、オーダーCode、製造Code、結束No etc）</li>
                <li>取り消しや緊急出荷は、Web上で操作可能</li>
              </ul>
            </div>
        </div>
@include('footer')
@endsection

