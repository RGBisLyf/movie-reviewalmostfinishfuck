@extends('layouts.app')

@section('content')
     <br>
    <div class="container">
        <!-- Search Form -->
        <form action="{{ route('home') }}" method="GET" class="mb-3" id="searchForm">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search" id="searchInput" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </form>

        <!-- Sorting by First Letters -->
        <div class="mb-3">
            <div class="btn-group" role="group">
                @foreach(range('A', 'Z') as $letter)
                    <a href="#" class="btn btn-dark letter-sort" data-letter="{{ $letter }}">{{ $letter }}</a>
                @endforeach
            </div>
            <br>
            <br>
            <button class="btn btn-secondary" id="resetFilters">Reset Filters</button>
            <h2>Movies</h2>
        </div>

        <!-- Display Movies -->
        <div class="row" id="moviesContainer">
            @foreach($movies as $movie)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="img-fluid" style="max-width: 500px; max-height: 500px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ $movie->description }}</p>
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-secondary">Details</a>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script>
    $(document).ready(function () {
        $('#searchForm').submit(function (e) {
            e.preventDefault();
            loadMovies();
        });

        $('.letter-sort').click(function (e) {
            e.preventDefault();
            loadMoviesByLetter($(this).data('letter'));
        });

        $('#resetFilters').click(function (e) {
            e.preventDefault();
            resetFilters();
        });

        function loadMovies() {
            $.ajax({
                url: '{{ route('home') }}',
                type: 'GET',
                data: { search: $('#searchInput').val() },
                success: function (data) {
                    $('#moviesContainer').html(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function loadMoviesByLetter(letter) {
            $.ajax({
                url: '{{ route('home') }}',
                type: 'GET',
                data: { letter: letter },
                success: function (data) {
                    $('#moviesContainer').html(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function resetFilters() {
            $.ajax({
                url: '{{ route('home') }}',
                type: 'GET',
                data: { reset: true }, 
                success: function (data) {
                    $('#moviesContainer').html(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });
</script>

@endsection
