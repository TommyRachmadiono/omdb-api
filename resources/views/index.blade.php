<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Movie App</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Movie App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">Search Movie</h1>
                <div class="input-group mb-3">
                    <input id="search-input" type="text" class="form-control" placeholder="Search movie title . . .">
                    <div class="input-group-append">
                        <button class="btn btn-dark" type="button" id="search-button">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row" id="movie-list">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>

</html>

<script>
    $('#search-button').on('click', function() {
       searcMovie()
    })

    $('#search-input').on('keyup', function(e) {
        if (e.keyCode === 13) {
            searcMovie()
        }
    })

    $('#movie-list').on('click', '.see-detail', function() {
        let id = $(this).data('id')
        $.ajax({
            url: 'http://omdbapi.com',
            type: 'get',
            dataType: 'json',
            data: {
                'apikey': 'c3ab2e34',
                'i': id
            },
            success: function (result) {
                if (result.Response === "True") {
                    $('.modal-title').html(result.Title)
                    $('.modal-body').html(`
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="`+ result.Poster +`" class="img-fluid">
                                </div>

                                <div class="col-md-8">
                                    <ul class="list-group">
                                        <li class="list-group-item">Genre : `+ result.Genre +`</li>
                                        <li class="list-group-item">Released : `+ result.Released +`</li>
                                        <li class="list-group-item">Director : `+ result.Director +`</li>
                                        <li class="list-group-item">Actors : `+ result.Actors +`</li>
                                    </ul>
                                </div>
                            </div
                        </div>
                    `)
                } else {

                }
            }
        })
    })

    function searcMovie() {
        $("#movie-list").html('')

        $.ajax({
            url: 'http://omdbapi.com',
            type: 'get',
            dataType: 'JSON',
            data: {
                'apikey': 'c3ab2e34',
                's': $('#search-input').val()
            },
            success: function (result) {
                if (result.Response == 'True') {
                    let movies = result.Search

                    $.each(movies, function(i, data) {
                        $('#movie-list').append(`
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <img src="`+ data.Poster +`" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">`+ data.Title +`</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">`+ data.Year +`</h6>
                                    <a href="#" class="card-link see-detail" data-toggle="modal" data-target="#exampleModal" data-id="`+ data.imdbID +`">See Detail</a>
                                </div>
                            </div>
                        </div>
                        `)
                    })

                    $('#search-input').val('')

                } else {
                    $('#movie-list').html(`
                        <div class="col">
                            <h1 class="text-center">`+ result.Error +`</h1>
                        </div>
                    `)
                }
                console.log(result)
            }
        })
    }
</script>