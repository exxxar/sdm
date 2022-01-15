<template>
    <div>
        <layout :title="'История обращений'" :info="false">
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
                                    История обращений
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
            <template v-slot:filters>
                <div class="row w-100 m-auto align-items-center justify-content-center">
                    <div class="col-2 pr-1 pl-0">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Номер обращения
                        </p>
                        <input placeholder="Все" v-model="appeal_number" class="form-control custom-input"/>
                    </div>
                    <div class="col-3 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                           Рубеж
                        </p>
                        <select class="sdm-select" v-model="boundary">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="bound.id" :value="bound.id" v-for="bound in boundaries">
                                {{ bound.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Устройство
                        </p>
                        <select
                            class="sdm-select"
                            v-model="device"
                        >
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="dev.id" :value="dev.id" v-for="dev in devices">
                                {{ dev.serial }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Неисправность
                        </p>
                        <select class="sdm-select" v-model="malfunction">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="malf.id" :value="malf.id" v-for="malf in malfunctions">
                                {{ malf.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-3 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Период операций
                        </p>
                        <daterange-picker
                            ref="picker"
                            :opens="'left'"
                            :locale-data="local_data"
                            :timePicker="true"
                            :timePickerIncrement="1"
                            :timePicker24Hour="true"
                            :timePickerSeconds="true"
                            :showWeekNumbers="false"
                            :showDropdowns="true"
                            :ranges="false"
                            v-model="dateRange"
                            :linkedCalendars="true"
                            class="w-100"
                        >
                            <div slot="header" slot-scope="header" class="slot">
                                <div class="row w-100 m-auto">
                                    <div class="col-12">
                                      <div class="row m-auto w-100 justify-content-end">
                                          <button @click="header.clickCancel" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                            <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                                Сбросить
                                            </span>
                                          </button>
                                          <button @click="header.clickApply" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                            <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                                Подтвердить
                                            </span>
                                          </button>
                                      </div>
                                    </div>
                                    <div class="col-12" style="border-top: 1px solid #ced4da">
                                        <div class="sdm-primary-text py-3 px-2">Выбранный период: <span style="color:#7224f2">{{rangeText(header.rangeText)}}</span></div>
                                    </div>
                                </div>
                            </div>
                            <template v-slot:input="picker" style="min-width: 350px;">
                                <div class="row w-100 h-100 m-auto align-items-center justify-content-center">
                                    <div class="col-11 p-0 text-truncate" style="font-size: 11px">
                                        <span style="color: #7224f2">{{ picker.startDate | moment('DD.MM.YYYY')}}</span>
                                        {{ picker.startDate | moment('HH:mm:ss')}}  -
                                        <span style="color: #7224f2">{{ picker.endDate | moment('DD.MM.YYYY')}}</span>  {{ picker.endDate | moment('HH:mm:ss')}}
                                    </div>
                                    <div class="col-1 pr-0">
                                        <svg class="float-right" height="15px" viewBox="0 0 512 512" width="15px" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#7224f2" d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"/>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                            <div slot="footer" slot-scope="data" class="slot">
                            </div>
                        </daterange-picker>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <appeals-history
                    :boundary="boundary"
                    :device="device"
                    :malfunction="malfunction"
                    :appeal_number="appeal_number"
                    :dateRange="dateRange"
                >
                </appeals-history>
            </template>
        </layout>
    </div>
</template>

<script>
    import Layout from "../../components/Layout";
    import AppealsHistory from "../../components/appeals/AppealsHistory";
    import moment from 'moment'
    export default {
        name: "AppealsHistoryPage",
        props: ['user', 'users', 'boundaries', 'devices', 'malfunctions'],
        components: {
            Layout, AppealsHistory
        },
        data() {
            let startDate = new Date();
            startDate.setDate(startDate.getDate() - 6);
            startDate.setHours(0,0,0,0);
            let endDate = new Date();
            endDate.setDate(endDate.getDate());
            //endDate.setHours(23,59,59,999);
            return {
                dateRange: {startDate, endDate},
                local_data: {
                    format:'mm/dd/yyyy HH:MM',
                    separator: ' - ',
                    applyLabel: 'Подтвердить',
                    cancelLabel: 'Сбросить',
                    // weekLabel: 'Н',
                    // customRangeLabel: 'Custom Range',
                    daysOfWeek: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
                    monthNames: ['Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
                    firstDay: 1
                },
                boundary: '',
                malfunction: '',
                device:'',
                appeal_number:''
            }
        },
        methods:{
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
                return text;
            }
        }
    }
</script>
<style>
    .reportrange-text{
        background: transparent !important;
        border: 1px solid #dfe1ee !important;
        width: 100% !important;
        line-height: 1.5 !important;
        height: calc(1.6em + 0.75rem + 2px) !important;
        font-size: 12px !important;
    }
    .daterangepicker td.in-range {
        background-color: #dfe0f0;
        border-color: transparent;
        color: #000;
        border-radius: 0;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover {
        background-color: #7224f2 !important;
        border-color: transparent;
        color: #fff;
    }
    .daterangepicker .calendar-time .form-control, .daterangepicker select.monthselect {
        margin-right: 2%;
        width: 56%;
        display: block;
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

    /*.daterangepicker td.today {*/
    /*    background-color: #fff !important;*/
    /*    color: #000 !important;*/
    /*}*/
</style>
<style scoped>
    .sdm-primary-text{
        font-family: Montserrat;
        font-size:12px;
        font-weight:500;
    }
    .sdm-secondary-text{
        font-family: Montserrat;
        font-size: 9px;
        color: #959597;
        font-weight: 400
    }
    .custom-input {
        background: transparent;
        color: black;
        font-weight: 500;
        font-size: 12px;
        border-color: #dfe1ee
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
</style>
