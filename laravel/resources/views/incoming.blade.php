@extends('common')

@section('content')
@include('header')
  
    <div class="main">
        @if (session('flash_message'))
            <div class="flash_message">
                {{ session('flash_message') }}
            </div>
        @endif
       <H1>入荷品登録</H1>
    <form role="form" method="post" action="{{url('/inventory_imports')}}" enctype="multipart/form-data">入荷品登録(CSVファイルを選んで下さい)
            {{ csrf_field() }}
        <input type="file" name="csv_file" id="csv_file">
            <button type="submit" class="btn btn-default btn-success">登録</button>     
    </form>
    <div class="main2">
        <h3>制作技術</h3>
        <ul>
          <li>PHP Laravel</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
          <li>テスト</li>
        </ul>
    </div>
@include('footer')
@endsection

