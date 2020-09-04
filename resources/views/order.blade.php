@extends('common')

@section('content')
@include('header')  
    <div class="main">
       <H1>注文書登録ページ</H1>
       <h2>CSV登録メニュー</h2>
       <h3>設定</h3>
       <ul>
         <li>テスト</li>
         <li>テスト</li>
   
       </ul>
    <div class="main2">
        <h3>出荷予定</h3>

        <form action="{{url('/orders')}}" method="GET">
            <p><label for="item_id">アイテムコードを入力して下さい。
                <input type="text" name="item_id" value="{{ $params['item_id'] ?? null }}">
            </label></p>

            <p><label for="order_date">表示する納入日を選んで下さい。
                    <input type="date" name="order_start" min="2020-08-01" max="2020-10-01" value="{{ $params['order_start'] ?? null }}">〜
                    <input type="date" name="order_end" min="2020-08-01" max="2020-10-01" value="{{ $params['order_end'] ?? null }}">
            </label></p>

            <p><input type="submit" value="検索"></p>
        
        </form>

        @if(!empty($orders))
 
        <table border="1">
            <tr>
                <th>アイテムコード</th>
                <th>納入日</th>
                <th>数量</th>
            </tr>
            @foreach ($order_indexs as $order)
            <tr>
                <td>{{$order->item_id}}</td>
                <td>{{$delivery_date}}</td>
                <td>{{$order->quantity}}</td>
            </tr>
            @endforeach
        </table>
         
        @else
        <p>見つかりませんでした。</p>
        @endif
    </div>
@include('footer')
@endsection
