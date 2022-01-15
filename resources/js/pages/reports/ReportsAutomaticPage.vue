<template>
    <layout title="Автоматические отчеты" :info="false">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <div style="z-index: 9" class="col-12 col-md-9">
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
                        <li class="" aria-current="page">
                            <a
                                href="/reports"
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Отчеты
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
                                href="/reports/show/automatic"
                                style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                            >
                                Автоматические отчеты
                            </a>
                        </li>
                    </ol>
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
            <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                <div class="col-12 col-md-2 col-sm-6 pr-0 pl-0">
                    <button
                        @click="turnOffAll"
                        class="btn w-100 my-1 mr-1 py-1 sdm-red-underline-button pr-0 mr-0"
                    >
                        <span>Выключить все</span>
                    </button>
                </div>
                <div class="col-12 col-md-2 col-sm-6 pr-0 pl-0">
                    <button
                        @click="turnOnAll"
                        class="btn w-100 my-1 mr-1 py-1 sdm-green-underline-button pl-0 ml-0"
                    >
                        <span>Включить все</span>
                    </button>
                </div>
            </div>
        </template>
        <template v-slot:filters>
            <div class="row w-100 m-auto justify-content-center align-items-center">
                <div class="col-12 col-md-4 px-1">
                    <p class="mb-1 d-flex" style="font-size: 9px; color: #959597; font-weight: 400">
                        Название отчета
                    </p>
                    <input
                        v-model="report_title"
                        class="form-control"
                        placeholder="Все"
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
                </div>
                <div class="col-12 col-md-1 px-1">
                    <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                        <div class="col-6 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text"
                               style="visibility: hidden">
                                Важн
                            </p>
                            <button
                                @click="important = !important"
                                class="btn mr-2 d-flex align-items-center justify-content-center sdm-icon-button"
                                v-bind:class="{'active': important,'nonactive': !important}"
                            >
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512.002 512.002;" xml:space="preserve">
                                    <path d="M511.267,197.258c-1.764-5.431-6.457-9.389-12.107-10.209l-158.723-23.065L269.452,20.157
                                        c-2.526-5.12-7.741-8.361-13.45-8.361c-5.71,0-10.924,3.241-13.451,8.361l-70.988,143.827l-158.72,23.065
                                        c-5.649,0.82-10.344,4.778-12.108,10.208c-1.765,5.431-0.293,11.392,3.796,15.377l114.848,111.954L92.271,482.671
                                        c-0.966,5.628,1.348,11.314,5.967,14.671c2.613,1.898,5.708,2.864,8.818,2.864c2.388,0,4.784-0.569,6.978-1.723l141.967-74.638
                                        l141.961,74.637c5.055,2.657,11.178,2.215,15.797-1.141c4.619-3.356,6.934-9.044,5.969-14.672l-27.117-158.081l114.861-111.955
                                        C511.56,208.649,513.033,202.688,511.267,197.258z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-6 pl-1 pr-0">
                            <p class="mb-1 d-flex sdm-secondary-text"
                               style="visibility: hidden"
                            >
                                Авто
                            </p>
                            <button
                                class="btn mr-2 d-flex align-items-center justify-content-center sdm-icon-button active"
                                disabled
                                title="Автоматичесткий отчет"
                            >
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <path d="M496.659,312.107l-47.061-36.8c0.597-5.675,1.109-12.309,1.109-19.328c0-7.019-0.491-13.653-1.109-19.328l47.104-36.821
                                        c8.747-6.912,11.136-19.179,5.568-29.397L453.331,85.76c-5.227-9.557-16.683-14.464-28.309-10.176l-55.531,22.293
                                        c-10.645-7.68-21.803-14.165-33.344-19.349l-8.448-58.901C326.312,8.448,316.584,0,305.086,0h-98.133
                                        c-11.499,0-21.205,8.448-22.571,19.456l-8.469,59.115c-11.179,5.035-22.165,11.435-33.28,19.349l-55.68-22.357
                                        C76.52,71.531,64.04,76.053,58.856,85.568L9.854,170.347c-5.781,9.771-3.392,22.464,5.547,29.547l47.061,36.8
                                        c-0.747,7.189-1.109,13.44-1.109,19.307s0.363,12.117,1.109,19.328l-47.104,36.821c-8.747,6.933-11.115,19.2-5.547,29.397
                                        l48.939,84.672c5.227,9.536,16.576,14.485,28.309,10.176l55.531-22.293c10.624,7.659,21.781,14.144,33.323,19.349l8.448,58.88
                                        C185.747,503.552,195.454,512,206.974,512h98.133c11.499,0,21.227-8.448,22.592-19.456l8.469-59.093
                                        c11.179-5.056,22.144-11.435,33.28-19.371l55.68,22.357c2.688,1.045,5.483,1.579,8.363,1.579c8.277,0,15.893-4.523,19.733-11.563
                                        l49.152-85.12C507.838,331.349,505.448,319.083,496.659,312.107z M256.019,341.333c-47.061,0-85.333-38.272-85.333-85.333
                                        s38.272-85.333,85.333-85.333s85.333,38.272,85.333,85.333S303.08,341.333,256.019,341.333z"/>

                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Период
                    </p>
                    <select
                        v-model="period"
                        class="sdm-select"
                    >
                        <option value="" selected>
                            Не выбрано
                        </option>
                        <option value="day" selected>
                            За последние сутки
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
                        <option value="date-range">
                            Произвольный
                        </option>
                    </select>
                </div>
                <div class="col-12 col-md-2 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Отчет по
                    </p>
                    <select
                        v-model="report_of"
                        class="sdm-select"
                        style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                    >
                        <option value="" selected>
                            Не выбрано
                        </option>
                        <option :value="1">
                            Устройство
                        </option>
                        <option :value="2">
                            Группа устройств
                        </option>
                        <option :value="3">
                            Рубеж
                        </option>
                    </select>
                </div>
                <div class="col-12 col-md-1 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text" style="visibility: hidden">
                        скрытые
                    </p>
                    <div class="form-check form-check-inline text-truncate">
                        <input
                            id="checkbox-2"
                            class="checkbox-custom"
                            name="checkbox-2"
                            type="checkbox"
                            v-model="hidden"
                        />
                        <label for="checkbox-2" class="checkbox-custom-label">
                            Скрытые
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-1 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text" style="visibility: hidden">
                        Фильтры
                    </p>
                    <button
                        type="button"
                        class="btn w-100 py-2 reset-button"
                        v-on:click="resetFilters"
                        style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                        :class="{ 'reset-button-active' : period || important || automatic || hidden || report_of || report_title}"
                    >
                        Сбросить
                    </button>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <reports-automatic
                :period="period"
                :important="important"
                :automatic="automatic"
                :hidden="hidden"
                :report_of="report_of"
                :report_title="report_title"
                :automatic_reports="reports"
                :users="users"
            >
            </reports-automatic>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import ReportsAutomatic from "../../components/reports/ReportsAutomatic";
    export default {
        name: "ReportsAutomaticPage",
        components: {Layout, ReportsAutomatic },
        props:['user', 'automatic_reports','users'],
        data() {
            return {
                //filters
                period: '',
                important:false,
                automatic:false,
                hidden:true,
                report_of: "",
                report_title: "",
                reports:[],
            }
        },
        created() {
            this.automatic_reports.forEach(item => {
                item.selected = false;
                this.reports.push(item);
            });
        },
        methods:{
            resetFilters() {
                this.period = '';
                this.important = false;
                this.automatic = false;
                this.hidden = false;
                this.report_of = "";
                this.report_title = "";
            },
            turnOffAll: function() {
                this.reports.forEach(report => {
                    report.is_active = false;
                });
                axios
                    .post(`/report/toggle-all`, {
                        is_active: false
                    })
                    .then(resp => {
                        // this.reports = resp.data.reports;
                        this.sendNotify('Вы успешно изменили состояние всех автоматических отчетов', 'success');
                        console.log(resp);
                        //this.data = resp.data.data;
                    })
                    .catch((error) => {
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                        console.log(error);
                    });
            },
            turnOnAll: function() {
                this.reports.forEach(report => {
                    report.is_active = true;
                });
                axios
                    .post(`/report/toggle-all`, {
                        is_active: true
                    })
                    .then(resp => {
                        // this.reports = resp.data.reports;
                        this.sendNotify('Вы успешно изменили состояние всех автоматических отчетов', 'success');
                        console.log(resp);
                        //this.data = resp.data.data;
                    })
                    .catch((error) => {
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                        console.log(error);
                    });
            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Автоматические отчеты',
                    text: notification,
                    type: type
                });
            },
        }
    }
</script>

<style scoped>

</style>
