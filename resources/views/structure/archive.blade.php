@extends('layouts.app')
@section('content')
    <archive></archive>
{{--    <div>--}}
{{--        @foreach($archives as $arc)--}}
{{--            <div class="card mb-3 mt-1">--}}
{{--                <div class="card-header">{{$arc->name}}</div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="card-columns">--}}
{{--                        @foreach($arc->infoblocks as $inf)--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header ">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-8">--}}
{{--                                            <p class="m-0"><strong>{{$inf->name}}</strong></p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-4">--}}
{{--                                            <p>--}}
{{--                                               <span class="float-right">--}}
{{--                                                   <i class="fa fa-copy" style="cursor: pointer;"></i>--}}
{{--                                                   <a href=""><i class="far fa-eye" style="cursor: pointer;"></i></a>--}}
{{--                                                   &nbsp;--}}
{{--                                                   <i class="fas fa-pen" style="cursor: pointer;"></i>--}}
{{--                                                   &nbsp;--}}
{{--                                                   <i class="fas fa-trash-alt" style="cursor: pointer; color: red;"></i>--}}
{{--                                               </span>--}}
{{--                                            </p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <div>--}}
{{--                                        <label class="badge m-0">Предпросмотр изображения</label>--}}
{{--                                        <img src="../../../storage/preview/default.jpg" alt="" class="w-100">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="card-footer">--}}
{{--                                    <label class="badge m-0">Ссылка</label>--}}
{{--                                    <p class="ml-2 mb-1">--}}
{{--                                        <a href="" target="_blank">Putevoditeli-abiturienta</a>--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}


@endsection
