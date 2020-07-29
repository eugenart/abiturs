@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12">
                <h1 class="text-center h1-mrsu main-color m-0">Приказы о зачислении</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container pt-0 padding-0 mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12 ">

                @if(empty($files_bach) && empty($files_master) && empty($files_asp) && empty($files_spo))
                    <h5 class="text-center mrsu-uppertext pt-3 text-primary  main-color">
                        Приказы о зачислении на данный момент недоступны
                    </h5>
                @endif

                @if(!empty($files_bach))
                    <h5 class="mrsu-uppertext text-primary  main-color">
                        Бакалавриат и специалитет
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_bach as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/bach/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/bach/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_bach}}
                </div>


                @if(!empty($files_master))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Магистратура
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_master as $file_xls_stat)

                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/master/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/master/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_master}}
                </div>


                @if(!empty($files_asp))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Аспирантура
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_asp as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/asp/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/asp/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_asp}}
                </div>

                @if(!empty($files_ord))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Ординатура
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_ord as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/ord/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/ord/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_ord}}
                </div>

                @if(!empty($files_spo))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Среднее профессиональное образование
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_spo as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' .substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/spo/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/spo/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_spo}}
                </div>

                    @if(!empty($files_foreigner))
                        <h5 class="mrsu-uppertext  text-primary main-color ">
                            Иностранные абитуриенты
                        </h5>
                        <hr class="mrsu-bg p-0 m-0">
                        <ul class="files-list col-12">
                            @foreach($files_foreigner as $file_xls_stat)
                                <li>
                                    <div>
                                        @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' .substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                            <img
                                                src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                                alt="">
                                        @else
                                            <img
                                                src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="file-link-div ">
                                        <a href="{{ asset('/storage/orders/foreigner/' . $file_xls_stat) }}"
                                           target="_blank">
                                            {{substr($file_xls_stat, 0, -4)}}
                                        </a>
                                        <br>
                                        <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/foreigner/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        {{--                    <div class="m-2 text-center">--}}
                        {{--                        Файлы отсутствуют--}}
                        {{--                    </div>--}}
                    @endif
                    <div>
                        {{$notif_foreigner}}
                    </div>

                @if(!empty($files_cancel))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Приказы об отмене зачисления
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_cancel as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' .substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/cancel/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/cancel/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_cancel}}
                </div>

                @if(!empty($files_other))
                    <h5 class="mrsu-uppertext  text-primary main-color ">
                        Другие приказы
                    </h5>
                    <hr class="mrsu-bg p-0 m-0">
                    <ul class="files-list col-12">
                        @foreach($files_other as $file_xls_stat)
                            <li>
                                <div>
                                    @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' .substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png'))
                                        <img
                                            src="{{ asset('storage/file-types/' . substr($file_xls_stat, strrpos($file_xls_stat, '.') + 1) . '.png' )}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="file-link-div ">
                                    <a href="{{ asset('/storage/orders/other/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/orders/other/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{--                    <div class="m-2 text-center">--}}
                    {{--                        Файлы отсутствуют--}}
                    {{--                    </div>--}}
                @endif
                <div>
                    {{$notif_other}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
@endsection
