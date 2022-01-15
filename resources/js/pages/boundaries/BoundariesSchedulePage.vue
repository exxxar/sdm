<template>
    <layout title="Расписание рубежей" :info="false">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <div style="z-index: 9" class="col-12 col-md-6 col-lg-6">
                    <ol class="breadcrumb pl-0 m-0 align-items-center" style="background-color: transparent">
                        <li class="">
                            <a href="/home" style="color: #9d9ea5; text-decoration: none">
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
                                href="/boundaries"
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Рубежи
                            </a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal"
                                 style="color: rgb(157, 158, 165);font-size: 17px;">
                            </div>
                        </li>
                        <li class="" aria-current="page">
                            <a href="/boundaries/schedule"
                               style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                            >
                                Расписание рубежей
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-3">
                    <div id="top-slider" class="row w-100 mx-auto d-flex align-items-center justify-content-center">
                        <p class="switch-label">Все рубежи</p>
                        <label class="switch mr-2 ml-2">
                            <input type="checkbox"
                                   v-model="filter.groups"
                                   :disabled="filter.groups"
                                   v-on:change="toGroups($event.target.checked)"
                            >
                            <span class="slider round"></span>
                        </label>
                        <p style="color:#9d9ea5" v-bind:class="{ 'active-switch-mode': filter.groups }"
                           class="switch-label">
                            Группы рубежей</p>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <user-menu :user="user"></user-menu>
                </div>
                <div class="col-12" style="border-bottom: 1px solid #e3e3e5"></div>
            </div>
        </template>
        <template v-slot:header>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <button
                    v-on:click="addBoundary"
                    type="button"
                    class="btn btn-dark my-1 mr-1 py-2 px-3"
                    style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                >
                    Добавить рубеж
                </button>
            </div>
        </template>
        <template v-slot:main>
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li style="margin-left: 20px" class="nav-item">
                    <a
                        class="nav-link active"
                        id="moveable-tab"
                        data-toggle="tab"
                        href="#moveable"
                        role="tab"
                        aria-controls="moveable"
                        aria-selected="true"
                    >
                        Передвижные
                    </a>
                </li>
                <li style="margin-left: 20px" class="nav-item">
                    <a
                        class="nav-link"
                        id="static-tab"
                        data-toggle="tab"
                        href="#static"
                        role="tab"
                        aria-controls="static"
                        aria-selected="true"
                    >
                        Стационарные
                    </a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

                <div class="tab-pane fade show active"
                     id="moveable"
                     role="tabpanel"
                     aria-labelledby="moveable-tab"
                >
                    <div class="row w-100 m-auto align-items-center justify-content-center">
                        <div class="col-12 col-md-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Выберите устройства
                            </p>
                            <v-select placeholder="Все" v-model="filter.selected_device" :options="options"></v-select>

                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Группа усторойств
                            </p>

                            <v-select
                                style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                placeholder="Все"
                                :options="deviceGroupOptions"
                                v-model="filter.selected_device_group"
                                multiselect
                            >

                            </v-select>

                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Рубеж
                            </p>


                            <v-select
                                style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                placeholder="Все"
                                :options="boundariesMovableOptions"
                                v-model="filter.selected_boundary"
                            >

                            </v-select>
                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Период операций
                            </p>
                            <daterange-picker
                                ref="picker"
                                :opens="'right'"
                                :locale-data="local_data"
                                :timePicker="true"
                                :timePickerIncrement="1"
                                :timePicker24Hour="true"
                                :timePickerSeconds="false"
                                :showWeekNumbers="false"
                                :showDropdowns="true"
                                :ranges="false"
                                v-model="filter.dateRange"
                                :linkedCalendars="true"
                                class="w-100"
                            >
                                <div slot="header" slot-scope="header" class="slot">
                                    <div class="row w-100 m-auto">
                                        <div class="col-12">
                                            <div class="row m-auto w-100 justify-content-end">
                                                <button
                                                    @click="header.clickCancel"
                                                    class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                                >
                                                <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                                    Сбросить
                                                </span>
                                                </button>
                                                <button
                                                    @click="header.clickApply"
                                                    class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                                >
                                            <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                                Подтвердить
                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12" style="border-top: 1px solid #ced4da">
                                            <div class="sdm-primary-text py-3 px-2">
                                                Выбранный период:
                                                <span style="color:#7224f2">{{rangeText(header.rangeText)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <template v-slot:input="picker" style="min-width: 350px;">
                                    <div class="row w-100 h-100 m-auto align-items-center justify-content-center">
                                        <div class="col-10 p-0 text-truncate sdm-primary-text" style="font-size: 12px">
                                            <span
                                                style="color: #7224f2">{{picker.startDate | moment("DD.MM.YYYY")}}</span>
                                            {{picker.startDate | moment("HH:mm")}} -
                                            <span
                                                style="color: #7224f2">{{picker.endDate | moment("DD.MM.YYYY")}}</span>
                                            {{picker.endDate | moment("HH:mm")}}
                                        </div>
                                        <div class="col-2 pr-0">
                                            <svg
                                                class="float-right"
                                                height="15px"
                                                viewBox="0 0 512 512"
                                                width="15px"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill="#7224f2"
                                                    d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                                <div
                                    slot="footer"
                                    slot-scope="data"
                                    class="slot"
                                ></div>
                            </daterange-picker>
                        </div>
                        <div class="col-1 px-1 h-100">
                            <div class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end">
                                <button
                                    style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;"
                                    class="btn mb-0 mt-auto float-right"
                                    @click="applyMovableFilters"
                                >
                                    Применить
                                </button>
                            </div>
                        </div>

                        <div class="col-1 px-1 h-100">


                            <div class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end">
                                <button
                                    class="btn mb-0 mt-auto float-right"
                                    style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                                    @click="resetFilters"
                                >
                                    Сбросить
                                </button>
                            </div>


                        </div>
                        <div class="col-2 px-1">
                            <div class="row w-100 pb-1 mt-3 mx-auto align-items-end justify-content-end">
                                <button class="btn download-btn p-2 mx-1"
                                        style="display: flex; align-items: center; justify-content: center;"
                                        @click="downloadMovableReport"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         width="13" height="13" viewBox="0 0 480 480"
                                         style="enable-background:new 0 0 480 480;" xml:space="preserve">
                                    <path d="M378.528,214.688l-21.088-24c-5.824-6.624-15.904-7.264-22.56-1.472L272,244.32V16c0-8.832-7.168-16-16-16h-32
                                        c-8.832,0-16,7.168-16,16v228.32l-62.88-55.104c-6.624-5.792-16.704-5.152-22.56,1.472l-21.088,23.968
                                        c-5.856,6.656-5.184,16.8,1.472,22.624l126.528,110.752c6.048,5.28,15.04,5.28,21.088,0L377.056,237.28
                                        C383.712,231.456,384.384,221.312,378.528,214.688z"/>
                                        <path d="M416,416H64c-8.832,0-16,7.168-16,16v32c0,8.832,7.168,16,16,16h352c8.832,0,16-7.168,16-16v-32
                                            C432,423.168,424.832,416,416,416z"/>
                                </svg>
                                </button>
                                <button
                                    type="button"
                                    class="btn report-btn btn-dark ml-1 mr-2 px-3 py-2"
                                    @click="createMovableReport"
                                >
                                    Создать отчет
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100 mt-2 mx-auto align-items-center">
                        <div style="display: flex" class="mr-2 mb-1" :key="device.code"
                             v-for="device in filter.selected_devices">
                            <div class="mr-1">{{ device.label }}</div>
                            <div @click="removeDevice(device)"
                                 style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                                <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1"
                                     xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512.001 512.001"
                                     xml:space="preserve"
                                >
                                <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"/>
                            </svg>
                            </div>
                        </div>
                        <div
                            style="cursor: pointer; display: flex; border-radius: 20px; background: #7c34f2;color: white;"
                            class="mr-2 mb-1 px-2"
                            v-if="filter.selected_devices.length>5"
                            @click="removeAllDevices"
                        >
                            Удалить все
                        </div>
                    </div>

                    <boundaries-schedule-moveable/>
                </div>
                <div class="tab-pane show fade"
                     id="static"
                     role="tabpanel"
                     aria-labelledby="static-tab"
                >

                    <div class="row w-100 m-auto align-items-center justify-content-center">
                        <div class="col-12 col-md-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Выберите устройства
                            </p>
                            <v-select placeholder="Все" v-model="filter.selected_device" :options="options"></v-select>

                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Группа усторойств
                            </p>

                            <v-select
                                style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                placeholder="Все"
                                :options="deviceGroupOptions"
                                v-model="filter.selected_device_group"
                                multiselect
                            >

                            </v-select>

                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Рубеж
                            </p>


                            <v-select
                                style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                placeholder="Все"
                                :options="boundariesStaticOptions"
                                v-model="filter.selected_boundary"
                            >

                            </v-select>
                        </div>
                        <div class="col-2 px-1">
                            <p class="mb-1 d-flex sdm-secondary-text">
                                Период операций
                            </p>
                            <daterange-picker
                                ref="picker"
                                :opens="'right'"
                                :locale-data="local_data"
                                :timePicker="true"
                                :timePickerIncrement="1"
                                :timePicker24Hour="true"
                                :timePickerSeconds="false"
                                :showWeekNumbers="false"
                                :showDropdowns="true"
                                :ranges="false"
                                v-model="filter.dateRange"
                                :linkedCalendars="true"
                                class="w-100"
                            >
                                <div slot="header" slot-scope="header" class="slot">
                                    <div class="row w-100 m-auto">
                                        <div class="col-12">
                                            <div class="row m-auto w-100 justify-content-end">
                                                <button
                                                    @click="header.clickCancel"
                                                    class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                                >
                                                <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                                    Сбросить
                                                </span>
                                                </button>
                                                <button
                                                    @click="header.clickApply"
                                                    class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                                >
                                            <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                                Подтвердить
                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12" style="border-top: 1px solid #ced4da">
                                            <div class="sdm-primary-text py-3 px-2">
                                                Выбранный период:
                                                <span style="color:#7224f2">{{rangeText(header.rangeText)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <template v-slot:input="picker" style="min-width: 350px;">
                                    <div class="row w-100 h-100 m-auto align-items-center justify-content-center">
                                        <div class="col-10 p-0 text-truncate sdm-primary-text" style="font-size: 12px">
                                            <span
                                                style="color: #7224f2">{{picker.startDate | moment("DD.MM.YYYY")}}</span>
                                            {{picker.startDate | moment("HH:mm")}} -
                                            <span
                                                style="color: #7224f2">{{picker.endDate | moment("DD.MM.YYYY")}}</span>
                                            {{picker.endDate | moment("HH:mm")}}
                                        </div>
                                        <div class="col-2 pr-0">
                                            <svg
                                                class="float-right"
                                                height="15px"
                                                viewBox="0 0 512 512"
                                                width="15px"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill="#7224f2"
                                                    d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                                <div
                                    slot="footer"
                                    slot-scope="data"
                                    class="slot"
                                ></div>
                            </daterange-picker>
                        </div>
                        <div class="col-1 px-1 h-100">
                            <div class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end">
                                <button
                                    style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;"
                                    class="btn mb-0 mt-auto float-right"
                                    @click="applyStaticFilters"
                                >
                                    Применить
                                </button>
                            </div>
                        </div>

                        <div class="col-1 px-1 h-100">


                            <div class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end">
                                <button
                                    class="btn mb-0 mt-auto float-right"
                                    style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                                    @click="resetFilters"
                                >
                                    Сбросить
                                </button>
                            </div>


                        </div>
                        <div class="col-2 px-1">
                            <div class="row w-100 pb-1 mt-3 mx-auto align-items-end justify-content-end">
                                <button class="btn download-btn p-2 mx-1"
                                        style="display: flex; align-items: center; justify-content: center;"
                                        @click="downloadStaticReport"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         width="13" height="13" viewBox="0 0 480 480"
                                         style="enable-background:new 0 0 480 480;" xml:space="preserve">
                                    <path d="M378.528,214.688l-21.088-24c-5.824-6.624-15.904-7.264-22.56-1.472L272,244.32V16c0-8.832-7.168-16-16-16h-32
                                        c-8.832,0-16,7.168-16,16v228.32l-62.88-55.104c-6.624-5.792-16.704-5.152-22.56,1.472l-21.088,23.968
                                        c-5.856,6.656-5.184,16.8,1.472,22.624l126.528,110.752c6.048,5.28,15.04,5.28,21.088,0L377.056,237.28
                                        C383.712,231.456,384.384,221.312,378.528,214.688z"/>
                                        <path d="M416,416H64c-8.832,0-16,7.168-16,16v32c0,8.832,7.168,16,16,16h352c8.832,0,16-7.168,16-16v-32
                                            C432,423.168,424.832,416,416,416z"/>
                                </svg>
                                </button>
                                <button
                                    type="button"
                                    class="btn report-btn btn-dark ml-1 mr-2 px-3 py-2"
                                    @click="createStaticReport"
                                >
                                    Создать отчет
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100 mt-2 mx-auto align-items-center">
                        <div style="display: flex" class="mr-2 mb-1" :key="device.code"
                             v-for="device in filter.selected_devices">
                            <div class="mr-1">{{ device.label }}</div>
                            <div @click="removeDevice(device)"
                                 style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                                <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1"
                                     xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512.001 512.001"
                                     xml:space="preserve"
                                >
                                <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"/>
                            </svg>
                            </div>
                        </div>
                        <div
                            style="cursor: pointer; display: flex; border-radius: 20px; background: #7c34f2;color: white;"
                            class="mr-2 mb-1 px-2"
                            v-if="filter.selected_devices.length>5"
                            @click="removeAllDevices"
                        >
                            Удалить все
                        </div>
                    </div>

                    <boundaries-schedule-static/>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import BoundariesScheduleMoveable from "../../components/boundaries/BoundariesScheduleMoveable";
    import BoundariesScheduleStatic from "../../components/boundaries/BoundariesScheduleStatic";
    import moment from 'moment';

    export default {
        name: "BoundariesSchedulePage",
        props: ['user', 'boundary_groups', 'boundaries', 'devices'
            // 'boundary_schedule'
        ],
        components: {Layout, BoundariesScheduleMoveable, BoundariesScheduleStatic},
        data() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(startDate.getDate() - 6);
            endDate.setDate(endDate.getDate() + 6);
            return {
                local_data: {
                    format: 'mm/dd/yyyy HH:MM',
                    separator: " - ",
                    applyLabel: "Подтвердить",
                    cancelLabel: "Сбросить",
                    daysOfWeek: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
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
                    firstDay: 1
                },
                boundariesMovableOptions: [],
                boundariesStaticOptions: [],
                deviceGroupOptions: [],
                boundary_group: '',
                filter: {
                    groups: false,
                    boundary_group: '',
                    selected_boundary: null,
                    selected_device: null,
                    selected_device_group: null,
                    selected_devices: [],
                    dateRange: {startDate, endDate},
                },
                options: []
            }
        },
        created() {

            this.preparedBoundaries();

            this.devices.forEach((device) => {
                this.options.push({label: device.serial, code: device.id})
            });
        },
        computed: {
            current_device: {
                get: function () {
                    return null
                },
                set: function (newValue) {
                    let removeIndex = this.options.map(item => item.code).indexOf(newValue.code);
                    this.options.splice(removeIndex, 1);
                    this.filter.selected_devices.push(newValue);
                }
            },
        },

        methods: {

            preparedBoundaries() {
                axios.get('/boundary').then(resp => {
                    let tmp = resp.data.data

                    //this.boundaries =  tmp


                    let tmp_boundaries_movable = tmp.filter(item => item.movable);
                    let tmp_boundaries_static = tmp.filter(item => !item.movable);

                    let array_movable = [{label: 'Выберите рубеж', code: ''}]
                    let array_static = [{label: 'Выберите рубеж', code: ''}]

                    tmp_boundaries_movable.forEach(item => {
                        array_movable.push({label: item.title, code: item.id})
                    });

                    tmp_boundaries_static.forEach(item => {
                        array_static.push({label: item.title, code: item.id})
                    });

                    this.boundariesMovableOptions = array_movable;
                    this.boundariesStaticOptions = array_static;

                })

                axios.get('/device-group').then(resp => {
                    let tmp = resp.data.data

                    let array = [{label: 'Выберите группу устройств', code: ''}]

                    tmp.forEach(item => {
                        array.push({label: item.title, code: item.id})
                    });

                    this.deviceGroupOptions = array;

                })


            },
            toGroups: function (event) {
                window.location.href = `/boundary-groups`;
            },
            addBoundary: function () {
                window.location.href = "/boundaries/add";
            },
            removeDevice(device) {
                let removeIndex = this.filter.selected_devices.map(item => item.code).indexOf(device.code);
                this.filter.selected_devices.splice(removeIndex, 1);
                this.options.push(device);
            },
            removeAllDevices() {
                this.filter.selected_devices.forEach(item => {
                    this.options.push(item);
                });
                this.filter.selected_devices = [];
            },
            downloadMovableReport() {
                this.sendNotify("Загружаем файл расписания передвежных рубежей")

                const FileDownload = require('js-file-download');

                let device = this.filter.selected_device ? this.filter.selected_device.code : null
                let device_group = this.filter.selected_device_group ? this.filter.selected_device_group.code : null
                let boundary = this.filter.selected_boundary ? this.filter.selected_boundary.code : null

                axios.post("/download-boundary-schedule-movable",
                    {
                        "start_date": this.filter.dateRange.startDate,
                        "end_date": this.filter.dateRange.endDate,
                        "devices": device == null ? [] : [device],
                        "device_groups": device_group == null ? [] : [device_group],
                        "boundaries": boundary == null ? [] : [boundary]
                    },
                    {responseType: 'blob'}
                ).then((response) => {
                    FileDownload(response.data, 'report-movable.xlsx');
                });

            },

            downloadStaticReport() {
                this.sendNotify("Загружаем файл расписания стационарных рубежей")

                const FileDownload = require('js-file-download');

                let device = this.filter.selected_device ? this.filter.selected_device.code : null
                let device_group = this.filter.selected_device_group ? this.filter.selected_device_group.code : null
                let boundary = this.filter.selected_boundary ? this.filter.selected_boundary.code : null

                axios.post("/download-boundary-schedule-static",
                    {
                        "start_date": this.filter.dateRange.startDate,
                        "end_date": this.filter.dateRange.endDate,
                        "devices": device == null ? [] : [device],
                        "device_groups": device_group == null ? [] : [device_group],
                        "boundaries": boundary == null ? [] : [boundary]
                    },
                    {responseType: 'blob'}
                ).then((response) => {
                    FileDownload(response.data, 'report-static.xlsx');
                });

            },

            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Справочники',
                    text: notification,
                    type: type
                });
            },
            createMovableReport() {
                window.location.href = "/reports/add";
            },
            createStaticReport() {
                window.location.href = "/reports/add";
            },
            applyMovableFilters() {
                this.filter.start_date = moment(this.filter.dateRange.startDate).format("DD-MM-YYYY HH:mm");
                this.filter.end_date = moment(this.filter.dateRange.endDate).format("DD-MM-YYYY HH:mm");
                window.eventBus.$emit("scheduleMovableFilterEvent", this.filter);
            },

            applyStaticFilters() {
                this.filter.start_date = moment(this.filter.dateRange.startDate).format("DD-MM-YYYY HH:mm");
                this.filter.end_date = moment(this.filter.dateRange.endDate).format("DD-MM-YYYY HH:mm");
                window.eventBus.$emit("scheduleStaticFilterEvent", this.filter);
            },

            resetFilters() {
                this.filter.current_device = [];
                this.filter.boundary_group = [];
                this.filter.selected_boundary = [];
                let startDate = new Date();
                let endDate = new Date();
                startDate.setDate(startDate.getDate() - 6);
                endDate.setDate(endDate.getDate() + 6);
                this.filter.dateRange = {startDate, endDate};
                this.filter.start_date = moment(startDate).format("DD-MM-YYYY HH:mm");
                this.filter.end_date = moment(endDate).format("DD-MM-YYYY HH:mm");

                this.filter.selected_boundary = null
                this.filter.selected_device = null
                this.filter.selected_device_group = null

                window.eventBus.$emit("scheduleStaticFilterEvent", null);
                window.eventBus.$emit("scheduleMovableFilterEvent", null);
            },
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
                return text;
            },
        }
    }
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
        font-weight: 400;
    }

    .form-select {
        display: block;
        width: 100%;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 12px;
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

    .custom-select {
        color: black;
        font-weight: 500;
        font-size: 12px;
        border-color: #dfe1ee;
    }

    .active-toggler {
        color: #7c34f2;
    }

    .download-btn {
        height: 35px;
        border: 1px solid #7224f2;
        font-size: 15px;
        width: 35px;
        min-width: 35px;
        background: transparent;
        color: black
    }

    .report-btn {
        height: 36px;
        background: #448d3b;
        border: none;
        color: white;
        font-size: 11px;
        font-weight: 500;
    }
</style>
