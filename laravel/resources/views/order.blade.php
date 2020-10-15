@extends('common')

@section('content')
@include('header')

    <div class="main">
        <div class="main2">
            <h3>注文データ照会</h3>

            <form action="{{url('/orders/index')}}" method="GET">
                <p><label for="item_code">アイテムコードを入力して下さい。
                    <input type="text" name="item_code" value="{{ $item_code ?? null }}">
                </label></p>

                <p><label for="delivery_user_id">納入先IDを入力して下さい。
                    <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
                </label></p>

                <p><label for="order_date">表示する納入日を選んで下さい。
                        <input type="date" name="order_start" value="{{ $order_start ?? null }}"> 〜 
                        <input type="date" name="order_end" value="{{ $order_end ?? null }}">
                </label></p>

                <p><input type="submit" value="検索"></p>
            </form>
            
            @if(!empty($orders))

            <div class="pagination">
                {{ $orders->appends(request()->input())->links('vendor.pagination.default') }}
            </div>

            <table border="1">
                <tr>
                    <th>デバッグ用ID</th>
                    <th>アイテムコード</th>
                    <th>アイテム名</th>
                    <th>寸法</th>
                    <th>単位</th>
                    <th>仕様</th>
                    <th>納入日</th>
                    <th>重量</th>
                    <th>商流ID</th>
                    <th>ENDユーザー</th>
                    <th>ユーザー</th>
                    <th>納入先ID</th>
                    <th>納入先名</th>
                    <th>完了フラグ</th>
                </tr>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->item_code}}</td>
                    <td>{{$order->item->name}}</td>
                    <td>{{$order->item->size}}</td> 
                    <td>{{$order->item->shape}}</td> 
                    <td>{{$order->item->spec}}</td>
                    <td>{{$order->ship_date}}</td>
                    <td>{{$order->weight}}</td>
                    <td>{{$order->order_id}}</td>
                    <td>{{$order->order->clientCompanyEndUser->name}}</td>
                    <td>{{$order->order->clientCompanyClientUser->name}}</td>
                    <td>{{$order->order->delivery_user_id}}</td>
                    <td>{{$order->order->clientCompanyDeliveryUser->name}}</td>
                    <td>{{$order->done_flag}}</td>
                </tr>
                @endforeach
            </table>
             
            @else
            <p>検索条件を入力してください</p>
            @endif
        </div>
    </div>
@include('footer')
@endsection
