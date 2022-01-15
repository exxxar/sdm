<template>
    <div>
        <layout :title="'Обращение №'+appeal.id" :info="false">
            <template v-slot:menu>
                <div class="row w-100 m-auto justify-content-end align-items-center">
                    <div style="z-index: 9" class="col-12 col-md-6 col-lg-9">
                        <ol
                            class="breadcrumb m-0 align-items-center"
                            style="background-color: transparent; padding-left: 0"
                        >
                            <li class="">
                                <a
                                    href="/home"
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
                            <li class="">
                                <a
                                    href="/home"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Обращения
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
                                    href="#"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Обращение №{{appeal.id}}
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
                    ></div>
                </div>
            </template>
            <template v-slot:header>
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                     v-if="appeal.status === 'Актуальные'">
                    <div class="col-12 col-md-4 col-sm-6 pr-0">
                        <div class="p-1 float-right" style="color: #d93030; font-size: 18px; width: 36px">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                 y="0px" width="15" height="15"
                                 viewBox="0 0 423.936 423.936" style="enable-background:new 0 0 423.936 423.936;"
                                 xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#d93030" d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                            c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                            c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                            C368.64,18.432,350.208,0,327.68,0z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <!--     <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1" v-if="appeal.custom_reason==null">
                             <button
                                 @click="showCustomReasonEdit"
                                 type="button"
                                 class="btn w-100 btn-dark my-1 mr-1 py-2"
                                 style="background: transparent;border: 1px solid #7224f2; color:black; font-size: 11px;font-weight: 500;"
                             >
                                 Добавить примечание
                             </button>
                         </div>-->
                    <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <a
                            :href="`/tasks/edit/${appeal.id}`"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: transparent;border: 1px solid #7224f2; color:black; font-size: 11px;font-weight: 500;"
                        >
                            Редактировать
                        </a>
                    </div>
                    <div class="col-12 col-md-2 col-sm-6 px-0" v-if="appeal.report_id==null">
                        <button
                            @click="goToReports"
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: #448d3b;border: none;color: white;font-size: 11px;font-weight: 500;"

                        >
                            Создать отчет
                        </button>
                    </div>
                </div>
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                     v-if="appeal.status === 'Готово' && user.role !=='admin'">
                    <div class="col-12 col-md-4 col-sm-6 pr-0">
                        <button
                            @click="editReport"
                            type="button"
                            class="btn my-1 btn-dark py-2 float-right"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Редактировать отчет
                        </button>
                        <div class="p-1 float-right" style="font-size: 18px; width: 36px">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                 y="0px" width="15" height="15"
                                 viewBox="0 0 423.936 423.936" style="enable-background:new 0 0 423.936 423.936;"
                                 xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#458e3c" d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                            c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                            c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                            C368.64,18.432,350.208,0,327.68,0z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                     v-if="appeal.status === 'Актуальные' && user.role =='admin'">
                    <div class="col-12 col-md-3 col-sm-6 pr-1">
                        <div class="p-1 float-right" style="font-size: 18px; width: 36px">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                 y="0px" width="15" height="15"
                                 viewBox="0 0 423.936 423.936" style="enable-background:new 0 0 423.936 423.936;"
                                 xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#d93030" d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                            c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                            c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                            C368.64,18.432,350.208,0,327.68,0z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <button class="btn my-1 mr-1 py-1 border-copy-button float-right">
                            <span style="font-size: 10px; border-bottom: 2px solid #d93030"
                            >
                                Удалить обращение
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 pl-1 pr-0 pr-sm-1">
                        <button
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: transparent; border: 1px solid #7224f2; color: #000000; font-size: 11px; font-weight: 500;"
                        >
                            Добавить примечание
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 px-1">
                        <button
                            type="button"
                            class="btn my-1 mr-1 btn-dark py-2"
                            style="background: #7224f2; border: none; color: white; font-size: 11px; font-weight: 500;"
                        >
                            Напомнить
                        </button>
                        <button
                            class="btn p-1 mr-1 mdi mdi-pencil"
                            style="height:36px; width: 36px; min-width: 36px; border: 1px solid #dfe1ee; color: black; background: transparent"
                        ></button>
                        <button
                            v-if="appeal.status === 'Готово'"
                            class="btn p-1 mx-0 mdi mdi-close"
                            style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                        ></button>
                        <button
                            v-else
                            class="btn p-1 mx-0 mdi mdi-close"
                            style="height:36px; width: 36px; min-width: 36px; background: #dfe1ee; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                            disabled
                        ></button>
                    </div>
                </div>
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                     v-if="appeal.status === 'Готово' && user.role =='admin'">
                    <div class="col-12 col-md-4 col-sm-6 pr-1">
                        <button
                            v-if="appeal.status === 'Готово'"
                            class="btn p-1 mx-0 float-right mdi mdi-close"
                            style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                        ></button>
                        <button
                            v-else
                            class="btn p-1 mx-0 float-right mdi mdi-close"
                            style="height:36px; width: 36px; min-width: 36px; background: #dfe1ee; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                            disabled
                        ></button>
                        <div class="p-1 float-right" style="font-size: 18px; width: 36px">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                 y="0px" width="15" height="15"
                                 viewBox="0 0 423.936 423.936" style="enable-background:new 0 0 423.936 423.936;"
                                 xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#458e3c" d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                            c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                            c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                            C368.64,18.432,350.208,0,327.68,0z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <button
                            class="btn my-1 mr-1 py-1 border-copy-button float-right"
                        >
                            <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                Вернуть в работу
                            </span>
                        </button>
                    </div>
                </div>
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                     v-if="appeal.status === 'Скрыто'">
                    <div class="p-1 float-right" style="font-size: 18px; width: 36px">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" width="15" height="15"
                             viewBox="0 0 423.936 423.936" style="enable-background:new 0 0 423.936 423.936;"
                             xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#dfe1ee" d="M327.68,0H96.256c-22.528,0-40.96,18.432-40.96,40.96v357.376c0,9.728,5.632,18.944,14.336,23.04
                                            c9.216,4.096,19.456,3.072,27.136-3.072l0.512-0.512l114.688-96.768l114.688,96.768l0.512,0.512
                                            c4.608,3.584,10.24,5.632,15.872,5.632c3.584,0,7.68-1.024,11.264-3.072c8.704-4.096,14.336-13.312,14.336-23.04V40.96
                                            C368.64,18.432,350.208,0,327.68,0z"/>
                                    </g>
                                </g>
                        </svg>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div class="row m-auto w-100 sdm-primary-text">
                    <div class="col-3">
                        <div class="row w-100 m-auto">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Рубеж
                                </p>
                            </div>
                            <div class="col-12 p-0" v-if="boundary">
                                {{boundary.title||"Не выбрано"}}
                                <button
                                    class="btn p-0 mr-2"
                                    style="height:30px; width: 30px; min-width: 30px; background: transparent; color: #7224f2;"
                                    @click="toBoundaryPage"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612"
                                         style="enable-background:new 0 0 612 612; overflow:unset;"
                                         xml:space="preserve"
                                    >
                                        <g id="_x35__2_">
                                            <g>
                                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 p-0" v-else>
                                <p>Не выбрано</p>
                            </div>
                        </div>
                        <div class="row w-100 m-auto">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Устройство
                                </p>
                            </div>
                            <div class="col-12 p-0">
                                {{device.serial||"Не выбрано"}}
                                <button
                                    class="btn p-0 mr-2"
                                    style="height:30px; width: 30px; min-width: 30px; background: transparent; color: #7224f2;"
                                    @click="toDevicePage"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612"
                                         style="enable-background:new 0 0 612 612; overflow:unset;"
                                         xml:space="preserve">
                                        <g id="_x35__2_">
                                            <g>
                                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 m-auto">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Неисправность
                                </p>
                            </div>
                            <div class="col-12 p-0">
                                {{malfunction.title}}
                            </div>
                        </div>
                        <div class="row w-100 m-auto">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Ответственный
                                </p>
                            </div>
                            <div class="col-12 p-0">
                                {{responsible.name}}
                                <button
                                    class="btn p-0 mr-2"
                                    style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                    @click="toResponsibleUserPage"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612"
                                         style="enable-background:new 0 0 612 612; overflow:unset;"
                                         xml:space="preserve">
                                        <g id="_x35__2_">
                                            <g>
                                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row w-100 m-auto">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Дата и время создания обращения
                                </p>
                            </div>

                            <div class="col-12 p-0">
                                {{appeal.created_at | moment('DD MMMM YYYY')}} в {{appeal.created_at | moment('HH:mm')}}
                            </div>
                        </div>
                        <div class="row w-100 m-auto" v-if="appeal.executed_at != null">
                            <div class="col-12 p-0">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Дата окончания работ
                                </p>
                            </div>
                            <div class="col-12 p-0">
                                {{appeal.executed_at | moment('DD MMMM YYYY')}} в {{appeal.executed_at |
                                moment('HH:mm')}}
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="font-size: 12px; color: #959597; font-weight: 600"
                        >
                            Примечание
                        </p>
                        <div v-if="notes">
                            <div class="card"
                                 style="border-radius: 5px; border-bottom: 1px solid #959597; background: transparent !important;"
                                 v-for="note in notes"
                            >
                                <div class="card-body">
                                    <div class="row align-items-center justify-content-between m-auto">
                                        <h6 class="card-subtitle my-auto text-muted"
                                            style="font-size:12px; font-weight: 500;color:#7224f2 !important;">
                                            {{note.user.name}}
                                        </h6>
                                        <button class="btn btn-link" style="font-size:12px; color:red;"
                                                @click="removeNote(note.id)">Удалить
                                        </button>
                                        <button class="btn p-0"
                                                style="height:30px; width: 30px; min-width: 30px; background: transparent; color: #dfe1ee;"
                                                v-if="comment_edited_id!=note.id"
                                                @click="comment_edited_id=note.id"
                                        >
                                            <svg id="Capa_1" enable-background="new 0 0 488.471 488.471" height="15"
                                                 viewBox="0 0 488.471 488.471" width="15"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#dfe1ee" d="m166.093 240.214h88.205v194.288h-88.205z"
                                                      transform="matrix(.707 -.707 .707 .707 1.415 9.959)"/>
                                                <path fill="#dfe1ee"
                                                      d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="card-text" style="font-style: italic; font-size:12px;"
                                       v-if="comment_edited_id!=note.id">
                                        {{note.comment}}
                                    </p>
                                    <textarea class="form-control" v-model="note.comment"
                                              @keypress.enter="comment_edited_id=null" v-else></textarea>
                                    <p class="card-text text-muted"
                                       style="font-size: 9px; color: #959597; font-weight: 400"
                                    >
                                        {{note.created_at}}
                                    </p>
                                </div>
                            </div>
                            
                        </div>

                            <div v-if="appeal.note">
                                
                            <div class="card"
                                 style="border-radius: 5px; border-bottom: 1px solid #959597; background: transparent !important;"
                            >
                                <div class="card-body">
                                    <p class="card-text" style="font-style: italic; font-size:12px;">
                                        {{appeal.note}}
                                        <a :href="`/tasks/edit/${appeal.id}`">
                                <svg data-v-3219ce68="" data-v-e245f756="" version="1.1" id="Capa_1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     x="0px" y="0px" width="16px" height="15px" viewBox="0 0 612 612"
                                     xml:space="preserve" style="overflow: unset;"><g data-v-3219ce68="" data-v-e245f756="" id="_x35__2_"><g data-v-3219ce68="" data-v-e245f756=""><path data-v-3219ce68="" data-v-e245f756="" fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"></path></g></g></svg>
                            </a>
                                    </p>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div class="mt-1">
                            <textarea v-model="added_note_text" class="form-control"
                                      style="min-height:100px;max-height:200px;"></textarea>
                            <button class="btn w-100 my-1 btn-dark py-2"
                                    style="background: rgb(68, 141, 59);border: none;color: white;font-size: 11px;font-weight: 500;"
                                    @click="addNote"
                            >Добавить заметку
                            </button>
                        </div>

                    </div>
                    <div class="col-3">
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="font-size: 12px; color:#7224f2; font-weight: 600"
                        >
                            Отчет
                        </p>
                        <p v-if="appeal.report_id">
                            {{appeal.report.title}}
                            <a :href="`/reports/edit/${appeal.report.id}`" >

                                <svg version="1.1" id="Capa_1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                     y="0px" width="16px" height="15px" viewBox="0 0 612 612" xml:space="preserve"
                                     style="overflow: unset;"><g data-v-3219ce68="" data-v-e245f756="" id="_x35__2_"><g data-v-3219ce68="" data-v-e245f756=""><path data-v-3219ce68="" data-v-e245f756="" fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"></path></g></g></svg>
                            </a>
                        </p>


                        <p v-else>Отчет еще не добавлен к обращению</p>
                        <h6 class="mt-2" v-if="appeal.custom_reason">Название неисправности</h6>
                        <p v-if="appeal.custom_reason"><em>{{appeal.custom_reason}}</em>
                            <a :href="`/tasks/edit/${appeal.id}`">
                                <svg data-v-3219ce68="" data-v-e245f756="" version="1.1" id="Capa_1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     x="0px" y="0px" width="16px" height="15px" viewBox="0 0 612 612"
                                     xml:space="preserve" style="overflow: unset;"><g data-v-3219ce68="" data-v-e245f756="" id="_x35__2_"><g data-v-3219ce68="" data-v-e245f756=""><path data-v-3219ce68="" data-v-e245f756="" fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"></path></g></g></svg>
                            </a>
                        </p>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <appeals-show
                    :appeal="appeal">
                </appeals-show>
            </template>
        </layout>
    </div>
