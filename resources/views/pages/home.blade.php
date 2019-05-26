@extends('pages.layout')

@section('page')
    @foreach($infoblocks->sortByDesc('startPagePriority') as $infoblock)
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card infoblock-card">
                <a href="{{ $infoblock->url }}">
                    <div class="card-body mrsu-bg">
                        <img src="storage/preview/{{ $infoblock->image }}" class="w-100" alt="">
                        <p class="text-center m-0 pt-2 mrsu-uppertext">{{ $infoblock->name }}</p>
                    </div>
                </a>
                <div class="card-footer">
                    <ul class="mrsu-uppertext m-0">
                        @foreach($infoblock->sections as $section)
                        <li><a href="{{ $section->url }}">{{ $section->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach

@endsection