<template>
    <layout title="Отчеты" :info="true" :info_text="'Это отчеты.'">
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
                                style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                            >
                                Отчеты
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
            <modal :id="'sending_all_reports'" :header="true">
                <template v-slot:header>
                    Отправить все отчеты
                </template>
                <template v-slot:main>
                    <div class="row w-100 h-100 mx-auto my-3 align-items-center justify-content-center">
                        <div class="col-12">
                            <h2 class="sdm-primary-text">Выберите адресатов</h2>
                        </div>
                        <div class="col-12">
                            <v-select
                                placeholder="Поиск..."
                                v-model="currentEmail"
                                :options="mailsOptions"
                            ></v-select>
                        </div>
                        <div class="col-12">
                            <div class="row w-100 m-auto align-items-center justify-content-start">
                                <div style="display: flex" class="mr-2 mb-1" :key="mail.code" v-for="mail in selectedEmails">
                                    <div class="mr-1">{{ mail.label}}</div>
                                    <div @click="removeEmail(mail)"
                                         style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px"
                                    >
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
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
                                <div class="col-5">
                                    <button class="btn w-100 mx-auto py-2 sdm-reset-button" data-bs-dismiss="modal">
                                        Отмена
                                    </button>
                                </div>
                                <div class="col-5">
                                    <button class="btn w-100 mx-auto py-2 sdm-red-button" @click="sendAllReportsToEmails">
                                        Отправить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </modal>
            <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                <div class="col-12 col-md-3 pr-0 pl-0">
                    <button
                        v-on:click="toAutomaticReports"
                        class="btn my-1 mr-1 py-1 sdm-primary-underline-button float-right"
                    >
                        <span>
                            Автоматические отчеты
                        </span>
                    </button>
                </div>
                <div class="col-12 col-md-2 pr-0 pl-0">
                    <button
                        v-on:click="toReportTemplates"
                        class="btn w-100 my-1 mr-1 py-1 sdm-primary-underline-button"
                    >
                        <span>
                            Шаблоны
                        </span>
                    </button>
                </div>
                <div class="col-12 col-md-1 pr-1 pl-0">
                    <button
                        data-bs-toggle="modal" data-bs-target="#sending_all_reports"
                        class="btn float-right d-flex align-items-center justify-content-center"
                        style="height:36px; border: 1px solid #7224f2; font-size: 15px; width: 36px; min-width: 36px; background: transparent; color: black"
                        title="Отправить отчет на почту"
                    >
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 474.624 474.624" style="width: 14px; height: 14px; min-width: 14px; min-height: 14px; enable-background:new 0 0 474.624 474.624;"
                             xml:space="preserve"
                        >
                            <path d="M428.544,52.736H45.568c-7.168,0-13.824,1.536-19.968,4.608l211.456,171.52l211.456-171.52
                                C442.368,54.272,436.224,52.736,428.544,52.736z"/>

                            <path d="M251.392,275.968c-4.096,3.584-9.216,5.12-14.336,5.12s-10.24-1.536-14.336-5.12L0,95.232c0,1.024,0,1.536,0,3.072V376.32
                                c0,25.088,20.48,45.568,45.568,45.568h383.488c25.088,0,45.568-20.48,45.568-45.568V98.304c0-1.024,0-1.536,0-3.072
                                L251.392,275.968z"/>
                        </svg>
                    </button>
                </div>
                <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">
                    <button
                        v-on:click="createReportTemplate"
                        type="button"
                        class="btn w-100 my-1 btn-dark py-2"
                        style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;"
                    >
                        Создать шаблон отчета
                    </button>
                </div>
                <div class="col-12 col-md-3 col-sm-6 px-0">
                    <button
                        v-on:click="createReport"
                        type="button"
                        class="btn w-100 btn-dark my-1 mr-1 py-2"
                        style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                    >
                        Создать отчет
                    </button>
                </div>
            </div>
        </template>
        <template v-slot:filters>
            <div class="row w-100 m-auto justify-content-center align-items-center">
                <div class="col-12 col-md-4 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Название отчета
                    </p>
                    <input
                        v-model="report_title"
                        class="form-control"
                        placeholder="Все"
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
<!--                    <select-->
<!--                        v-model="report_title"-->
<!--                        class="sdm-select"-->
<!--                        style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"-->
<!--                    >-->
<!--                        <option value="" selected>-->
<!--                            Все-->
<!--                        </option>-->
<!--                    </select>-->
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
                                @click="automatic = !automatic"
                                class="btn mr-2 d-flex align-items-center justify-content-center sdm-icon-button"
                                v-bind:class="{'active': automatic, 'nonactive':!automatic}"
                                title="Автоматический отчет"
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
                                    {{picker.startDate | moment("DD MMMM YYYY")}} - {{picker.endDate | moment("DD MMMM YYYY")}}
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
                        <option :value="4">
                            Группа рубежей
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
                        :class="{ 'reset-button-active' : dateRange || important || automatic || hidden || report_of || report_title}"
                    >
                        Сбросить
                    </button>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <reports
                :dateRange="dateRange"
                :important="important"
                :automatic="automatic"
                :hidden="hidden"
                :report_of="report_of"
                :report_title="report_title"
                :reports="reports"
                :users="users"
            >
            </reports>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import Reports from "../../components/reports/Reports";
    import Modal from "../../components/Modal";
    import moment from 'moment';
    export default {
        name: "ReportsPage",
        props:['user', 'reports', 'users'],
        components:{Layout, Reports, Modal},
        data() {
            let startDate = new Date();
            startDate.setHours(0,0,0,0);
            let endDate = new Date();
            endDate.setDate(endDate.getDate() + 6);
            endDate.setHours(23,59,59,999);
            return {
                local_data: {
                    format: 'mm/dd/yyyy',
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
                //filters
                dateRange: { startDate, endDate },
                important:false,
                automatic:false,
                hidden:true,
                report_of: "",
                report_title: "",
                mailsOptions:[],
                selectedEmails:[],
            }
        },
        created() {
            this.users.forEach((user) => {
                this.mailsOptions.push({label: user.email, code: user.id})
            })
        },
        computed: {
            currentEmail: {
                get: function () {
                    return null
                },
                set: function (newValue) {
                    let removeIndex = this.mailsOptions.map(item => item.code).indexOf(newValue.code);
                    this.mailsOptions.splice(removeIndex, 1);
                    this.selectedEmails.push(newValue);
                }
            },
        },
        watch: {
            mailsOptions: {
                handler: function () {},
                deep: true
            },
            selectedEmails: {
                handler: function () {},
                deep: true
            }
        },
        methods:{
            resetFilters() {
                let startDate = new Date();
                startDate.setHours(0,0,0,0);
                let endDate = new Date();
                endDate.setDate(endDate.getDate() + 6);
                endDate.setHours(23,59,59,999);
                this.dateRange =  { startDate, endDate };
                this.important = false;
                this.automatic = false;
                this.hidden = false;
                this.report_of = "";
                this.report_title = "";
            },
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY") + ' - ' + moment(text[1]).format("DD MMMM YYYY");
                return text;
            },
            toReportTemplates() {
                window.location.href = "/report-templates";
            },
            toAutomaticReports() {
                window.location.href = "/reports/show/automatic";
            },
            sendAllReportsToEmails() {
                //todo: method for sending to email
                let recipients = this.users.filter(recipient=>{
                    if (this.selectedEmails.map(item => item.code).indexOf(recipient.id) >-1)
                    {
                        return true;
                    }
                });
                let data = {
                    id:this.report_id,
                    recipients: recipients
                };
                axios
                    .post(`/report/sendAllReportsToEmails`, data)
                    .then(resp => {
                        console.log(resp);
                        $('#sending_all_reports').modal('hide');
                        this.selectedEmails=[];
                        this.users.forEach((user) => {
                            this.mailsOptions.push({label: user.email, code: user.id})
                        });
                        this.sendNotify('Вы успешно послали отчет на указанные email', 'success');
                        //this.data = resp.data.data;
                    })
                    .catch((error) => {
                        $('#sending_all_reports').modal('hide');
                        this.selectedEmails=[];
                        this.users.forEach((user) => {
                            this.mailsOptions.push({label: user.email, code: user.id})
                        });
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });
            },
            createReportTemplate() {
                window.location.href = "/report-templates/add";
            },
            createReport() {
                window.location.href = "/reports/add";
            },
            removeEmail(mail) {
                let removeIndex = this.selectedEmails.map(item => item.code).indexOf(mail.code);
                this.selectedEmails.splice(removeIndex, 1);
                this.mailsOptions.push(mail);
            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Отчеты',
                    text: notification,
                    type:type
                });
            }
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
    .checkbox-custom + .checkbox-custom-label:before {
        font-family: Montserrat;
        content: "";
        border: 1px solid #ddd;
        display: inline-block;
        vertical-align: middle;
        width: 17px;
        height: 17px;
        padding: 2px;
        margin-right: 5px;
        text-align: center;
        border-radius: 3px;
    }
    .reset-button {
        background: #dfe1ee;
        border: none;
        color: white;
        font-size: 11px;
        font-weight: 500;
        opacity: 1 !important;
    }
    .reset-button:hover, .reset-button:focus, .reset-button:active {
        background: #dfe1ee;
        color: white;
    }
    .reset-button-active {
        background: #6633ff !important;
        color: white !important;
    }
    .reset-button-active:hover {
        background: #7224f2 !important;
    }
</style>
