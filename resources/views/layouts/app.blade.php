<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css">

    <!-- Styles -->
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">--}}
    <link href="{{ asset('css/sdm-theme.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


    @if (Auth::check())
        <meta name="user" content="{{ Auth::user() }}" />
        <meta name="permissions" content="{{ \App\Models\User::selfPermissions() }}" />
    @endif
</head>
<body>
<div class="d-flex toggled" id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div>
            <a href="/" class="sidebar-heading toggled-hidden" style="display:block">
                <h1 id="SDM">SDM</h1>
                <p class="toggled-hidden" id="subtitle">система дистанционного мониторинга</p>
            </a>
            <div class="sidebar-heading toggled-visible"
                 style="display: flex; flex-direction: row-reverse; height: 117px;align-items: flex-end">
                <h1 id="SDM" style="font-size: 20px !important;
                                    letter-spacing: 2px;
                                    margin-right: 15px;"><a style="color: #6917f1;" href="/">SDM</a></h1>
                <p class="toggled-hidden" id="subtitle"></p>
            </div>
            <div class="list-group list-group-flush zero-list">
                <div class="divider div-transparent"></div>
                <a style="padding-right: 30px" id="menu-toggle" href=""
                   class="list-group-item list-group-item-action roll-up">
                    <div>
                        <svg style="width: 9px; height: 9px; margin-right: 5px" version="1.1" id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px"
                             viewBox="0 0 492 492" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#7224f2" d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
                            </g>
                        </g>
                        </svg>
                        Свернуть
                    </div>
                    <svg id="only-toggle" style="width: 9px; height: 9px; margin-right: 5px; transform: rotate(180deg);"
                         version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px"
                         viewBox="0 0 492 492" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#7224f2" d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
                            </g>
                        </g>
                        </svg>
                </a>
            </div>
            <div class="divider div-transparent"></div>


            <div class="scroll scroll1 list-group list-group-flush first-list">

                @if (Auth::user()->hasAnyPermission("Просмотр рубежа"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/boundaries">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M468.456,1.808c-4.811-2.411-10.478-2.411-15.289,0l0,0L9.433,223.675c-8.429,4.219-11.842,14.471-7.624,22.9
                                    c2.401,4.798,6.919,8.188,12.197,9.151l176.111,32.034l32.034,176.111c1.311,7.219,7.091,12.793,14.353,13.841
                                    c0.803,0.116,1.613,0.173,2.423,0.171c6.469,0.003,12.383-3.651,15.275-9.438L476.07,24.711
                                    C480.292,16.284,476.883,6.03,468.456,1.808z"/>
                            </g>
                        </g>
                        </svg>
                            Рубежи
                        </a>
                        <div style="cursor:pointer" onclick="location.href='{{ url('/boundaries/add') }}'"
                             class="toggled-hidden add-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <a style="height:100%" class="toggled-visible" href="/boundaries" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Рубежи" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M468.456,1.808c-4.811-2.411-10.478-2.411-15.289,0l0,0L9.433,223.675c-8.429,4.219-11.842,14.471-7.624,22.9
                                    c2.401,4.798,6.919,8.188,12.197,9.151l176.111,32.034l32.034,176.111c1.311,7.219,7.091,12.793,14.353,13.841
                                    c0.803,0.116,1.613,0.173,2.423,0.171c6.469,0.003,12.383-3.651,15.275-9.438L476.07,24.711
                                    C480.292,16.284,476.883,6.03,468.456,1.808z"/>
                            </g>
                        </g>
                        </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif

                @if (Auth::user()->hasAnyPermission("Просмотр устройств"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/devices">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M415.232,106.496c-3.072-2.048-6.656-2.048-9.728-0.512l-86.528,44.544v-15.36c0-28.16-23.04-51.2-51.2-51.2H51.2
			c-28.16,0-51.2,23.04-51.2,51.2v149.504c0,28.16,23.04,51.2,51.2,51.2h216.576c28.16,0,51.2-23.04,51.2-51.2v-15.36l86.528,44.544
			c5.12,2.56,11.264,0,13.312-5.12c0.512-1.536,1.024-3.072,1.024-4.096V115.2C419.84,111.616,418.304,108.032,415.232,106.496z"/>
                            </g>
                        </g>
                        </svg>
                            Устройства
                        </a>
                        <div style="cursor:pointer" onclick="location.href='{{ url('/devices/add') }}'"
                             class="toggled-hidden add-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <a style="height:100%" class="toggled-visible" href="/devices" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Устройства" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M415.232,106.496c-3.072-2.048-6.656-2.048-9.728-0.512l-86.528,44.544v-15.36c0-28.16-23.04-51.2-51.2-51.2H51.2
			c-28.16,0-51.2,23.04-51.2,51.2v149.504c0,28.16,23.04,51.2,51.2,51.2h216.576c28.16,0,51.2-23.04,51.2-51.2v-15.36l86.528,44.544
			c5.12,2.56,11.264,0,13.312-5.12c0.512-1.536,1.024-3.072,1.024-4.096V115.2C419.84,111.616,418.304,108.032,415.232,106.496z"/>
                            </g>
                        </g>
                        </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif

                @if (Auth::user()->hasAnyPermission("Просмотр обращений"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/home">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                        c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                        c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                        C368.64,18.432,350.208,0,327.68,0z"/>
                                </g>
                            </g>
                        </svg>
                            Обращения
                            @if (DB::table('tasks')->where('status', 'Актуальные')->count() > 0)
                                <span
                                    class="badge badge-pill badge-danger custom-badge">{{ DB::table('tasks')->where('status', 'Актуальные')->count() }}</span>
                            @endif
                        </a>
                        <div style="cursor:pointer" onclick="location.href='{{ url('/tasks/add') }}'"
                             class="add-icon toggled-hidden">
                            <i class="fas fa-plus"></i>
                        </div>
                        <a style="height:100%" class="toggled-visible" href="/home" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Обращения" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                        c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                        c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                        C368.64,18.432,350.208,0,327.68,0z"/>
                                </g>
                            </g>
                        </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif

                @if (Auth::user()->hasAnyPermission("Просмотр отчетов"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/reports">
                            <svg class="sidebar-icon" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                 width="519.000000pt" height="629.000000pt" viewBox="0 0 519.000000 629.000000"
                                 preserveAspectRatio="xMidYMid meet"
                            >
                                <g transform="translate(0.000000,629.000000) scale(0.100000,-0.100000)" stroke="none">
                                    <path d="M1110 5915 l0 -375 1665 0 1665 0 0 -2215 0 -2215 375 0 375 0 0
                                      2590 0 2590 -2040 0 -2040 0 0 -375z"/>
                                    <path d="M0 2390 l0 -2390 1840 0 1840 0 0 2390 0 2390 -1840 0 -1840 0 0 -2390z"/>
                                </g>
                            </svg>
                            Отчеты
                            @if (false)
                                <span class="badge badge-pill badge-success custom-badge">9</span>
                            @endif
                        </a>
                        <div style="cursor:pointer" onclick="location.href='{{ url('/reports/add') }}'"
                             class="add-icon toggled-hidden">
                            <i class="fas fa-plus"></i>
                        </div>

                        <a style="height:100%" class="toggled-visible" href="/reports" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Отчеты" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                 width="519.000000pt" height="629.000000pt" viewBox="0 0 519.000000 629.000000"
                                 preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,629.000000) scale(0.100000,-0.100000)"
                                   stroke="none">
                                    <path d="M1110 5915 l0 -375 1665 0 1665 0 0 -2215 0 -2215 375 0 375 0 0
                                      2590 0 2590 -2040 0 -2040 0 0 -375z"/>
                                    <path d="M0 2390 l0 -2390 1840 0 1840 0 0 2390 0 2390 -1840 0 -1840 0 0 -2390z"/>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif

                @if (Auth::user()->hasAnyPermission("Просмотр карты"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/map">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M256,0C156.011,0,74.667,81.344,74.667,181.333c0,96.725,165.781,317.099,172.843,326.443
                                          c1.984,2.667,5.163,4.224,8.491,4.224c3.328,0,6.507-1.557,8.491-4.224c7.061-9.344,172.843-229.717,172.843-326.443
                                          C437.333,81.344,355.989,0,256,0z M256,277.333c-52.928,0-96-43.072-96-96c0-52.928,43.072-96,96-96s96,43.072,96,96
                                          C352,234.261,308.928,277.333,256,277.333z"/>
                                </g>
                            </g>
                        </svg>
                            Карта
                        </a>
                        <a style="height:100%" class="toggled-visible" href="/map" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Карта" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M256,0C156.011,0,74.667,81.344,74.667,181.333c0,96.725,165.781,317.099,172.843,326.443
                                        c1.984,2.667,5.163,4.224,8.491,4.224c3.328,0,6.507-1.557,8.491-4.224c7.061-9.344,172.843-229.717,172.843-326.443
                                        C437.333,81.344,355.989,0,256,0z M256,277.333c-52.928,0-96-43.072-96-96c0-52.928,43.072-96,96-96s96,43.072,96,96
                                        C352,234.261,308.928,277.333,256,277.333z"/>
                                </g>
                            </g>
                        </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif

                @if (Auth::user()->hasAnyPermission("Просмотр сводки"))
                    <div class="list-group-item list-group-item-action">
                        <a class="first-list-link toggled-hidden" href="/summary">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve">
                            <path id="XMLID_530_" d="M367.468,175.996c-3.368-5.469-9.317-8.807-15.734-8.807h-84.958l45.919-143.098
                                c1.797-5.614,0.816-11.76-2.662-16.521c-3.464-4.748-9.014-7.57-14.9-7.57h-84.446c-8.02,0-15.125,5.18-17.563,12.814
                                l-68.487,213.465c-1.797,5.613-0.817,11.756,2.663,16.52c3.464,4.748,9.013,7.57,14.899,7.57h14.868h68.183l-22.006,235.037
                                c-0.352,3.736,2.004,7.185,5.614,8.227c3.593,1.045,7.427-0.608,9.126-3.961L368.19,194.01
                                C371.093,188.281,370.82,181.467,367.468,175.996z"/>
                        </svg>
                            Сводка
                        </a>
                        <a style="height:100%" class="toggled-visible" href="/summary" data-bs-toggle="tooltip"
                           data-bs-placement="right" title="Сводка" data-bs-custom-class="sdm-primary-tooltip">
                            <svg class="sidebar-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 477.883 477.883" xml:space="preserve"
                            >
                            <path id="XMLID_530_" d="M367.468,175.996c-3.368-5.469-9.317-8.807-15.734-8.807h-84.958l45.919-143.098
                                c1.797-5.614,0.816-11.76-2.662-16.521c-3.464-4.748-9.014-7.57-14.9-7.57h-84.446c-8.02,0-15.125,5.18-17.563,12.814
                                l-68.487,213.465c-1.797,5.613-0.817,11.756,2.663,16.52c3.464,4.748,9.013,7.57,14.899,7.57h14.868h68.183l-22.006,235.037
                                c-0.352,3.736,2.004,7.185,5.614,8.227c3.593,1.045,7.427-0.608,9.126-3.961L368.19,194.01
                                C371.093,188.281,370.82,181.467,367.468,175.996z"/>
                        </svg>
                        </a>
                    </div>
                    <div class="divider div-transparent"></div>
                @endif


            </div>


        </div>
        <a
            style="margin-left: 50px; margin-bottom: 20px;color: white;font-size: 18px;width: 10px"
            tabindex="0"
            role="button" data-toggle="popover" data-trigger="focus"
            class="mdi mdi-dots-horizontal popover-no-focus toggled-hidden"
            data-placement="top"
            data-html="true"
            data-content='
                <a href="/users"><div>Пользователи</div></a><br>
                <a href="/dictionary-types"><div>Справочники</div></a><br>
                <a href="/operations-history"><div>История операций</div></a><br>
                <a href="/system-info"><div>Информация о системе</div></a>
            '
        ></a>
        <a
            style="margin-left: 260px; margin-bottom: 20px;color: white;font-size: 18px;width: 10px"
            tabindex="0"
            role="button" data-toggle="popover" data-trigger="focus"
            class="mdi mdi-dots-horizontal popover-no-focus toggled-visible"
            data-placement="top"
            data-html="true"
            data-content='
                <a href="/users"><div>Пользователи</div></a><br>
                <a href="/dictionary-types"><div>Справочники</div></a><br>
                <a href="/operations-history"><div>История операций</div></a><br>
                <a href="/system-info"><div>Информация о системе</div></a>
            '
        ></a>
        <div id="styled-list-group">
            @if (Auth::user()->hasAnyPermission("Просмотр пользователей"))
                <a href="/users" class="list-group-item list-group-item-action">
                    <div>Пользователи</div>
                </a>
            @endif

            @if (Auth::user()->hasAnyPermission("Просмотр тип справочников"))
                <a href="/dictionary-types" class="list-group-item list-group-item-action">
                    <div>Справочники</div>
                </a>
            @endif

            @if (Auth::user()->hasAnyPermission("Просмотр истории"))
                <a href="/operations-history" class="list-group-item list-group-item-action">
                    <div>История операций</div>
                </a>
            @endif

            @if (Auth::user()->hasAnyPermission("Просмотр системной информации"))
                <a href="/system-info" class="list-group-item list-group-item-action">
                    <div>Информация о системе</div>
                </a>
            @endif
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" style="width:100%">
        <div class="container-fluid" id="app">
            <notifications position="bottom left" classes="sdm-notification"></notifications>
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>
