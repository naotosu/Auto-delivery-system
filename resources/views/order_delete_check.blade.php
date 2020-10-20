@extends('common')

@section('content')
@include('header')
    <div class="main">
      @if (session('flash_message'))
          <div class="flash_message">
              {{ session('flash_message') }}
          </div>
      @endif
       <H1>【確認】本当に消去しても良いですか？</H1>
       @if(isset($orders))
        
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
                    <th>消去</th>
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
                    <td>
                        <div class="input_data">
                            <form action="{{url('/orders/delete')}}" method="POST" class="input_data">
                                @csrf
                                @method('DELETE')
                            <input type="text" name="order_item_id" value="{{ $order->id }}" readonly>
                        </div>
                            <input type="submit" value="消去">
                        </form>
                    </td>
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