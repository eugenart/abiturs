@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12">
                <h3 class="text-center h1-mrsu main-color m-0">Статистика приёма</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container pt-0 padding-0 mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12 ">

                @if(empty($files_bach) && empty($files_master) && empty($files_asp) && empty($files_spo))
                    <h5 class="text-center mrsu-uppertext pt-3 text-primary  main-color">
                       Статистика приема на данный момент не доступна
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
                                    <a href="{{ asset('/storage/statistic_priem/bach/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem/bach/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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

                    @if(!empty($files_bach_f))
                        <h5 class="mrsu-uppertext text-primary  main-color">
                            БАКАЛАВРИАТ И СПЕЦИАЛИТЕТ Иностранные абитуриенты
                        </h5>
                        <hr class="mrsu-bg p-0 m-0">
                        <ul class="files-list col-12">
                            @foreach($files_bach_f as $file_xls_stat)
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
                                        <a href="{{ asset('/storage/statistic_priem_foreigner/bach/' . $file_xls_stat) }}"
                                           target="_blank">
                                            {{substr($file_xls_stat, 0, -4)}}
                                        </a>
                                        <br>
                                        <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem_foreigner/bach/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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
                        {{$notif_bach_f}}
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
                                    <a href="{{ asset('/storage/statistic_priem/master/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem/master/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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

                    @if(!empty($files_master_f))
                        <h5 class="mrsu-uppertext  text-primary main-color ">
                            Магистратура иностранные абитуриенты
                        </h5>
                        <hr class="mrsu-bg p-0 m-0">
                        <ul class="files-list col-12">
                            @foreach($files_master_f as $file_xls_stat)

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
                                        <a href="{{ asset('/storage/statistic_priem_foreigner/master/' . $file_xls_stat) }}"
                                           target="_blank">
                                            {{substr($file_xls_stat, 0, -4)}}
                                        </a>
                                        <br>
                                        <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem_foreigner/master/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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
                        {{$notif_master_f}}
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
                                    <a href="{{ asset('/storage/statistic_priem/asp/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem/asp/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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

                    @if(!empty($files_asp_f))
                        <h5 class="mrsu-uppertext  text-primary main-color ">
                            Аспирантура иностранные абитуриенты
                        </h5>
                        <hr class="mrsu-bg p-0 m-0">
                        <ul class="files-list col-12">
                            @foreach($files_asp_f as $file_xls_stat)
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
                                        <a href="{{ asset('/storage/statistic_priem_foreigner/asp/' . $file_xls_stat) }}"
                                           target="_blank">
                                            {{substr($file_xls_stat, 0, -4)}}
                                        </a>
                                        <br>
                                        <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem_foreigner/asp/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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
                        {{$notif_asp_f}}
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
                                    <a href="{{ asset('/storage/statistic_priem/spo/' . $file_xls_stat) }}"
                                       target="_blank">
                                        {{substr($file_xls_stat, 0, -4)}}
                                    </a>
                                    <br>
                                    <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/statistic_priem/spo/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
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
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
@endsection
