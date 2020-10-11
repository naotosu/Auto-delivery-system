@extends('common')

@section('content')
@include('header')
    <div class="main">
      @if (session('flash_message'))
          <div class="flash_message">
              {{ session('flash_message') }}
          </div>
      @endif
       <h3>出荷指示強制取消</h3>
       <h2><span class="attention">注意</span>　出荷取り消す際は必ず輸送会社の許可を得て行って下さい</h2>
       <form action="{{url('/shipment/cancels')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい。
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label></p>
            <p><label for="delivery_user_id">納品先IDを入力して下さい。
                <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}">
            </label></p>
            <p><label for="order_date">
                納入日を入力して下さい<input type="date" name="ship_date" value="{{ $ship_date ?? null }}">
            </label></p>
            <p>進捗進捗状態を選んで下さい。
              <label for="status">
                    <input type="radio" name="status" value="4"<?php if( isset($status)){ if( $status ===  "4"){ echo 'checked'; }}?>>4手配済　
              </label>
              <label for="status">
                    <input type="radio" name="status" value="5"<?php if( isset($status)){ if( $status ===  "5"){ echo 'checked'; }}?>>5出荷済　
              </label></p>
            <p><input type="submit" value="検索"></p>
        </form>

        @if(!empty($stock_indexes))

          <form action="{{url('/shipment/cancels/checks')}}" method="GET">
              @csrf
              <p>どこまで進捗を戻すか選んで下さい<span class="attention">（入力必須）　</span>
                <label for="status">
                      <input type="radio" name="status_edit" value="2"<?php if( isset($status_edit)){ if( $status_edit ===  "2"){ echo 'checked'; }}?>>2工場在庫　
                </label>
                <label for="status">
                      <input type="radio" name="status_edit" value="3"<?php if( isset($status_edit)){ if( $status_edit ===  "3"){ echo 'checked'; }}?>>3倉庫在庫　
                </label></p>
             <P>出荷指示を取り消す明細をチェックして下さい　<input type="submit" value="出荷取消"></P>

          @if(!empty($stock_indexes))
          <div class="pagination">
              {{ $stock_indexes->appends(request()->input())->links('vendor.pagination.default') }}
          </div>
          @endif

          <table border="1">
              <tr>
                <th>選択</th>
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
                <th>納入先名</th>
              </tr>
              @foreach ($stock_indexes as $stock)
              <tr>
                <td>
                  <input class="form-check-input" type="checkbox" id="{{$stock->id}}" name="item_ids[]" value="{{$stock->id}}" <?php if (isset($item_ids)) { $key = in_array($stock->id, $item_ids); if ($key) {echo "checked"; }} ?>>
                  <label class="form-check-label" for="checkbox">{{$stock->id}}</label>
                </td>
                  <td>{{$stock->item_code}}</td>
                  <td>{{$stock->item->name}}</td>                
                  <td>{{$stock->item->size}}</td> 
                  <td>{{$stock->item->shape}}</td> 
                  <td>{{$stock->item->spec}}</td>
                  <td>{{$stock->order_code}}</td>
                  <td>{{$stock->charge_code}}</td>
                  <td>{{$stock->manufacturing_code}}</td>
                  <td>{{$stock->bundle_number}}</td>
                  <td>{{$stock->quantity}}</td>
                  <td>{{$stock->weight}}</td>
                  <td>{{$stock->status}}</td>
                  <td>{{$stock->production_date}}</td>
                  <td>{{$stock->factory_warehousing_date}}</td>
                  <td>{{$stock->warehouse_receipt_date}}</td>
                  <td>{{$stock->order_item_id}}</td>
                  <td>{{$stock->ship_date}}</td>
                  <td>{{$stock->order->clientCompanyDeliveryUser->name}}</td>
              </tr>
              @endforeach
          </table>
            <div class="input_data">
              <input type="text" name="item_code" value="{{ $item_code ?? null }}" readonly>
              <input type="text" name="delivery_user_id" value="{{ $delivery_user_id ?? null }}" readonly>
              <input type="date" name="ship_date" value="{{ $ship_date ?? null }}" readonly>
              <input type="text" name="status" value="{{ $status ?? null }}" readonly>
            </div>
        </form>
           
        @else
          <p>検索条件を入力して下さい。</p>
        @endif
    </div>
@include('footer')
@endsection