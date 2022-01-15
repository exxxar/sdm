<template>
    <div class="row w-100 m-auto align-items-start justify-content-center">
        <div class="col-12">
            <div class="row w-100 m-auto align-items-center justify-content-start">
                <div class="form-check form-check-inline text-truncate">
                    <input
                        id="checkbox-1"
                        class="sdm-checkbox sdm-primary-checkbox"
                        name="checkbox-1"
                        type="checkbox"
                        v-model="ready_made_template"
                        @change="changeReadyMadeTemplate"
                    />
                    <label for="checkbox-1" class="sdm-checkbox-label">
                        Использовать готовый шаблон
                    </label>
                </div>
                <div class="form-check form-check-inline text-truncate">
                    <input
                        id="checkbox-3"
                        class="sdm-checkbox sdm-primary-checkbox"
                        name="checkbox-3"
                        type="checkbox"
                        v-model="new_report.automatic"
                    />
                    <label for="checkbox-3" class="sdm-checkbox-label">
                        Сделать автоматическим
                    </label>
                </div>
                <div class="d-flex" v-if="new_report.automatic"
                     style="width: 100px;justify-content: space-between;align-items: center;">
                    <p class="switch-label">ВЫКЛ</p>
                    <label class="switch">
                        <input
                            type="checkbox"
                            v-model="new_report.is_active"
                        />
                        <span class="slider round"></span>
                    </label>
                    <p class="switch-label">ВКЛ</p>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row w-100 my-auto mb-2 align-items-start justify-content-center">
                <div class="col-12 px-0" v-if="ready_made_template">
                    <p class="mb-1 d-flex mt-3" style="font-size: 9px; color: #959597; font-weight: 400">
                        Выберите шаблон
                    </p>
                    <select
                        v-model="new_report.template"
                        class="sdm-select"
                        style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                        @change="selectReportTemplate"
                    >
                        <option value="" selected>
                            Не выбрано
                        </option>
                        <option :value="report_template" v-for="(report_template,index) in report_templates"
                                :key="index">
                            {{report_template.title}}
                        </option>
                    </select>
                </div>
                <div class="col-12 px-0">
                    <p class="mb-1 d-flex mt-3" style="font-size: 9px; color: #959597; font-weight: 400">
                        Введите название отчета
                    </p>
                    <input
                        v-model="new_report.title"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                        :class="{ 'is-invalid' : errors.title, 'form-control':true }"
                    />


                    <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                            <strong>{{ errors.title }}</strong>
                    </span>
                </div>
                <div class="col-6 px-0">
                    <div class="row w-100 m-auto align-items-center justify-content-center">
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-3">
                                Отчет по
                            </p>
                            <select
                                v-model="new_report.report_of"
                                class="sdm-select"
                                style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                :class="{ 'is-invalid' : errors.report_of }"
                                @change="selectObjectType"
                               
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

                            <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                            <strong>{{ errors.report_of }}</strong>
                        </span>
                        </div>
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                                Выберите устройство/рубеж/группу
                            </p>
                            <select
                                v-model="new_report.object"
                                class="sdm-select"
                                style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                :disabled="new_report.report_of ===''"
                                
                            >
                                <option value="" selected>
                                    Не выбрано
                                </option>
                                <option :value="obj" v-for="(obj,index) in filteredObjects" :key="index">
                                    {{obj.title}}
                                </option>
                            </select>

                            <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                            <strong>{{ errors.object }}</strong>
                        </span>
                        </div>
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                                Параметр
                            </p>
                            <!--                            todo:CHECK   find out what are options here-->
                            <select
                                v-model="new_report.parameter"
                                class="sdm-select"
                                style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                            >
                                <option value="passages" selected>
                                    Проезды
                                </option>
                                <option value="violations">
                                    Нарушения
                                </option>
                                <option value="voltage">
                                    Работоспособность
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6 px-0">
                    <div class="col-12 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text mt-3">
                            Период
                        </p>
                        <!--todo: CHECK   find out what are options here-->
                        <select
                            v-model="new_report.period"
                            class="sdm-select"
                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                        >
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
                    <div class="col-12 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text mt-2">
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
                            v-model="new_report.dateRange"
                            :linkedCalendars="true"
                            class="w-100"
                            :readonly="new_report.period !='date-range'"
                            :disabled="new_report.period !='date-range'"
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
                                            v-if="new_report.period ==='date-range'"
                                            style="color: #7224f2"
                                        >
                                            {{picker.startDate | moment("DD MMMM YYYY")}} - {{picker.endDate | moment("DD MMMM YYYY")}}
                                        </span>
                                        <span
                                            v-if="new_report.period !=='date-range'"
                                            style="color:#7224f2"
                                            v-bind:class="{'readonly': new_report.period !=='date-range'}"
                                        >
                                            Не выбрано
                                        </span>
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
                                                v-bind:class="{'readonly': new_report.period !=='date-range'}"
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
                    <div class="col-12 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text mt-2" v-if="new_report.automatic">
                            Регулярность
                            <!--todo: CHECK find out what are options here-->
                        </p>
                        <select
                            v-model="new_report.regularity"
                            class="sdm-select"
                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                            v-if="new_report.automatic"
                        >
                            <option value="day" selected>
                                Раз в день
                            </option>
                            <option value="week">
                                Раз в неделю
                            </option>
                            <option value="month">
                                Раз в месяц
                            </option>
                            <option value="year">
                                Раз в год
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12">
                    <p class="mb-1 mr-3 d-flex sdm-secondary-text mt-3" style="visibility:hidden">
                        Рассылка по e-mail
                    </p>
                    <div class="form-check form-check-inline text-truncate">
                        <input
                            id="checkbox-2"
                            class="sdm-checkbox sdm-primary-checkbox"
                            name="checkbox-2"
                            type="checkbox"
                            v-model="new_report.mailing"
                        />
                        <label for="checkbox-2" class="sdm-checkbox-label">
                            Рассылка по e-mail
                        </label>
                    </div>
                </div>
                <div class="col-12 recipients">
                    <p class="mb-0 mr-3 w-100 sdm-secondary-text">
                        Выберите адресатов
                    </p>
                    <div class="form-check form-check-inline text-truncate">
                        <input
                            id="radio-3"
                            class="sdm-checkbox sdm-primary-checkbox"
                            name="options"
                            type="radio"
                            v-model="recipients_radio"
                            value="email"
                            @change="recipients"
                            :disabled="!new_report.mailing"
                        />
                        <label for="radio-3" class="sdm-checkbox-label">
                            E-mail
                        </label>
                    </div>
                    <div class="form-check form-check-inline text-truncate">
                        <input
                            id="radio-4"
                            class="sdm-checkbox sdm-primary-checkbox"
                            name="options"
                            type="radio"
                            v-model="recipients_radio"
                            value="name"
                            @change="recipients"
                            :disabled="!new_report.mailing"
                        />
                        <label for="radio-4" class="sdm-checkbox-label">
                            Фамилия Имя
                        </label>
                    </div>
                    <div class="form-check form-check-inline mb-2 text-truncate ">
                        <input
                            id="radio-5"
                            class="sdm-checkbox sdm-primary-checkbox"
                            name="options"
                            type="radio"
                            v-model="recipients_radio"
                            value="role"
                            @change="recipients"
                            :disabled="!new_report.mailing"
                        />
                        <label for="radio-5" class="sdm-checkbox-label">
                            Роль
                        </label>
                    </div>
                    <v-select
                        placeholder="Поиск..."
                        v-model="currentEmail"
                        :options="mailsOptions"
                        :disabled="!new_report.mailing"
                    ></v-select>
                </div>
                <div class="col-12">
                    <div class="row w-100 mx-auto mt-2 align-items-center justify-content-start"
                         v-if="new_report.mailing">
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
            </div>
        </div>
        <div class="col-12 px-0">
            <div class="row w-100 m-auto align-items-center justify-content-end">
                <div class="form-check mr-3 form-check-inline text-truncate">
                    <input
                        id="checkbox-6"
                        class="sdm-checkbox sdm-primary-checkbox"
                        name="checkbox-6"
                        type="checkbox"
                        v-model="new_report.important"
                    />
                    <label for="checkbox-6" class="sdm-checkbox-label">
                        Добавить в важное
                    </label>
                </div>
                <div class="form-check mr-3 form-check-inline text-truncate">
                    <input
                        id="checkbox-7"
                        class="sdm-checkbox sdm-primary-checkbox"
                        name="checkbox-7"
                        type="checkbox"
                        v-model="new_report.is_hidden"
                    />
                    <label for="checkbox-7" class="sdm-checkbox-label">
                        Скрыть
                    </label>
                </div>
                <button
                    type="button"
                    class="btn my-1 btn-dark py-2 px-3 add-button"
                    :class="{ 'add-button-disabled' : loading }"
                    :disabled="loading"
                    @click="createReport"
                >
                    Создать отчет
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "ReportsAdd",
        props: ['users',
            'objects',
            //todo: DONE        get report-templates as prop or get in method when change 'ready_made_template' value
            'report_templates',
            'roles'
        ],
        data() {
            let startDate = new Date();
            startDate.setHours(0, 0, 0, 0);
            let endDate = new Date();
            endDate.setDate(endDate.getDate() + 6);
            endDate.setHours(23, 59, 59, 999);
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
                new_report: {
                    title: '',
                    report_of: '',
                    object: '',
                    parameter: 'passages',
                    period: 'day',
                    regularity: 'day',
                    dateRange: {startDate, endDate},
                    recipients: [],
                    automatic: false,
                    is_hidden: false,
                    important: false,
                    mailing: true,
                    is_active: false,
                    start_period_date: null,
                    end_period_date: null,
                    template: ''
                },

                errors: {
                    title: null,
                    object: null,
                    report_of: null,

                },
                //checkboxes
                ready_made_template: false,
                //radios
                recipients_radio: 'email',
                //v-select
                mailsOptions: [],
                selectedEmails: [],
                //загрузка
                loading: false,
            }
        },
        created() {
            this.users.forEach((user) => {
                this.mailsOptions.push({label: user.email, code: user.id, email: user.email})
            })

            if (localStorage.getItem("report")) {

                console.log(localStorage.getItem("report"))
                let report = JSON.parse(localStorage.getItem("report"));
                /* type: 'device',
                     user: this.user,
                     device: this.device,*/

                this.new_report.period = report.period
                if(!report.not_efficiency_mode){
                    this.new_report.parameter='voltage'
                }else{
                    if(report.has_violations){
                        this.new_report.parameter='violations'
                    }
                    if(report.has_passages){
                        this.new_report.parameter='passages'
                    }
                }
                if (report.type === 1) {
                    this.new_report.title = "Отчет по: " + report.device[0].label
                    if (report.user) {
                        this.new_report.recipients = [report.user.id]
                        this.selectedEmails.push({
                            label: report.user.email,
                            code: report.user.id,
                            email: report.user.email
                        })
                    }

                    this.new_report.object = {
                        id:report.device[0].code,
                        title:report.device[0].label,
                        type:report.type,
                    }
                    //this.new_report.object = report.device.id
                    this.new_report.report_of = report.type
                }

                if (report.type === 3) {
                    this.new_report.title = "Отчет по: " + report.boundary.title
                    this.new_report.report_of = report.type

                    if (report.user) {
                        this.new_report.recipients = [report.user.id]
                        this.selectedEmails.push({
                            label: report.user.email,
                            code: report.user.id,
                            email: report.user.email
                        })
                    }

                    this.new_report.object = {
                        id:report.boundary.id,
                        title:report.boundary.title,
                        type:report.type,
                    }
                }
            }
        },
        computed: {
            currentEmail: {
                get: function () {
                    return null
                },
                set: function (newValue) {
                    if (this.recipients_radio !== 'role') {
                        let removeIndex = this.mailsOptions.map(item => item.code).indexOf(newValue.code);
                        this.mailsOptions.splice(removeIndex, 1);
                        this.selectedEmails.push(newValue);
                    } else {
                        //todo: CHECK     change when get list of roles
                        this.selectedEmails = [];
                        this.users.forEach((user) => {
                            if (user.roles && user.roles.length > 0) {
                                if (user.roles[0].name == newValue.label) {
                                    this.selectedEmails.push({label: user.email, code: user.id, email: user.email})
                                }
                            }
                        })
                    }
                }
            },
            filteredObjects() {
                return this.objects.filter(item => {
                    let object_type = true;

                    if (this.new_report.report_of !== "") {
                        object_type = item.type == this.new_report.report_of;
                    }
                    return object_type;
                });
            },
        },
        watch: {
            mailsOptions: {
                handler: function () {
                },
                deep: true
            },
            new_report:{
              handler:function(){
                  console.log(this.new_report.object)
              },
                deep:true
            },
            selectedEmails: {
                handler: function () {
                },
                deep: true
            }
        },
        methods: {


            
            removeEmail(mail) {
                let removeIndex = this.selectedEmails.map(item => item.code).indexOf(mail.code);
                this.selectedEmails.splice(removeIndex, 1);
                if (this.recipients_radio !== 'role') {
                    this.mailsOptions.push(mail);
                }
            },
            createReport() {
                this.loading = true;
                this.new_report.recipients = [];
                //todo: DONE      method for creating new report
                if (this.new_report.mailing) {
                    this.selectedEmails.forEach(mail => {
                        this.new_report.recipients.push(mail.code);
                    });
                }
                if (this.new_report.period == 'date-range') {
                    this.new_report.start_period_date = moment(this.new_report.dateRange.startDate).format('YYYY-MM-DD HH:mm:ss');
                    this.new_report.end_period_date = moment(this.new_report.dateRange.endDate).format('YYYY-MM-DD HH:mm:ss');
                }
                axios.post('/report', this.new_report)
                    .then((resp) => {
                        this.loading = false;
                        localStorage.setItem("report", null)
                        window.location.href = "/reports";
                    })
                    .catch((error) => {

                        this.loading = false
                        this.sendNotify("Произошла ошибка, повторите позже", "error")
                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }

                    });
            },
            recipients() {
                this.mailsOptions = [];
                if (this.recipients_radio == 'email') {
                    this.users.forEach((user) => {
                        this.mailsOptions.push({label: user.email, code: user.id, email: user.email})
                    })
                }
                if (this.recipients_radio == 'name') {
                    this.users.forEach((user) => {
                        this.mailsOptions.push({label: user.name, code: user.id, email: user.email})
                    })
                }
                let temp = this.selectedEmails;
                this.selectedEmails = [];
                if (this.recipients_radio == 'email' || this.recipients_radio == 'name') {
                    temp.forEach((mail) => {
                        let removeIndex = this.mailsOptions.map(item => item.code).indexOf(mail.code);
                        if (removeIndex > -1) {
                            this.selectedEmails.push(this.mailsOptions[removeIndex]);
                            this.mailsOptions.splice(removeIndex, 1);
                        }
                    })
                }

                if (this.recipients_radio == 'role') {
                    //todo: DONE      uncomment and change when will get list of roles
                    this.roles.forEach((role) => {
                        this.mailsOptions.push({label: role.name, code: role.id})
                    })
                }
            },
            selectObjectType() {
                this.new_report.object = '';
            },
            selectReportTemplate() {
                if (this.new_report.template != '') {
                    //todo: get data of selected report template and fill available fields
                    this.new_report.report_of = this.new_report.template.report_of;
                    this.new_report.object = this.new_report.template.object;
                    console.log(this.new_report.object, this.new_report.template.object)
                    this.new_report.parameter = this.new_report.template.parameter;
                    this.new_report.important = this.new_report.template.important;
                    this.recipients_radio = 'email';
                    this.new_report.recipients = [];
                    this.mailsOptions = [];
                    this.selectedEmails = [];
                    this.recipients();
                    this.new_report.template.recipients.forEach((recipient) => {
                        let removeIndex = this.mailsOptions.map(item => item.code).indexOf(recipient);
                        if (removeIndex > -1) {
                            this.mailsOptions.splice(removeIndex, 1);
                        }
                        let userIndex = this.users.map(item => item.id).indexOf(recipient);
                        if (userIndex > -1) {
                            this.selectedEmails.push({
                                label: this.users[userIndex].email,
                                code: this.users[userIndex].id,
                                email: this.users[userIndex].email
                            })
                        }
                    })
                }
            },
            changeReadyMadeTemplate() {
                if (this.ready_made_template == true) {
                    this.selectReportTemplate();
                }else{
                    let startDate = new Date();
                    startDate.setHours(0, 0, 0, 0);
                    let endDate = new Date();
                    endDate.setDate(endDate.getDate() + 6);
                    endDate.setHours(23, 59, 59, 999);
                    this.new_report.title=''
                    this.new_report.report_of= ''
                    this.new_report.object= ''
                    this.new_report.parameter= 'passages'
                    this.new_report.period= 'day'
                    this.new_report.regularity= 'day'
                    this.new_report.dateRange= {startDate, endDate},
                    this.new_report.recipients= [],
                    this.new_report.automatic= false
                    this.new_report.is_hidden= false
                    this.new_report.important= false
                    this.new_report.mailing= true
                    this.new_report.is_active= false
                    this.new_report.start_period_date= null
                    this.new_report.end_period_date= null
                    this.new_report.template= ''
                    this.selectedEmails = [];
                    
                }
            },
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY") + ' - ' + moment(text[1]).format("DD MMMM YYYY");
                return text;
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Отчеты',
                    text: notification,
                    type: type
                });
            }
        }
    }
</script>

<style scoped>
    .readonly {
        color: #9d9ea5 !important;
        fill: #9d9ea5;
    }

    .recipients .sdm-checkbox + .sdm-checkbox-label::before {
        margin-right: 10px;
    }

    .recipients .sdm-checkbox, .recipients .sdm-checkbox-label {
        margin: 2px;
        font-weight: 400;
        font-size: 9px;
    }

    .recipients .form-check-inline {
        margin-right: 10px;
    }

    .add-button-disabled {
        background: #dfe1ee !important;
        border: none !important;
    }

    .add-button {
        background: green;
        color: white;
        border: none;
        font-size: 12px;
    }
</style>
