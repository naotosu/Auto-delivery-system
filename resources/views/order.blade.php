@extends('common')

@section('content')
@include('header')

    <div class="main">
       <h3>CSV注文書登路</h3>
       <ul>
         <li>登録メニュー設置予定</li>   
       </ul>
    <div class="main2">
        <h3>出荷予定</h3>

        <form action="{{url('/orders')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい。
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label></p>

            <p><label for="delivery_user_id">納品先IDを入力して下さい。
                <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
            </label></p>

            {{ $now = \Carbon\Carbon::now() }}

            <p><label for="order_date">表示する納入日を選んで下さい。
                    <input type="date" name="order_start" min="{{$now->subMonths(1)}}" max="{{$now->addMonths(1)}}" value="{{ $order_start ?? null }}"> 〜 
                    <input type="date" name="order_end" min="{{$now->subMonths(1)}}" max="{{$now->addMonths(1)}}" value="{{ $order_end ?? null }}">
            </label></p>

            <p><input type="submit" value="検索"></p>
        
        </form>
        
        @if(!empty($order_indexes))

        <p>現在日時は{{ \Carbon\Carbon::now() }}</p>
         
        <table border="1">
            <tr>
                <th>アイテムコード</th>
                <th>アイテム名</th>
                <th>納入日</th>
                <th>数量</th>
                <th>ENDユーザー</th>
                <th>ユーザー</th>
                <th>納入先ID</th>
                <th>納入先名</th>
                <th>即時フラグ</th>
            </tr>
            @foreach ($order_indexes as $order)
            <tr>
                <td>{{$order->item_code}}</td>
                <td>{{$order->item->name}}</td>
                <td>{{$order->ship_date}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->order->delivery_user_id}}</td>
                <td>{{$order->order->clientCompanyDeliveryUser->name}}</td>
                <td>{{$order->temporary_flag}}</td>
            </tr>
            @endforeach
        </table>
         
        @else
        <p>検索条件を入力してください</p>
        @endif
    </div>
@include('footer')
@endsection
