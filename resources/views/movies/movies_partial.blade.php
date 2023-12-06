@foreach($movies as $movie)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="img-fluid" style="max-width: 500px; max-height: 500px;">
            <div class="card-body">
                <h5 class="card-title">{{ $movie->title }}</h5>
                <p class="card-text">{{ $movie->description }}</p>
                <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>
@endforeach