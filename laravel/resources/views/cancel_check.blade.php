@extends('common')

@section('content')
@include('header')
    <div class="main">
      @if (session('flash_message'))
          <div class="flash_message">
              {{ session('flash_message') }}
          </div>
      @endif
       <H1>【確認】本当に取り消しても良いですか？</H1>
       <h2><span class="attention">注意</span>　出荷取り消す際は必ず輸送会社の許可を得て行って下さい</h2>

        @if(!empty($inventories))
        <form action="{{url('/shipment/cancels')}}" method="POST" name="status_edit" value="{{ $status_edit ?? null }}">
            @csrf
          <p>現在の進捗　<input class="check_date" name="status" value="{{ $status ?? null }}" readonly>   どこまで戻すか　<input class="check_date" name="status_edit" value="{{ $status_edit ?? null }}" readonly>
          <P>出荷取消手配　確定　<input type="submit" value="出荷取消"></P>        
        <table border="1">
            <tr>
              <th>デバック用</th>
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
              <th>出荷日</th>
              <th>ENDユーザー</th>
              <th>ユーザー</th>
              <th>納入先ID</th>
              <th>納入先名</th>
            </tr>
            @foreach ($inventories as $shipped)
            <tr>
              <td>
                <input class="check_date" id="{{$shipped->id}}" name="item_ids[]" value="{{$shipped->id}}" readonly>
              </td>
              <td>{{$shipped->item_code}}</td>
              <td>{{$shipped->item->name}}</td>                
              <td>{{$shipped->item->size}}</td> 
              <td>{{$shipped->item->shape}}</td> 
              <td>{{$shipped->item->spec}}</td>
              <th>{{$shipped->order_code}}</th>
              <th>{{$shipped->charge_code}}</th>
              <th>{{$shipped->manufacturing_code}}</th>
              <th>{{$shipped->bundle_number}}</th>
              <td>{{$shipped->quantity}}</td>
              <td>{{$shipped->weight}}</td>
              <td>{{$shipped->status}}</td>
              <td>{{$shipped->production_date}}</td>
              <td>{{$shipped->factory_warehousing_date}}</td>
              <td>{{$shipped->warehouse_receipt_date}}</td>
              <td>{{$shipped->ship_date}}</td>
              <td>{{$shipped->order->clientCompanyEndUser->name}}</td>
              <td>{{$shipped->order->clientCompanyClientUser->name}}</td>
              <td>{{$shipped->order->delivery_user_id}}</td>
              <td>{{$shipped->order->clientCompanyDeliveryUser->name}}</td>
            </tr>
            @endforeach
        </table>
      </form>
         
        @else
        <p>取り消す明細が選択されていません</p>
        @endif
    </div>
@include('footer')
@endsection