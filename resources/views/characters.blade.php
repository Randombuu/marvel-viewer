@extends('layouts.default')

@section('content')
<div id="content">
	<h2>Characters</h2>
	
	<div id="characters" class="results">
	
		@foreach($paginated_results as $char)
		<article class="card">
		  <img src="{{ $char['thumbnail']['path'] }}/portrait_incredible.jpg" alt="{{ $char['name'] }} thumbnail">
		  <footer>
		    <h5>
		    	<a href="{{ getCharacterURL($char) }}" class="card-title">{{ $char['name'] }}</a>
		    </h5>
		  </footer>
		</article>
		@endforeach

	</div>
	<div id="pagination">	
	{{ $paginated_results->setPath('characters')->render() }}
	</div>
</div>
@stop