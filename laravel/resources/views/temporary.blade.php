@extends('common')

@section('content')
@include('header')  
   <div class="main">
       <h3>臨時出荷指示　（在庫ピンポイント指定）</h3>
    <div class="main2">
        <form action="{{url('/shipment/temporaries')}}" method="GET">
            <p><label for="item_code">アイテムコードを入力して下さい（検索用）
                <input type="text" name="item_code" value="{{ $item_code ?? null }}">
            </label><input type="submit" value="検索"></p>
        </form>
        <div class="search-line"></div>

        @if(!empty($inventories))

        <form action="{{url('/api/temporary_ships')}}" method="POST">
            @csrf
        <p>臨時出荷　納入日を入力　<span class="attention">※入力必須　</span>　<input type="date" name="ship_date"></p>
        <p>出荷する商流ID入力　<span class="attention">　※入力必須　</span> <input type="text" name="order_id"></p>

           <P>臨時出荷を行うロットを<span class="attention">選択</span>し、出荷指示をクリック　<input type="submit" value="出荷指示"></P>
           <p>※チャージNoが古い順で表示。理由が無い限り<span class="attention">一番上から使用</span>下さい。</p>
           <p>※CSVファイルがダウンロードされます。<span class="attention">輸送会社へ送付</span>して下さい。
           (定期連絡とは異なる為、個別で連絡して下さい)</p>
           <p>※納入日の2日前の定期連絡で、もう一度明細に載ります。</p>

        <div class="pagination">
            {{ $inventories->appends(request()->input())->links('vendor.pagination.default') }}
        </div>

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
            </tr>
            @foreach ($inventories as $temporary)
            <tr>
                <td>
                  <input class="form-check-input" type="checkbox" id="{{$temporary->id}}" name="item_ids[]" value="{{$temporary->id}}">
                  <label class="form-check-label" for="checkbox">{{$temporary->id}}</label>
                </td>
                <td>{{$temporary->item_code}}</td>
                <td>{{$temporary->item->name}}</td> 
                <td>{{$temporary->item->size}}</td> 
                <td>{{$temporary->item->shape}}</td> 
                <td>{{$temporary->item->spec}}</td>          
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
            </tr>
            @endforeach
        </table>

        </form>
         
        @else
        <p>検索条件を入力して下さい。</p>
        @endif
    </div>
@include('footer')
@endsection