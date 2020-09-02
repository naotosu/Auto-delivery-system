@extends('common')

@section('content')
@include('header')  
    <div class="main">
       <H1>注文書登録ページ</H1>
       <h2>テスト</h2>
       <h3>設定</h3>
       <ul>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
         <li>テスト</li>
       </ul>
    <div class="main2">
        <h3>出荷予定</h3>
        
        <ul>
          <li>アイテムID 　　　  納入日　　　　数量</li>
          @foreach ($orders as $order)
          <li>{{ $order->item_id }}　 {{$order->delivery_date}} 　{{ $order->quantity }}</li>
          @endforeach
        </ul>
    </div>
@include('footer')
@endsection
