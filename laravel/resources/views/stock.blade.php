@extends('common')

@section('content')
@include('header') 
   <div class="main">
       <h3>在庫一覧・出荷実績照会</h3>
       <ul>
         <li>登録メニュー設置予定</li>   
       </ul>
    <div class="main2">
        <h3>出荷予定</h3>

        <form action="{{url('/stocks')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい。
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label></p>

            <p><label for="delivery_user_id">納品先IDを入力して下さい。
                <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
            </label></p>

            <p>在庫状態を選んで下さい。
              <label for="status">
                    　<input type="radio" name="status" value="1"<?php if( isset($status)){ if( $status ===  "1"){ echo 'checked'; }}?>>1製造中　
              </label>
              <label for="status">
                    <input type="radio" name="status" value="2"<?php if( isset($status)){ if( $status ===  "2"){ echo 'checked'; }}?>>2工場在庫　
              </label>
              <label for="status">
                    <input type="radio" name="status" value="3"<?php if( isset($status)){ if( $status ===  "3"){ echo 'checked'; }}?>>3倉庫在庫　
              </label>
              <label for="status">
                    <input type="radio" name="status" value="4"<?php if( isset($status)){ if( $status ===  "4"){ echo 'checked'; }}?>>4手配済　
              </label>
              <label for="status">
                    <input type="radio" name="status" value="5"<?php if( isset($status)){ if( $status ===  "5"){ echo 'checked'; }}?>>5出荷済　
              </label>

            </p>



            <p><input type="submit" value="検索"></p>
        
        </form>

        @if(!empty($stock_indexes))

        <p>現在時刻は{{ \Carbon\Carbon::now() }}</p>
         
        <table border="1">
            <tr>
                <th>アイテムコード</th>
                <th>アイテム名</th>
                <th>寸法</th>
                <th>単位</th>
                <th>仕様</th>
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
                <th>出荷日</th>
                <th>ENDユーザー</th>
                <th>ユーザー</th>
                <th>納入先ID</th>
                <th>納入先名</th>
            </tr>
            @foreach ($stock_indexes as $stock)
            <tr>
                <td>{{$stock->item_code}}</td>
                <td>{{$stock->item->name}}</td>                
                <td>{{$stock->item->size}}</td> 
                <td>{{$stock->item->shape}}</td> 
                <td>{{$stock->item->spec}}</td>
                <th>{{$stock->order_code}}</th>
                <th>{{$stock->charge_code}}</th>
                <th>{{$stock->manufacturing_code}}</th>
                <th>{{$stock->bundle_number}}</th>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->weight}}</td>
                <td>{{$stock->status}}</td>
                <td>{{$stock->production_date}}</td>
                <td>{{$stock->factory_warehousing_date}}</td>
                <td>{{$stock->warehouse_receipt_date}}</td>
                <td>{{$stock->ship_date}}</td>
                <td>{{$stock->order->clientCompanyEndUsers->name}}</td>
                <td>{{$stock->order->clientCompanyClientUsers->name}}</td>
                <td>{{$stock->order->delivery_user_id}}</td>
                <td>{{$stock->order->clientCompanyDeliveryUser->name}}</td>
            </tr>
            @endforeach
        </table>
         
        @else
        <p>検索条件を入力して下さい。</p>
        @endif
    </div>
@include('footer')
@endsection

