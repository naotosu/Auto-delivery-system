@extends('common')

@section('content')
@include('header')  
   <div class="main">
       <h3>臨時出荷指示出力</h3>
       <ul>
         <li>CSVからでも指示可（予定）</li>   
       </ul>
    <div class="main2">
        <h3>臨時出荷指示検索　（在庫ピンポイント指定）</h3>

        <form action="{{url('/temporaries')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい。
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label></p>

            <p><label for="delivery_user_id">納品先IDを入力して下さい。
                <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
            </label></p>

            <p><input type="submit" value="検索"></p>
        
        </form>

        @if(!empty($temporary_indexes))

        <p>現在時刻は{{ \Carbon\Carbon::now() }}</p>
        <p>臨時出荷　納入日<input type="text" name="ship_date"></p>

        <form action="{{url('/temporary_ships')}}" method="POST">
        <p><label for="checkbox"><span class="attention">注意！</span></label>
          向け先変更が必要な場合はチェック=>
          <input class="form-check-input" type="checkbox" id="change" name="change" value="change">
          <label class="form-check-label" for="checkbox"></label>
          　　変更先のオーダーIDを入力=>
          <input type="text" name="change_id"></p>

           <P>臨時出荷を行うロットを選択し、出荷指示をクリック　<input type="submit" value="出荷指示"></P>
           <div class= 'attention'><p>※チャージNoが古い順で表示。理由が無い限り一番上から使用下さい。</p></div>

        <table border="1">
            <tr>
                <th>選択</th>
                <th>アイテムコード</th>
                <th>アイテム名</th>                
                <th>オーダーNo</th>
                <th>チャージNo</th>
                <th>製造No</th>
                <th>束番</th>
                <th>数量</th>
                <th>重量</th>
                <th>在庫状態</th>
                <th>製造日</th>
                <th>工場入庫日</th>
                <th>倉庫入庫日</th>
                <th>ENDユーザー</th>
                <th>ユーザー</th>
                <th>納入先ID</th>
                <th>納入先名</th>
            </tr>
            @foreach ($temporary_indexes as $temporary)
            <tr>
                <td>
                  <input class="form-check-input" type="checkbox" id="{{$temporary->id}}" name="{{$temporary->id}}" value="{{$temporary->id}}">
                  <label class="form-check-label" for="checkbox">{{$temporary->id}}</label>
                </td>
                <td>{{$temporary->item_code}}</td>
                <td>{{$temporary->item->name}}</td>           
                <th>{{$temporary->order_code}}</th>
                <th>{{$temporary->charge_code}}</th>
                <th>{{$temporary->manufacturing_code}}</th>
                <th>{{$temporary->bundle_number}}</th>
                <td>{{$temporary->quantity}}</td>
                <td>{{$temporary->weight}}</td>
                <td>{{$temporary->status}}</td>
                <td>{{$temporary->production_date}}</td>
                <td>{{$temporary->factory_warehousing_date}}</td>
                <td>{{$temporary->warehouse_receipt_date}}</td>
                <td>{{$temporary->order->clientCompanyEndUsers->name}}</td>
                <td>{{$temporary->order->clientCompanyClientUsers->name}}</td>
                <td>{{$temporary->order->delivery_user_id}}</td>
                <td>{{$temporary->order->clientCompanyDeliveryUser->name}}</td>
            </tr>
            @endforeach
        </table>
         
        @else
        <p>検索条件を入力して下さい。</p>
        @endif
    </div>
@include('footer')
@endsection