</template>

<script>
    import Layout from "../../components/Layout";
    import AppealsShow from "../../components/appeals/AppealsShow";
    import {v4 as uuidv4} from 'uuid';

    export default {
        name: "AppealsShowPage",
        props: ["user", "users", "responsible", "boundary", "devices", "malfunctions", "device", "malfunction", "appeal"],
        components: {
            Layout, AppealsShow
        },
        data: () => ({
            comment_edited_id: null,
            format_table: true,
            text_edited: false,
            appeal_text: '',
            note_text: '',
            note_edited: false,

            added_note_text: '',


            monthNames: [
                "Янв",
                "Февр",
                "Март",
                "Апр",
                "Май",
                "Июнь",
                "Июль",
                "Авг",
                "Сент",
                "Окт",
                "Нояб",
                "Дек"
            ],
            edited_appeal: {},
            notes: []
        }),
        mounted() {


            this.appeal_text = this.appeal.custom_reason

            console.log("note=>",this.appeal)
            if (this.appeal.notes!=null)
                this.notes = this.appeal.notes
        },
        methods: {
            goToReports() {

                if (this.boundary != null)
                    localStorage.setItem("report", JSON.stringify({
                        type: 3,
                        boundary: this.boundary,
                    }));
                else if (this.device != null)
                    localStorage.setItem("report", JSON.stringify({
                        type: 1,
                        device: this.device,
                        user: null
                    }));
                window.location.href = "/reports/add"

            },
            removeNote(noteId) {
                let tmp = this.notes.filter(item => item.id != noteId)
                this.notes = tmp;

                this.updateNote()
            },

            addNote() {
console.log("note=>",this.users)
                if  (this.added_note_text.trim().length===0)
                {
                    this.sendNotify("Ошибка добавления!","error")
                    return;
                }
                let date = new Date();


                this.notes.push({
                    id: uuidv4(),
                    user: this.user,
                    comment: this.added_note_text,
                    created_at: date.getDate() + " " + this.monthNames[date.getMonth()] + " " + date.getFullYear() + " в " + date.getHours() + ":" + date.getMinutes()
                })

                this.added_note_text = '';
                this.updateNote()

            },

            updateNote() {
                axios.post(`/task/update_notes/${this.appeal.id}`, {
                    notes: this.notes
                }).then(resp => {
                    this.sendNotify("Заметка успешно обновлена!", "success")
                })
            },
            editReport() {
                window.location.href = `/tasks/edit/${this.appeal.id}`
            },
            showCustomReasonEdit() {
                this.text_edited = true
            },
            opendNoteEdit() {
                this.note_text = this.appeal.note
                this.note_edited = true

            },
            changeStatus() {
                this.edited_appeal = this.appeal;
                this.appeal.status = this.appeal.status === "Актуальные" ? "Готово" : "Актуальные";
            },
            editAppeal() {
                this.text_edited = !this.text_edited
                this.edited_appeal = this.appeal;
                this.edited_appeal.custom_reason = this.appeal_text;
                this.update();

            },

            saveNote() {
                this.edited_appeal = this.appeal;
                this.edited_appeal.note = this.note_text;
                this.update();
                this.note_edited = false
            },
            update() {
                axios
                    .patch(`/task/${this.appeal.id}`, this.edited_appeal)
                    .then(() => {
                        this.sendNotify("Задача успешно отредактирована", "success")
                    })
                    .catch((error) => {
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');

                        this.loading = false


                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }

                    });
            },

            toBoundaryPage() {
                window.location.href = "/boundaries/edit/" + this.boundary.id;
            },
            toDevicePage() {
                window.location.href = "/devices/" + this.device.id;
            },
            toResponsibleUserPage() {
                window.location.href = "/users/" + this.responsible.id;
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Обращения',
                    text: notification,
                    type: type
                });
            }
        },
    };
