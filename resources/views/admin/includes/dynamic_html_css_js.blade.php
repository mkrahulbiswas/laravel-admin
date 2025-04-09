{{-- @if ($checkOne == 'loginPage')
    @if ($checkTwo == 'cssJs')
        <script>
            $(window).on('load', function() {
                $('#pageLoader').fadeOut(500);
            });
        </script>
    @endif
@else
    @if ($checkTwo == 'cssJs')
        @foreach ($reqData['customizeButton'] as $item)
            @if (config('constants.addBtn') == $item['btnFor'])
                <style>
                    .addBtn:hover,
                    .addBtn i:hover {
                        color: white;
                    }

                    .addBtn,
                    .addBtn i {
                        background-color: #e6bd15;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.addBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.saveBtn') == $item['btnFor'])
                <style>
                    .saveBtn:hover,
                    .saveBtn i:hover {
                        color: white;
                    }

                    .saveBtn,
                    .saveBtn i {
                        background-color: #e6bd15;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.saveBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.updateBtn') == $item['btnFor'])
                <style>
                    .updateBtn:hover,
                    .updateBtn i:hover {
                        color: white;
                    }

                    .updateBtn,
                    .updateBtn i {
                        background-color: #e6bd15;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.updateBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.searchBtn') == $item['btnFor'])
                <style>
                    .searchBtn:hover,
                    .searchBtn i:hover {
                        color: white;
                    }

                    .searchBtn,
                    .searchBtn i {
                        background-color: #2960b3;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.searchBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.reloadBtn') == $item['btnFor'])
                <style>
                    .reloadBtn:hover,
                    .reloadBtn i:hover {
                        color: white;
                    }

                    .reloadBtn,
                    .reloadBtn i {
                        background-color: #2992b3;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.reloadBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.printBtn') == $item['btnFor'])
                <style>
                    .printBtn:hover,
                    .printBtn i:hover {
                        color: white;
                    }

                    .printBtn,
                    .printBtn i {
                        background-color: #9a08ad;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.printBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.backBtn') == $item['btnFor'])
                <style>
                    .backBtn:hover,
                    .backBtn i:hover {
                        color: white;
                    }

                    .backBtn,
                    .backBtn i {
                        background-color: #e6bd15;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.backBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.downloadBtn') == $item['btnFor'])
                <style>
                    .downloadBtn:hover,
                    .downloadBtn i:hover {
                        color: white;
                    }

                    .downloadBtn,
                    .downloadBtn i {
                        background-color: #b751c6;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.downloadBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @elseif(config('constants.detailBtn') == $item['btnFor'])
                <style>
                    .detailBtn:hover,
                    .detailBtn i:hover {
                        color: white;
                    }

                    .detailBtn,
                    .detailBtn i {
                        background-color: #b751c6;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.detailBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @else
                <style>
                    .closeBtn:hover,
                    .closeBtn i:hover {
                        color: white;
                    }

                    .closeBtn,
                    .closeBtn i {
                        background-color: #d53957;
                        color: white;
                        transition: all 0.3s ease-out;
                    }
                </style>

                <script>
                    $('.closeBtn').find('i').attr('class', "{{ $item['btnIcon'] }}");
                </script>
            @endif
        @endforeach


        @if (in_array('appearance', $urlArray) && in_array('table', $urlArray) && in_array('details', $urlArray))
            <style>
                .tableStyle thead {
                    background-color: rgba({{ $data['headBackColor'] }});
                    color: rgba({{ $data['headTextColor'] }});
                    transition: all 0.3s ease-out;
                }

                .tableStyle thead:hover {
                    background-color: rgba({{ $data['headHoverBackColor'] }});
                    color: rgba({{ $data['headHoverTextColor'] }});
                }

                .tableStyle tbody {
                    background-color: rgba({{ $data['bodyBackColor'] }});
                    color: rgba({{ $data['bodyTextColor'] }});
                    transition: all 0.3s ease-out;
                }

                .tableStyle tbody:hover {
                    background-color: rgba({{ $data['bodyHoverBackColor'] }});
                    color: rgba({{ $data['bodyHoverTextColor'] }});
                }
            </style>
        @else
            <style>
                .tableStyle thead {
                    background-color: #581845;
                    color: rgba({{ $reqData['customizeTable']['headTextColor'] }});
                    transition: all 0.3s ease-out;
                }

                .tableStyle thead:hover {
                    background-color: #581845;
                    color: rgba({{ $reqData['customizeTable']['headHoverTextColor'] }});
                }

                /* .tableStyle thead tr{
                font-family: {{ $reqData['customizeTable']['headTableStyle']->fontType }} !important;
                font-style: {{ $reqData['customizeTable']['headTableStyle']->fontStyle }} !important;
                font-weight: {{ $reqData['customizeTable']['headTableStyle']->fontWeight }} !important;
                font-size: {{ $reqData['customizeTable']['headTableStyle']->fontSize }}px !important;
                text-decoration: {{ $reqData['customizeTable']['headTableStyle']->decorationType }} {{ $reqData['customizeTable']['headTableStyle']->decorationStyle }} rgba({{ $reqData['customizeTable']['headTableStyle']->decorationColor }}) {{ $reqData['customizeTable']['headTableStyle']->decorationSize }}px !important;
            } */

                .tableStyle tbody {
                    background-color: rgba({{ $reqData['customizeTable']['bodyBackColor'] }});
                    color: rgba({{ $reqData['customizeTable']['bodyTextColor'] }});
                    transition: all 0.3s ease-out;
                }

                /* .tableStyle tbody tr{
                font-family: {{ $reqData['customizeTable']['bodyTableStyle']->fontType }} !important;
                font-style: {{ $reqData['customizeTable']['bodyTableStyle']->fontStyle }} !important;
                font-weight: {{ $reqData['customizeTable']['bodyTableStyle']->fontWeight }} !important;
                font-size: {{ $reqData['customizeTable']['bodyTableStyle']->fontSize }}px !important;
                text-decoration: {{ $reqData['customizeTable']['bodyTableStyle']->decorationType }} {{ $reqData['customizeTable']['bodyTableStyle']->decorationStyle }} rgba({{ $reqData['customizeTable']['bodyTableStyle']->decorationColor }}) {{ $reqData['customizeTable']['bodyTableStyle']->decorationSize }}px !important;
            } */

                .tableStyle tbody:hover {
                    background-color: rgba({{ $reqData['customizeTable']['bodyHoverBackColor'] }});
                    color: rgba({{ $reqData['customizeTable']['bodyHoverTextColor'] }});
                }
            </style>
        @endif


        <style>
            .card-box {
                border-top: 3px solid #581845 !important;
            }
        </style>

        <!-- Loader Load End -->
        <script>
            $(window).on('load', function() {
                $('#pageLoader').fadeOut(500);
            });
        </script>
    @endif
@endif --}}

@if ($checkTwo == 'loader')

    <div id="pageLoader" class="pageLoader">
        {!! $reqData['customizeLoader']['pageLoader']['raw']->html !!}
    </div>

    <div id="internalLoader" class="internalLoader">
        {!! $reqData['customizeLoader']['internalLoader']['raw']->html !!}
    </div>

    <style>
        {!! $reqData['customizeLoader']['internalLoader']['raw']->css !!} {!! $reqData['customizeLoader']['pageLoader']['raw']->css !!}
    </style>
@elseif($checkTwo == 'alertMessage')
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation"></i> &nbsp;Error!</strong> {{ $message }}.
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-check"></i> &nbsp;Success!</strong> {{ $message }}.
        </div>
    @endif
@endif
