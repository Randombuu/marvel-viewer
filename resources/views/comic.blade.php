@extends('layouts.default')
@section('content')
<div id="content">
	
	<div class="results">
		<article>
		 	<img src="{{ $comic['thumbnail']['path'] }}.jpg" alt="{{ $comic['title'] }} thumbnail">
		 
		    <h2>{{ $comic['title'] }}</h2>
		    <p>
				{{ $comic['description'] }}
			</p>
			<div id="series">
				<h3>From Series: {{ $series['title'] }}</h3>
				<div class="years">
					<span>Start year: {{ $series['startYear'] }}</span>
					<span>End year: {{ $series['endYear'] }}</span>
				</div>
				<div class="rating">
					Rating: {{ $series['rating'] }}
				</div>
				@if($series['creators']['available'] > 0)
				<div class="creators">
					<h4>Creators</h4>
					<ul>	
					@foreach($series['creators']['items'] as $creator)
						<li>{{ $creator['name'] }} ({{ $creator['role'] }})</li>
					@endforeach
					</ul>
				</div>
				@endif
				
				@if($series['characters']['available'] > 0)
				<div class="characters">
					<h4>Characters</h4>
					<ul>	
					@foreach($series['characters']['items'] as $character)
						<li>{{ $character['name'] }}</li>
					@endforeach
					</ul>
				</div>
				@endif

				@if($series['stories']['available'] > 0)
				<div class="stories">
					<h4>Stories</h4>
					<ul>	
					@foreach($series['stories']['items'] as $story)
						<li>
						{{ $story['name'] }} <br>
						type: {{ $story['type'] }}
						</li>
					@endforeach
					</ul>
				</div>
				@endif
			</div>
		  </footer>
		</article>
	
	</div>
</div>
@stop