<template>
    <div>
        <div class="row w-100 m-auto justify-content-end align-items-center">
            <div style="z-index: 9" class="col-12 col-md-6 col-lg-9">
                <ol
                    class="breadcrumb pl-0 m-0 align-items-center"
                    style="background-color: transparent"
                >
                    <li class="">
                        <a
                            href="/"
                            style="color: #9d9ea5; text-decoration: none"
                        >
                            Панель управления
                        </a>
                    </li>
                    <li class="">
                        <div
                            class="mx-3 mdi mdi-dots-horizontal"
                            style="color: rgb(157, 158, 165);font-size: 17px;"
                        ></div>
                    </li>
                    <li class="" aria-current="page">
                        <a
                            href="/system-info"
                            style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                        >
                            Информация о системе
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <user-menu :user="user"></user-menu>
            </div>
            <div
                class="col-12"
                style="border-bottom: 1px solid #e3e3e5"
            >
            </div>
        </div>
        <div class="row w-100 m-auto align-items-start justify-content-center">
            <div class="col-9">
                <div class="row w-100 mx-auto justify-content-center align-items-center">
                    <div class="col-12 px-2">
                        <h3 class="my-4 text-wrap text-break" style="font-weight: 700; font-size: 32px; font-family: Montserrat;">
                            <span class="sdm-primary-label">SDM</span> - система дистанционного мониторинга
                        </h3>
                    </div>
                    <div class="col-12 px-2">
                        <h4 class="mb-3" style="font-size: 16px">Система предназначена для автоматизированного сбора, обработки, накопления данных,
                            формирования отчетности о работе комплексов фото-, видео-фиксации (ФВФ).
                        </h4>
                    </div>
                    <div class="col-12 px-2">
                        <h4 style="font-size: 16px"><strong>Обеспечивает:</strong></h4>
                    </div>
                </div>
                <div class="row w-100 mx-auto row-cols-md-3 g-4">
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 508 508" style="height:50px; width:50px; enable-background:new 0 0 508 508;" xml:space="preserve">
                                            <path d="M155.7,258.1c-49.7,0-90.1,40.4-90.1,90.1s40.4,90.1,90.1,90.1s90.1-40.4,90.1-90.1S205.4,258.1,155.7,258.1z M155.7,422
                                                C115,422,82,388.9,82,348.3c0-40.6,33.1-73.7,73.7-73.7c40.6,0,73.7,33.1,73.7,73.7C229.4,388.9,196.3,422,155.7,422z"/>

                                            <path d="M376.9,77.8c-31.6,0-57.4,25.7-57.4,57.4c0,31.6,25.7,57.4,57.4,57.4c31.6,0,57.4-25.7,57.4-57.4
                                                C434.3,103.6,408.5,77.8,376.9,77.8z M376.9,176.2c-22.6,0-41-18.4-41-41c0-22.6,18.4-41,41-41c22.6,0,41,18.4,41,41
                                                C417.9,157.8,399.5,176.2,376.9,176.2z"/>
                                            <path d="M311.5,382.1v-68l-28.3-9.4c-2-5.3-4.2-10.7-6.7-15.8l13.3-26.7l-48.1-48.1L215,227.4c-5.2-2.6-10.5-4.8-16-6.6l-9.4-28.3
                                                h-68l-9.4,28.3c-5.4,1.9-10.8,4.1-16,6.6l-26.7-13.3l-48.1,48.1l13.3,26.7c-2.6,5.2-4.8,10.5-6.6,16L0,314.2v68l28.3,9.4
                                                c1.9,5.4,4.1,10.8,6.6,16l-13.3,26.7l48.1,48.1L96.3,469c5.2,2.6,10.5,4.8,16,6.6l9.4,28.3h68l9.4-28.3c5.4-1.9,10.8-4.1,16-6.6
                                                l26.7,13.3l48.1-48.1l-13.3-26.7c2.6-5.2,4.8-10.5,6.6-16L311.5,382.1z M270,378.7l-11.9,28.7l11.8,23.6l-31.4,31.4l-23.6-11.8
                                                l-28.7,11.9l-8.3,25h-44.4l-8.3-25l-28.7-11.9l-23.6,11.8L41.5,431l11.8-23.6l-11.9-28.7l-25-8.3V326l25-8.3L53.3,289l-11.8-23.6
                                                L72.9,234l23.6,11.8l28.7-11.9l8.3-25h44.4l8.3,25l28.7,11.9l23.6-11.8l31.4,31.4L258.1,289l11.9,28.7l25,8.3v44.4L270,378.7z"/>
                                            <path d="M508,164.5v-58.6L484.2,98c-1.4-4.1-3.1-8.2-5.1-12.2l11.2-22.5l-41.5-41.5L426.4,33c-4-1.9-8.1-3.6-12.2-5.1l-8-23.8
                                                h-58.6l-8,23.8c-4.1,1.4-8.2,3.1-12.2,5.1l-22.5-11.3l-41.5,41.5l11.3,22.5c-1.9,4-3.6,8.1-5.1,12.2l-23.8,7.9v58.6l23.8,7.9
                                                c1.4,4.1,3.1,8.2,5.1,12.2L263.4,207l41.5,41.5l22.5-11.2c4,1.9,8.1,3.6,12.2,5.1l8,23.8h58.6l8-23.8c4.1-1.4,8.2-3.1,12.2-5.1
                                                l22.5,11.2l41.5-41.5l-11.2-22.5c1.9-4,3.6-8.1,5.1-12.2L508,164.5z M471,159.6l-10.4,25l9.7,19.4l-24.8,24.8l-19.4-9.7l-25,10.4
                                                l-6.9,20.6h-35l-6.9-20.6l-25-10.4l-19.4,9.7L283.1,204l9.7-19.4l-10.4-25l-20.6-6.9v-35l20.6-6.9l10.4-25l-9.7-19.4l24.8-24.8
                                                l19.4,9.7l25-10.4l6.9-20.6h35l6.9,20.6l25,10.4l19.4-9.7l24.8,24.8l-9.7,19.4l10.4,25l20.6,6.9v35L471,159.6z"/>
                                            <rect x="147.5" y="225.3" width="16.4" height="16.4"/>
                                            <rect x="147.5" y="454.7" width="16.4" height="16.4"/>
                                            <rect x="228.565" y="258.914" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -119.5312 245.6541)" width="16.4" height="16.4"/>

                                            <rect x="66.308" y="421.144" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -281.769 178.4373)" width="16.4" height="16.4"/>
                                            <rect x="262.2" y="340" width="16.4" height="16.4"/>
                                            <rect x="32.8" y="340" width="16.4" height="16.4"/>

                                            <rect x="228.567" y="421.162" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -234.2576 293.1767)" width="16.4" height="16.4"/>

                                            <rect x="66.393" y="258.922" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -167.0355 130.9835)" width="16.4" height="16.4"/>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Контроль фиксации правонарушений и проездов транспортными средствами.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 508 508" style="width:50px; height:50px; enable-background:new 0 0 508 508;" xml:space="preserve">
                                            <polygon points="376.9,8.2 376.9,24.6 406.3,24.6 237.6,193.3 155.7,111.3 51.6,215.4 63.1,227 155.7,134.5 237.6,216.4
                                                417.9,36.2 417.9,65.5 434.3,65.5 434.3,8.2 		"/>
                                            <path d="M491.6,483.4L491.6,483.4V122.9h-81.9v360.5h-16.4V172.1h-81.9v311.4H295V286.8h-82v196.6h-16.4V237.6h-81.9v245.8H98.3
                                                V368.7H16.4v114.7H0v16.4h508v-16.4H491.6z M82,483.4H32.8v-98.3H82V483.4z M180.3,483.4h-49.2V254h49.2V483.4z M278.6,483.5
                                                h-49.2V303.2h49.2V483.5z M376.9,483.5h-49.2v-295h49.2V483.5z M475.3,483.4h-49.2V139.3h49.2V483.4z"/>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Визуализация результатов мониторинга в виде таблиц и графиков с использованием Web-технологий.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                             width="50" height="50" viewBox="0 0 544.000000 739.000000"
                                             preserveAspectRatio="xMidYMid meet">
                                            <g transform="translate(0.000000,739.000000) scale(0.100000,-0.100000)"
                                               fill="#000000" stroke="none">
                                                <path d="M2340 7374 c-217 -33 -477 -109 -687 -200 -56 -24 -105 -44 -109 -44
                                                    -14 0 -241 -134 -344 -203 -540 -363 -952 -944 -1121 -1580 -61 -232 -71 -312
                                                    -76 -589 -6 -291 2 -359 64 -583 39 -140 161 -477 224 -615 408 -901 1224
                                                    -2121 2258 -3372 85 -104 162 -188 171 -188 28 0 460 530 831 1020 352 463
                                                    778 1078 999 1440 45 74 98 160 117 190 122 196 376 674 478 900 120 266 247
                                                    654 281 853 24 144 16 566 -15 722 -112 584 -383 1092 -793 1491 -132 128
                                                    -246 222 -378 311 -103 69 -330 203 -344 203 -4 0 -53 20 -109 44 -216 94
                                                    -474 168 -698 201 -141 20 -612 19 -749 -1z m660 -289 c263 -23 486 -86 755
                                                    -213 406 -190 738 -475 984 -842 76 -114 189 -314 196 -348 2 -9 19 -54 39
                                                    -100 91 -212 154 -473 177 -732 26 -307 -27 -585 -186 -975 -20 -49 -38 -97
                                                    -40 -105 -14 -64 -237 -507 -397 -785 -156 -272 -237 -402 -483 -773 -183
                                                    -276 -267 -397 -451 -651 -283 -391 -854 -1126 -874 -1126 -20 0 -591 735
                                                    -874 1126 -184 254 -268 375 -451 651 -246 371 -327 501 -483 773 -160 278
                                                    -383 721 -397 785 -2 8 -20 56 -40 105 -159 390 -212 668 -186 975 23 259 86
                                                    520 177 732 20 46 37 91 39 100 7 34 120 234 196 348 338 505 869 872 1469
                                                    1015 215 51 535 66 830 40z"/>
                                                <path d="M2578 6449 c-112 -9 -297 -46 -394 -79 -32 -11 -64 -20 -73 -20 -24
                                                    0 -225 -100 -321 -159 -238 -148 -474 -389 -612 -625 -103 -174 -186 -399
                                                    -224 -601 -27 -141 -27 -458 0 -600 45 -243 176 -546 322 -746 97 -131 269
                                                    -304 401 -402 182 -135 467 -262 703 -313 124 -28 556 -28 680 0 236 51 521
                                                    179 703 313 230 171 421 396 547 645 80 157 148 351 176 503 26 138 26 470 1
                                                    600 -52 266 -153 505 -303 723 -87 125 -315 354 -444 444 -109 77 -349 202
                                                    -430 224 -288 77 -350 89 -530 97 -52 3 -143 1 -202 -4z m377 -304 c235 -38
                                                    451 -127 645 -264 94 -67 242 -212 316 -310 84 -112 204 -353 244 -491 140
                                                    -488 20 -1018 -319 -1407 -169 -194 -422 -359 -670 -437 -251 -79 -651 -79
                                                    -902 0 -248 78 -501 243 -670 437 -285 326 -421 767 -365 1182 23 174 65 307
                                                    151 480 87 177 166 286 297 411 225 215 487 346 798 399 105 18 365 18 475 0z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Использование ГИС-технологий для вывода мест расположения устройств ФВФ и информации об их состоянии на интерактивные карты.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 508 508" style="width:50px; height:50px; enable-background:new 0 0 508 508;" xml:space="preserve">
                                            <path d="M483.4,81.9H24.6C11,81.9,0,93,0,106.5v295c0,13.6,11,24.6,24.6,24.6h458.8c13.6,0,24.6-11,24.6-24.6v-295
                                                C508,93,497,81.9,483.4,81.9z M477.1,98.3L254,284.3L30.8,98.3H477.1z M16.4,400.4V107.6L192,254L16.4,400.4z M30.8,409.7l174-145
                                                l49.2,41l49.2-41l174,145H30.8z M491.7,400.4L316,254l175.7-146.4V400.4z"/>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Создание и рассылку отчетных форм по заданным параметрам за период.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 508 508" style="width:50px; height:50px; enable-background:new 0 0 508 508;" xml:space="preserve">
                                            <path d="M212.977,49.2v147.5h114.7V49.2H212.977z M311.277,180.3h-81.9V65.5h81.9V180.3z"/>
                                            <rect x="65.477" y="245.8" width="262.2" height="16.4"/>
                                            <rect x="65.477" y="311.4" width="221.2" height="16.4"/>
                                            <rect x="65.477" y="376.9" width="155.7" height="16.4"/>
                                            <rect x="65.477" y="442.5" width="65.5" height="16.4"/>
                                            <rect x="147.477" y="442.5" width="49.2" height="16.4"/>
                                            <path d="M484.378,243.4l-23.2-23.2c-9.3-9.3-25.5-9.3-34.8,0l-49.6,49.6V0h-208.1l-152.3,152.3V508h360.5V385.7l107.5-107.5
                                                C488.977,273.5,498.078,257.1,484.378,243.4z M163.878,28v119.5h-119.6L163.878,28z M360.477,491.6h-327.7V163.9h147.5V16.4h180.3
                                                v269.8l-98,98l-14.6,72.4l72.4-14.5l40.1-40.1V491.6z M281.578,388.2l23.2-23.2l34.8,34.8l-23.2,23.2L281.578,388.2z
                                                 M299.777,429.6l-30.9,6.2l6.2-30.9L299.777,429.6z M351.078,388.2l-34.8-34.8l104.3-104.3l11.6,11.6l-40.6,40.6l11.6,11.6
                                                l40.6-40.6l11.6,11.6L351.078,388.2z M472.777,266.6l-5.8,5.8l-34.8-34.8l5.8-5.8c3.1-3.1,8.5-3.1,11.6,0l23.2,23.2
                                                C477.777,260,474.378,265,472.777,266.6z"/>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Создание обращений для выполнения технических работ и контроля их исполнения.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="card h-100 my-2" style="border-radius:5px; border:1px solid #dfe1ee; background: transparent">
                            <div class="card-body">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-12 p-0 sdm-primary-svg">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 508 508" style="width:50px; height:50px; enable-background:new 0 0 508 508;" xml:space="preserve">
                                            <path d="M112.2,87.8c11.5-9,18.9-23,18.9-38.6C131.1,22.1,109,0,81.9,0C54.8,0,32.8,22.1,32.8,49.2c0,15.7,7.4,29.6,18.9,38.6
                                                C21.4,99.9,0,129.4,0,163.9v32.8h163.9v-32.8C163.9,129.4,142.4,99.9,112.2,87.8z M49.2,49.2c0-18.1,14.7-32.8,32.8-32.8
                                                s32.8,14.7,32.8,32.8C114.8,67.3,100.1,82,82,82C63.9,81.9,49.2,67.2,49.2,49.2z M16.4,180.3v-16.4c0-36.1,29.4-65.5,65.5-65.5
                                                c36.1,0,65.5,29.4,65.5,65.5v16.4H16.4z"/>
                                            <path d="M456.4,87.8c11.5-9,18.9-23,18.9-38.6c0-27.1-22.1-49.2-49.2-49.2c-27.1,0-49.2,22.1-49.2,49.2c0,15.7,7.4,29.6,18.9,38.6
                                                c-30.2,12.1-51.6,41.6-51.6,76.1v32.8H508v-32.8C508,129.4,486.6,99.9,456.4,87.8z M393.3,49.2c0-18.1,14.7-32.8,32.8-32.8
                                                c18.1,0,32.8,14.7,32.8,32.8c0,18.1-14.7,32.8-32.8,32.8C408,81.9,393.3,67.2,393.3,49.2z M360.5,180.3v-16.4
                                                c0-36.1,29.4-65.5,65.5-65.5c36.1,0,65.5,29.4,65.5,65.5v16.4H360.5z"/>
                                            <path d="M284.3,399.2c11.5-9,18.9-23,18.9-38.6c0-27.1-22.1-49.2-49.2-49.2s-49.2,22.1-49.2,49.2c0,15.7,7.4,29.6,18.9,38.6
                                                c-30.2,12.1-51.6,41.6-51.6,76.1V508H336v-32.8C335.9,440.8,314.5,411.2,284.3,399.2z M221.2,360.5c0-18.1,14.7-32.8,32.8-32.8
                                                c18.1,0,32.8,14.7,32.8,32.8s-14.7,32.8-32.8,32.8S221.2,378.6,221.2,360.5z M319.5,491.6h-131v-16.4c0-36.1,29.4-65.5,65.5-65.5
                                                c36.1,0,65.5,29.4,65.5,65.5V491.6z"/>
                                            <polygon points="313.8,125.3 254,185.1 194.2,125.3 182.7,136.9 245.8,200 245.8,295 262.2,295 262.2,200 325.3,136.9 		"/>
                                        </svg>
                                    </div>
                                    <div class="col-12 mt-3 p-0 sdm-primary-text" style="font-size:11px !important">
                                        Поддержку процессов принятия решений операторами и руководством организации о действиях по устранения. проблем в работе устройств ФВФ.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mx-auto mt-3 justify-content-center align-items-center">
                    <div class="col-12 px-2">
                        <div class="row w-100 mx-auto py-3 justify-content-center align-items-center" style="background:#050c42; color:white; border-radius: 5px">
                            <div class="col-9">
                                <div class="row w-100 mx-auto justify-content-center align-items-center">
                                    <div class="col-1 p-0 sdm-primary-svg">
                                        <svg height="31" viewBox="0 0 512 512" width="31" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m277.332031 128c0 11.78125-9.550781 21.332031-21.332031 21.332031s-21.332031-9.550781-21.332031-21.332031 9.550781-21.332031 21.332031-21.332031 21.332031 9.550781 21.332031 21.332031zm0 0"/>
                                            <path d="m256 405.332031c-8.832031 0-16-7.167969-16-16v-165.332031h-21.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h37.332031c8.832031 0 16 7.167969 16 16v181.332031c0 8.832031-7.167969 16-16 16zm0 0"/>
                                            <path d="m256 512c-141.164062 0-256-114.835938-256-256s114.835938-256 256-256 256 114.835938 256 256-114.835938 256-256 256zm0-480c-123.519531 0-224 100.480469-224 224s100.480469 224 224 224 224-100.480469 224-224-100.480469-224-224-224zm0 0"/>
                                            <path d="m304 405.332031h-96c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h96c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/>
                                        </svg>
                                    </div>
                                    <div class="col-11 p-0 sdm-primary-text" style="font-size: 11px;">
                                        Может использоваться в комплексном мониторинге безопасности дорожного движения и анализе состояния дорожной аварийности с целью устранения проблем.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card my-3" style="border-radius:5px; border:none ">
                    <div class="card-body">
                        <div class="row w-100 mx-auto justify-content-center align-items-center">
                            <div class="col-12 p-1">
                                <h4 style="font-size: 16px">
                                    <strong>Техническая поддержка</strong>
                                </h4>
                            </div>
                            <div class="col-12 p-1 sdm-primary-text">
                                Прием обращений по технической поддержке осуществляется
                                <span class="sdm-primary-label">
                                    <strong>с 9:00 до 18:00</strong>
                                </span>
                            </div>
                            <div
                                class="col-12 my-4"
                                style="border-bottom: 1px solid #e3e3e5"
                            >
                            </div>
                            <div class="col-12 p-1">
                                <h4 style="font-size: 16px">8 (8412) 32-93-94 </h4>
                            </div>
                            <div class="col-12 p-1">
                                <a href="mailto:inbox@br.pnzreg.ru" style="font-size: 16px; border-bottom: 1px solid #7c34f2">inbox@br.pnzreg.ru</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mx-auto justify-content-center align-items-center invisible" >
                    <button class="btn w-100 mb-1 sdm-primary-button" @click="downloadPresentation">
                        Презентация
                    </button>
                    <button class="btn w-100 mb-1 sdm-primary-button" @click="downloadRecommendations">
                        Рекомендации
                    </button>
                    <button class="btn w-100 mb-1 sdm-primary-button" @click="downloadManual">
                        Руководство пользователя
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SystemInfoPage",
        props:['user'],
        methods: {
            downloadPresentation() {
                //todo:method for dowloading file of presentation
            },
            downloadRecommendations() {
                //todo:method for dowloading file of recommendations
            },
            downloadManual() {
                //todo:method for dowloading file of user's manual
            }
        }
    }
</script>

<style scoped>

</style>
