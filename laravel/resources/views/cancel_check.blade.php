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
          <form action="{{url('/inventory/shipment/cancels')}}" method="POST" name="status_edit" value="{{ $status_edit ?? null }}">
              @csrf
            <p><div class="input_data">現在の進捗　<input class="check_date" name="status" value="{{ $status ?? null }}" readonly></div></p>
            <p>どこまで戻すか　<input class="check_date" name="status_edit" value="{{ $status_edit ?? null }}" readonly>
            　出荷取消手配　確定　<input type="submit" value="出荷取消"></P>     
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
              <th>注文ID</th>
              <th>商流ID</th>
              <th>ENDユーザー</th>
              <th>ユーザー</th>
              <th>納入先名</th>
              <th>出荷日</th>
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
                <td>{{$shipped->order_code}}</td>
                <td>{{$shipped->charge_code}}</td>
                <td>{{$shipped->manufacturing_code}}</td>
                <td>{{$shipped->bundle_number}}</td>
                <td>{{$shipped->quantity}}</td>
                <td>{{$shipped->weight}}</td>
                <td>{{$shipped->status}}</td>
                <td>{{$shipped->order_item_id}}</td>
                <td>{{$shipped->order_id}}</td>
                <td>{{$shipped->order->clientCompanyEndUser->name}}</td>
                <td>{{$shipped->order->clientCompanyClientUser->name}}</td>
                <td>{{$shipped->order->clientCompanyDeliveryUser->name}}</td>
                <td>{{$shipped->ship_date}}</td>
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