@extends('templates.index')

@section('content')
    <div class="general-agileits-w3l">
        <div class="w3l-medile-movies-grids">
            <div class="movie-browse-agile">
                <div class="browse-agile-w3ls general-w3ls">
                    <div class="tittle-head">
                        <h4 class="latest-text">Search Result</h4>
                        <div class="container">
                            <div class="agileits-single-top">
                                <ol class="breadcrumb">
                                    <li><a href="{{ route('movies') }}">Movies</a></li>
                                    <li><a href="#">Search</a></li>
                                    @if ($film)
                                        <li class="active"><a href="#">{{ $film->title }}</a></li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="browse-inner">
                            @if ($film)
                                <div class="col-md-2 w3l-movie-gride-agile" style="padding-top: 20px">
                                    <a href="{{ route('movies.show', $film->id) }}" class="hvr-shutter-out-horizontal">
                                        <img src="{{ asset($film->poster) }}" title="{{ $film->title }}" alt=" "
                                            style="width: 170px;" />
                                        <div class="w3l-action-icon">
                                            <i class="fa fa-play-circle" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                    <div class="mid-1">
                                        <div class="w3l-movie-text">
                                            <h6><a href="{{ route('movies.show', $film->id) }}">{{ $film->title }}</a>
                                            </h6>
                                        </div>
                                        <div class="mid-2">
                                            <p>{{ $film->year }}</p>
                                            <div class="block-stars">
                                                <ul class="w3l-ratings">
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="#"><i class="fa fa-star-half-o"
                                                                aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star-o"
                                                                aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    @if ($film->year == now()->year)
                                        <div class="ribben two">
                                            <p>NEW</p>
                                        </div>git 
                                    @endif
                                    <div>
                                        <p>{{ $film->sinopsis }}</p>
                                    </div>
                                </div>
                            @else
                                <h3>No films found for
                                    "{{ request()->input('search') }}"{{ request()->input('year') ? ' in year ' . request()->input('year') : '' }}
                                </h3>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
