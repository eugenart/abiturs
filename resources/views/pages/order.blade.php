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
            <div class="col-12">

                @if(empty($files_bach) && empty($files_master) && empty($files_asp) && empty($files_spo))
                    <h5 class="text-center mrsu-uppertext pt-3 text-primary  main-color">
                        Приказы о зачислении на данный момент недоступны
                    </h5>
                @endif

                <div class="accordion" id="accordionExample">
                    @if(!empty($files_bach))
                        <div id="headingOne">
                            <a href="" class="collapsed"  data-toggle="collapse"
                                    data-target="#collapseBach"
                                    aria-expanded="true" aria-controls="collapseBach">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext text-primary main-color">
                                    <i class="fas fa-angle-down rotate-icon"></i> Бакалавриат и специалитет
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseBach" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif

                    <div>
                        {{$notif_bach}}
                    </div>


                    @if(!empty($files_master))
                        <div id="headingTwo">
                            <a href="" class="collapsed"  data-toggle="collapse"
                                    data-target="#collapseMaster"
                                    aria-expanded="true" aria-controls="collapseMaster">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i> Магистратура
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseMaster" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_master}}
                    </div>


                    @if(!empty($files_asp))
                        <div id="headingAsp">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseAsp"
                                    aria-expanded="true" aria-controls="collapseAsp">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i>  Аспирантура
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseAsp" class="collapse" aria-labelledby="headingAsp"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_asp}}
                    </div>

                    @if(!empty($files_ord))
                        <div id="headingOrd">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseOrd"
                                    aria-controls="collapseOrd" aria-expanded="true">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i>  Ординатура
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseOrd" class="collapse" aria-labelledby="headingOrd"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_ord}}
                    </div>

                    @if(!empty($files_spo))
                        <div id="headingSpo">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseSpo" aria-controls="collapseSpo" aria-expanded="true">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i> Среднее профессиональное образование
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseSpo" class="collapse" aria-labelledby="headingSpo"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_spo}}
                    </div>

                    @if(!empty($files_foreigner))
                        <div id="headingFor">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseFor"
                                    aria-controls="collapseFor" aria-expanded="true">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i> Иностранные абитуриенты
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseFor" class="collapse" aria-labelledby="headingFor"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_foreigner}}
                    </div>

                    @if(!empty($files_cancel))
                        <div id="headingCan">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseCan"
                                    aria-controls="collapseCan" aria-expanded="true">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i>  Приказы об отмене зачисления
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseCan" class="collapse" aria-labelledby="headingCan"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_cancel}}
                    </div>

                    @if(!empty($files_other))
                        <div id="headingOth">
                            <a href="" class="collapsed"  data-toggle="collapse" data-target="#collapseOth"
                                    aria-controls="collapseOth" aria-expanded="true">
                                <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext  text-primary main-color ">
                                    <i class="fas fa-angle-down rotate-icon"></i>   Другие приказы
                                </h5>
                            </a>
                        </div>
                        <hr class="mrsu-bg p-0 m-0">
                        <div id="collapseOth" class="collapse" aria-labelledby="headingOth"
                             data-parent="#accordionExample">
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
                        </div>
                    @endif
                    <div>
                        {{$notif_other}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
@endsection
