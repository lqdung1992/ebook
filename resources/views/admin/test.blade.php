
<div>
	@foreach ($test as $t)
		<h1>{{$t->pivot->ebook_id}}</h1>
	@endforeach
</div>