<table>
	<tr>
		<th>sku_code</th>
		<th>product_bullet_id</th>
	</tr>
	@foreach($product_bullets??'' as $product)
	<tr>
		<td>{{ $product->sku_code??'' }}</td>
		<td>{{ collect($product->bullets->pluck('id'))->implode(',') }}</td>
	</tr>
	@endforeach
</table>