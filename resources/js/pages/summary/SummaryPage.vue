<template>
    <div>
        <layout title="Сводка" :info="true" :info_text="'Это сводка.'">
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
                                <div class="mx-3 mdi mdi-dots-horizontal" style="color: rgb(157, 158, 165);font-size: 17px;">
                                </div>
                            </li>
                            <li class="" aria-current="page">
                                <a href="/summary"
                                   style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Сводка
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div id="top-slider" class="row w-100 mx-auto d-flex align-items-center justify-content-center">
                            <p class="switch-label" style="color: #9d9ea5" v-bind:class="{ 'active-switch-mode': !not_efficiency_mode }">Работоспособность</p>
                            <label class="switch mr-2 ml-2">
                                <input type="checkbox" v-model="not_efficiency_mode" @change="updateCharts()">
                                <span class="slider round"></span>
                            </label>
                            <p style="color: #9d9ea5" v-bind:class="{ 'active-switch-mode': not_efficiency_mode }" class="switch-label">Проезды/нарушения</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <user-menu :user="user"></user-menu>
                    </div>
                    <div
                        class="col-12"
                        style="border-bottom: 1px solid #e3e3e5"
                    ></div>
                </div>
            </template>
            <template v-slot:header>
                <div v-if="not_efficiency_mode" class="row w-100 m-auto justify-content-end align-items-center">
                    <div class="form-check form-check-inline float-right mt-3 mr-2">
                        <input
                            id="checkbox-2"
                            class="checkbox-custom"
                            name="checkbox-2"
                            type="checkbox"
                            v-model="has_passages"
                            @change="updateCharts()"
                        />
                        <label
                            for="checkbox-2"
                            class="checkbox-custom-label sdm-primary-text mx-0 text-truncate"
                        >
                            Проезды
                        </label>
                    </div>
                    <div class="form-check form-check-inline float-right mt-3 mr-0">
                        <input
                            class="checkbox-2 checkbox-custom"
                            id="checkbox-1"
                            name="checkbox-1"
                            type="checkbox"
                            v-model="has_violations"
                            @change="updateCharts()"
                        />
                        <label
                            for="checkbox-1"
                            class="checkbox-custom-label sdm-primary-text mx-0 text-truncate"
                        >
                            Нарушения
                        </label>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div class="row w-100 m-auto align-items-center">
                    <div class="col pl-0 pr-1" style="width:100px">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип
                        </p>
                        <select class="sdm-select" v-model="device_type" @change="selectDeviceType">
                            <option value="" selected>
                                Устройства
                            </option>
                            <option :key="device_type.id" :value="device_type.id" v-for="device_type in device_types">
                                {{ device_type.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Выберите устройства
                        </p>
                        <v-select placeholder="Все" v-model="current_device" :options="options"></v-select>
                    </div>
                    <div class="col-12 col-md-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Период
                        </p>
                        <select class="sdm-select" v-model="period">
                            <option value="date-range" selected>
                                Заданный период
                            </option>
                            <option value="day">
                                За день
                            </option>
                            <option value="week">
                                За неделю
                            </option>
                            <option value="month">
                                За месяц
                            </option>
                            <option value="year">
                                За год
                            </option>
                        </select>
                    </div>
                    <div class="col-3 px-1" style="max-width: 259px;">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Период создания отчета
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
                            v-model="dateRange"
                            :linkedCalendars="true"
                            class="w-100"
                            :readonly="period !== 'date-range'"
                        >
                            <div slot="header" slot-scope="header" class="slot">
                                <div class="row w-100 m-auto">
                                    <div class="col-12">
                                        <div class="row m-auto w-100 justify-content-end sdm-primary-text">
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
                                    <div class="col-11 p-0 text-truncate" style="font-size: 12px">
                                        <span style="color: #7224f2">{{ picker.startDate | moment('DD.MM.YYYY')}}</span>
                                        {{ picker.startDate | moment('HH:mm')}}  -
                                        <span style="color: #7224f2">{{ picker.endDate | moment('DD.MM.YYYY')}}</span>  {{ picker.endDate | moment('HH:mm')}}
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
                    <div class="col-1 h-100 px-1">
                        <button
                            class="btn mb-0 mt-3"
                            style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                            @click="getSummary"
                        >
                            Применить
                        </button>
                    </div>
                    <div class="col-3 p-0">
                        <div class="row w-100 pb-1 mx-auto align-items-end justify-content-end">
                            <button class="btn download-btn p-2 mx-1"
                                    style="display: flex; align-items: center; justify-content: center;"
                                    @click="downloadReport"
                                    :disabled="records.length==0"
                            >
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     width="13" height="13" viewBox="0 0 480 480" style="enable-background:new 0 0 480 480;" xml:space="preserve">
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
                                @click="createReport"
                            >
                                Создать отчет
                            </button>
                            <div>
                                <p class="ml-2 mb-1 d-flex" style="font-size: 9px; color: #959597; font-weight: 400">
                                    вид
                                </p>
                                <button
                                    class="btn p-1 mx-2 mdi mdi-view-sequential"
                                    :class="{ 'active-toggler' : summary_table }"
                                    style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                                    v-on:click="summary_table = true"
                                ></button>
                            </div>

                            <button
                                class="btn p-1 mdi mdi-poll"
                                :class="{ 'active-toggler' : !summary_table }"
                                style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                                v-on:click="summary_table = false"
                            >
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mt-2 mx-auto align-items-center">
                    <div style="display: flex" class="mr-2 mb-1" :key="device.code" v-for="device in selected_devices">
                        <div class="mr-1">{{ device.label }}</div>
                        <div @click="removeDevice(device)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
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
                        v-if="selected_devices.length>5"
                        @click="removeAllDevices"
                    >
                        Удалить все
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <summary-table
                    v-if="summary_table&&!loading"
                    :records="records"
                    :not_efficiency_mode="not_efficiency_mode"
                    :has_violations="has_violations"
                    :has_passages="has_passages"
                ></summary-table>
                <summary-chart
                    v-show="!summary_table&&!loading"
                    :charts="charts"
                    :not_efficiency_mode="not_efficiency_mode"
                    :has_violations="has_violations"
                    :has_passages="has_passages"
                    ref="summary_chart"
                ></summary-chart>
                <div class="row w-100 mx-auto my-3 align-items-center justify-content-center" v-if="loading">
                    <div class="col-12">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border" style="color: #7c34f2;" role="status">
                            </div>
                            <span class="ml-2" style="color: #7c34f2">Загрузка...</span>
                        </div>
                    </div>
                </div>
            </template>
        </layout>
    </div>
</template>

<script>
    import Layout from "../../components/Layout";
    import SummaryTable from "../../components/summary/SummaryTable";
    import moment from 'moment';
    import SummaryChart from "../../components/summary/SummaryChart";

    export default {
        name: "SummaryPage",
        components: {
            SummaryChart,
            SummaryTable,
            Layout
        },
        props:['user','devices', 'device_types'],
        data() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(endDate.getDate() - 6);
            return {
                dateRange: { startDate, endDate },
                local_data: {
                    format:'mm/dd/yyyy HH:MM',
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
                period:'date-range',
                device_type:'',
                selected_devices:[],
                options:[],
                summary_table: true,
                has_violations: true,
                has_passages: true,
                not_efficiency_mode: false,
                charts:[],
                records:[],
                loading:false,

            };
        },
        created() {
            this.devices.forEach((device) => {
                this.options.push({label: device.serial, code: device.id})
            });

        },
        mounted() {

            if (localStorage.getItem("summary")) {

                let summary = JSON.parse(localStorage.getItem("summary"));
                /* type: 'device',
                     user: this.user,
                     device: this.device,*/


                if (summary.type === 1) {
                    this.selected_devices.push({code:summary.device.id,label:summary.device.serial})

                    //this.new_report.object = report.device.id

                }


            }

            this.getSummary();


        },
        computed: {
            current_device: {
                get: function () {
                    return null
                },
                set: function (newValue) {
                    let removeIndex = this.options.map(item => item.code).indexOf(newValue.code);
                    this.options.splice(removeIndex, 1);
                    this.selected_devices.push(newValue);
                    //this.getSummary();
                    //todo: CANCEL    uncomment and briefly change when get real data
                    // if (this.$refs.summary_chart != null || this.$refs.summary_chart != undefined) {
                    //     this.$refs.summary_chart.addChart(device.label);
                    // }
                }
            },
            filteredDevices() {
                if (this.device_type !== ''){
                    return this.devices.filter(device => device.device_type_id === this.device_type);
                }
                return this.devices;
            }
            //CANCELED
            /*filteredList() {
                return this.devices.filter(item => {
                    if (this.selected_devices.findIndex(elem => elem.code === item.id) > -1) {
                        //todo: CANCEL   add period comparison
                        let period = true,
                            serial_number = true,
                            device_type = true,
                            date = false;

                        //todo: CANCEL    change action to sort by groups: "devices", "boundaries", "device_groups"
                        if (this.device_type !== "") {
                            device_type = item.device_type_id === this.device_type;
                        }

                        if (this.serial_number !== "") {
                            serial_number = item.id === this.serial_number;
                        }

                        if (
                            //todo: CANCEL    change to date that needed for comparison
                            moment(item.created_at).isBetween(
                                this.dateRange.startDate,
                                this.dateRange.endDate
                            )
                        ) {
                            date = true;
                        }

                        return device_type && serial_number && date;
                    }
                    return false;
                });
            },*/
        },
        watch: {
            selected_devices: {
                handler: function () {

                },
                deep: true
            },

            options: {
                handler: function () {
                },
                deep: true
            },
        },
        methods: {
            resetFilters() {
                this.period='';
                this.selected_devices=[];
                this.device_type='';
                let startDate = new Date();
                let endDate = new Date();
                endDate.setDate(endDate.getDate() + 6);
                this.dateRange = { startDate, endDate };
                localStorage.setItem("summary",null)
            },
            showItem(id) {
                window.location.href = "/devices/" + id;
            },
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
                return text;
            },
            removeDevice(device) {
                let removeIndex = this.selected_devices.map(item => item.code).indexOf(device.code);
                this.selected_devices.splice(removeIndex, 1);
                this.options.push(device);
                // this.getSummary();
                //todo: CANCEL    uncomment and briefly change when get real data
                // if (this.$refs.summary_chart != null || this.$refs.summary_chart != undefined) {
                //     this.$refs.summary_chart.removeChart(device.label);
                // }
            },
            removeAllDevices() {
                this.selected_devices.forEach(item => {
                    this.options.push(item);
                });
                this.selected_devices = [];
                // this.updateCharts();
            },
            async getSummary() {
                //todo: DONE     get new summary data
                this.loading = true;
                let ids = [];
                if (this.selected_devices.length > 0 )
                {
                    ids = this.selected_devices.map(item => item.code);
                }
                else {
                    ids = this.devices.map(item => item.id);
                }
                let period_object ={
                    period: this.period,
                    startDate: this.dateRange.startDate,
                    endDate: this.dateRange.endDate,
                };
                await axios
                    .post('/summary/getDateRangeForSummaryByPeriod', period_object)
                    .then( (response) => {
                        let data = {
                            startDate: response.data.date_range.startDate,
                            endDate: response.data.date_range.endDate,
                            ids:ids
                        };
                        axios
                            .post('/summary/getSummary', data)
                            .then( (resp) => {
                                console.log(resp)
                                this.charts = resp.data.charts;
                                this.records = resp.data.records;
                                this.updateCharts();
                                this.loading = false;
                            })
                    });

            },
            downloadReport() {
                //todo: get summary data like document for selected period
                this.sendNotify('Подготавливаем данные для скачивания. Ожидайте.');
                let ids = [];
                if (this.selected_devices.length > 0 )
                {
                    ids = this.selected_devices.map(item => item.id);
                }
                else {
                    ids = this.devices.map(item => item.id);
                }
                let data = {
                    period: this.period,
                    startDate: this.dateRange.startDate,
                    endDate: this.dateRange.endDate,
                    ids:ids
                };
                axios({
                    method: 'post',
                    url:'/summary/downloadSummary',
                    data: data,
                    responseType: 'arraybuffer',
                })
                    .then((resp) => {
                        var fileURL = window.URL.createObjectURL(new Blob([resp.data]));
                        var fileLink = document.createElement('a');

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', 'summary.xlsx');
                        document.body.appendChild(fileLink);

                        fileLink.click();

                        localStorage.setItem("summary",null)
                        // this.sendNotify('Вы успешно скачали сводку по заданным параметрам', 'success');
                });
            },
            createReport() {
                console.log(this.selected_devices)
                localStorage.setItem("report", JSON.stringify({
                    type: 1,
                    user: this.user,
                    period: this.period,
                    device: this.selected_devices,
                    not_efficiency_mode: this.not_efficiency_mode,
                    has_violations: this.has_violations,
                    has_passages: this.has_passages
                }));


                window.location.href = "/reports/add"
            },
            updateCharts() {
                console.log(this.has_passages, this.has_violations, this.not_efficiency_mode)
                //todo: DONE    uncomment when get real data
                this.$nextTick(function () {
                    if (this.$refs.summary_chart != null || this.$refs.summary_chart) {
                        this.$refs.summary_chart.updateCharts();
                    }
                })
            },
            selectDeviceType() {
                this.options = [];
                this.filteredDevices.forEach((device) => {
                    this.options.push({label: device.serial, code: device.id})
                });
                let temp = this.selected_devices;
                this.selected_devices = [];

                temp.forEach((device) => {
                    let removeIndex = this.options.map(item => item.code).indexOf(device.code);
                    if(removeIndex>-1)
                    {
                        this.selected_devices.push(this.options[removeIndex]);
                        this.options.splice(removeIndex, 1);
                    }
                })

            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Сводка',
                    text: notification,
                    type:type
                });
            }
        }
    }
</script>

<style scoped>
    .active-switch-mode {
        color: black !important;
    }
    .checkbox-custom + .checkbox-custom-label::before{
        margin-right: 0px;
    }
    .checkbox-2:checked + .checkbox-custom-label::before {
        background: #6917f1 !important;
        box-shadow: inset 0px 0px 0px 4px #fff !important;
    }
    .checkbox-2 + .checkbox-custom-label::before {
        border: 1px solid #6917f1 !important;
    }
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
        height:35px;
        border: 1px solid #7224f2;
        font-size: 15px;
        width: 35px;
        min-width: 35px;
        background: transparent;
        color: black
    }
    .report-btn {
        height:36px;
        background: #448d3b;
        border: none;
        color: white;
        font-size: 11px;
        font-weight: 500;
    }
</style>
