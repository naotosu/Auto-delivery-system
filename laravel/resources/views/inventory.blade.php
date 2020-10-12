@extends('common')

@section('content')
@include('header') 
   <div class="main">
       <h3>在庫一覧・出荷実績照会</h3>
    <div class="main2">
        <form action="{{url('/inventories')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい。
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label></p>

            <p><label for="delivery_user_id">納入先IDを入力して下さい。
                <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
            </label></p>

            <p>在庫進捗状態を選んで下さい。
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

        @if(!empty($inventories))

        <div class="pagination">
            {{ $inventories->appends(request()->input())->links('vendor.pagination.default') }}
        </div>
         
        <table border="1">
            <tr>
                <th>アイテムコード</th>
                <th>アイテム名</th>
                <th>寸法</th>
                <th>単位</th>
                <th>仕様</th>
                <th>オーダーCode</th>
                <th>チャージCode</th>
                <th>製造No</th>
                <th>束番</th>
                <th>数量</th>
                <th>重量</th>
                <th>在庫状態</th>
                <th>製造日</th>
                <th>工場入庫日</th>
                <th>倉庫入庫日</th>
                <th>注文ID</th>
                <th>出荷日</th>
                <th>納入先ID</th>
                <th>納入先名</th>
            </tr>
            @foreach ($inventories as $inventory)
            <tr>
                <td>{{$inventory->item_code}}</td>
                <td>{{$inventory->item->name}}</td>
                <td>{{$inventory->item->size}}</td> 
                <td>{{$inventory->item->shape}}</td> 
                <td>{{$inventory->item->spec}}</td>
                <th>{{$inventory->order_code}}</th>
                <th>{{$inventory->charge_code}}</th>
                <th>{{$inventory->manufacturing_code}}</th>
                <th>{{$inventory->bundle_number}}</th>
                <td>{{$inventory->quantity}}</td>
                <td>{{$inventory->weight}}</td>
                <td>{{$inventory->status}}</td>
                <td>{{$inventory->production_date}}</td>
                <td>{{$inventory->factory_warehousing_date}}</td>
                <td>{{$inventory->warehouse_receipt_date}}</td>
                <td>{{$inventory->order_item_id}}</td>
                <td>{{$inventory->ship_date}}</td>
                <td>{{$inventory->order->delivery_user_id}}</td>
                <td>{{$inventory->order->clientCompanyDeliveryUser->name}}</td>
            </tr>
            @endforeach
        </table>
         
        @else
        <p>検索条件を入力して下さい。</p>
        @endif
    </div>
@include('footer')
@endsection

