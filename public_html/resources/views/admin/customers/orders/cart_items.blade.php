<div class="table-responsive">
   <h6><strong>Cart Items</strong></h6>
   <table class="table table-bordered">
      <tr>
         <th>Article</th>
         <th style="width: 180px">QTY</th>
         <th>Price</th>
         <th>Total</th>
         <th>Action</th>
      </tr>
      @php
      $CartItems = \Cart::content();
      @endphp
      @foreach(\Cart::content() as $key => $item)
      <tr>
      	<input type="hidden" name="product_ids[]" value="{{ $item->id }}">
         <td>{{ $item->name??'' }} - {{ $item->options->size??'' }} ({{ $item->options->product_code??''}})</td>
         <td style="width: 180px">
            <input type="text" class="qty text-center" value="{{ $item->qty??'' }}" id="appendedInputButtons" name="quantity" disabled="disabled" style="width: 80px;">
            <button type="button" class="qty-minus qtyMinus btnItemUpdate btn btn-sm btn-danger" data-cartid="{{$item->rowId}}"><font><i class="bx bx-minus"></i></font></button>
            <button type="button" class="qty-plus qtyPlus btnItemUpdate btn btn-sm btn-success" data-cartid="{{$item->rowId}}"><font><i class="bx bx-plus"></i></font></button>
         </td>
         <td>{{ $item->price??'' }}</td>
         <td>{{ round($item->price*$item->qty,2,)??'' }}</td>
         <td>
            <a href="javascript:;" data-cartid="{{$item->rowId}}" class="btn btn-danger btn-sm removeCartItem">
            <i class="bx bx-trash-alt"></i></a>
         </td>
      </tr>
      @endforeach
      <tr>
         <th colspan="3" style="text-align: right;">Total</th>
         <th colspan="2" style="text-align: right;">₹ {{ \Cart::priceTotal() }}</th>
      </tr>
   </table>
</div>