</script>

<style scoped>
    .sdm-primary-text {
        font-family: Montserrat;
        font-size: 12px;
        font-weight: 500;
    }

    .sdm-secondary-text {
        font-family: Montserrat;
        font-size: 9px;
        color: #959597;
        font-weight: 400
    }

    #dropdownMenuButton::after {
        display: none;
    }

    .active-toggler {
        color: #6633ff;
    }

    .form-select {
        display: block;
        width: 100%;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        vertical-align: middle;
        background-color: transparent;
        background-image: url("/chevron-down.svg");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .checkbox-custom {
        opacity: 0;
        position: absolute;
    }

    .checkbox-custom,
    .checkbox-custom-label {
        display: inline-block;
        vertical-align: middle;
        margin: 5px;
        cursor: pointer;
        font-weight: 500;
        font-size: 10px;
    }

    .checkbox-custom-label {
        position: relative;
    }

    .checkbox-custom + .checkbox-custom-label:before {
        content: "";
        /*background: #fff;*/
        border: 1px solid #ddd;
        display: inline-block;
        vertical-align: middle;
        width: 17px;
        height: 17px;
        padding: 2px;
        margin-right: 10px;
        text-align: center;
        border-radius: 3px;
    }

    #checkbox-1 + .checkbox-custom-label:before {
        border: 1px solid #d62627;
    }

    #checkbox-2 + .checkbox-custom-label:before {
        border: 1px solid #6917f1;
    }

    #checkbox-3 + .checkbox-custom-label:before {
        border: 1px solid #458d3c;
    }

    #checkbox-1:checked + .checkbox-custom-label:before {
        background: #d62627;
        box-shadow: inset 0px 0px 0px 4px #fff;
    }

    #checkbox-2:checked + .checkbox-custom-label:before {
        background: #6917f1;
        box-shadow: inset 0px 0px 0px 4px #fff;
    }

    #checkbox-3:checked + .checkbox-custom-label:before {
        background: #458d3c;
        box-shadow: inset 0px 0px 0px 4px #fff;
    }

    .checkbox-custom:focus + .checkbox-custom-label {
        outline: none;
    }
</style>
