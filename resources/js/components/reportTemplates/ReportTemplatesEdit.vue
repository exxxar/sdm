<template>
    <div class="row w-100 m-auto align-items-start justify-content-center">
        <div class="col-8">
            <div class="row w-100 m-auto align-items-center justify-content-start">
                <div class="col-12 px-0">
                    <p class="mb-1 d-flex mt-3" style="font-size: 9px; color: #959597; font-weight: 400">
                        Введите название шаблона
                    </p>
                    <input
                        v-model="edited_report_template.title"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
                </div>
                <div class="col-6 px-0">
                    <div class="row w-100 m-auto align-items-center justify-content-center">
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-3">
                                Отчет по
                            </p>
                            <select
                                v-model="edited_report_template.report_of"
                                class="form-select"
                                style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
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
                        </div>
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                                Выберите устройства/рубежи/группы
                            </p>
                            <select
                                v-model="edited_report_template.object"
                                class="form-select"
                                style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                v-bind:class="{'readonly': edited_report_template.report_of===''}"
                                :disabled="edited_report_template.report_of ===''"
                            >
                                <option value="" selected>
                                    Не выбрано
                                </option>
                                <option :value="obj" v-for="(obj,index) in filteredObjects" :key="index">
                                    {{obj.title}}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                                Параметр
                            </p>
                            <select
                                v-model="edited_report_template.parameter"
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
                            v-model="edited_report_template.mailing"
                        />
                        <label for="checkbox-2" class="sdm-checkbox-label">
                            Рассылка по e-mail
                        </label>
                    </div>
                </div>
                <div class="col-12 recipients">
                    <p class="mb-1 mr-3 d-inline-flex sdm-secondary-text">
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
                            :disabled="!edited_report_template.mailing"
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
                            :disabled="!edited_report_template.mailing"
                        />
                        <label for="radio-4" class="sdm-checkbox-label">
                            Фамилия Имя
                        </label>
                    </div>
                    <div class="form-check form-check-inline text-truncate">
                        <input
                            id="radio-5"
                            class="sdm-checkbox sdm-primary-checkbox"
                            name="options"
                            type="radio"
                            v-model="recipients_radio"
                            value="role"
                            @change="recipients"
                            :disabled="!edited_report_template.mailing"
                        />
                        <label for="radio-5" class="sdm-checkbox-label">
                            Роль
                        </label>
                    </div>
                    <v-select
                        placeholder="Поиск..."
                        v-model="currentEmail"
                        :options="mailsOptions"
                        :disabled="!edited_report_template.mailing"
                    ></v-select>
                </div>
                <div class="col-12">
                    <div class="row w-100 mx-auto mt-2 align-items-center justify-content-start" v-if="edited_report_template.mailing">
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
                        v-model="edited_report_template.important"
                    />
                    <label for="checkbox-6" class="sdm-checkbox-label">
                        Добавить в важное
                    </label>
                </div>
                <button
                    @click="editReportTemplate"
                    type="button"
                    class="btn my-1 btn-dark py-2 px-3 add-button"
                    :class="{ 'add-button-disabled' : loading }"
                    :disabled="loading"
                >
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReportTemplatesEdit",
        props:['users', 'objects', 'report_template', 'roles'],
        data() {
            return {
                edited_report_template: {
                    title: '',
                    report_of: '',
                    object: null,
                    parameter: '',
                    recipients:[],
                    //checkboxes
                    mailing:true,
                    important:false,
                },

                //radios
                recipients_radio:'email',
                //v-select
                mailsOptions:[],
                selectedEmails:[],
                //загрузка
                loading: false,
            }
        },
        created() {
            this.edited_report_template.title = this.report_template.title;
            this.edited_report_template.report_of = this.report_template.report_of;
            this.edited_report_template.object = this.report_template.object;
            this.edited_report_template.parameter = this.report_template.parameter;
            this.edited_report_template.recipients = this.report_template.recipients;
            this.edited_report_template.mailing = this.report_template.mailing;
            this.edited_report_template.important = this.report_template.important;
            this.mailsOptions = [];
            this.selectedEmails = [];
            this.recipients();
            this.report_template.recipients.forEach((recipient) => {
                let removeIndex = this.mailsOptions.map(item => item.code).indexOf(recipient);
                if(removeIndex>-1)
                {
                    this.mailsOptions.splice(removeIndex, 1);
                }
                let userIndex = this.users.map(item => item.id).indexOf(recipient);
                if(userIndex>-1) {
                    this.selectedEmails.push({label: this.users[userIndex].email, code: this.users[userIndex].id, email:this.users[userIndex].email})
                }
            })
        },
        computed: {
            currentEmail: {
                get: function () {
                    return null
                },
                set: function (newValue) {
                    if(this.recipients_radio !== 'role') {
                        let removeIndex = this.mailsOptions.map(item => item.code).indexOf(newValue.code);
                        this.mailsOptions.splice(removeIndex, 1);
                        this.selectedEmails.push(newValue);
                    }
                    else {
                        //todo: CHECK     change when get list of roles
                        this.selectedEmails=[];
                        this.users.forEach((user) => {
                            if(user.roles && user.roles.length>0){
                                if(user.roles[0].name == newValue.label)
                                {
                                    this.selectedEmails.push({label: user.email, code: user.id, email:user.email})
                                }
                            }
                        })
                    }
                }
            },
            filteredObjects() {
                return this.objects.filter(item => {
                    let object_type = true;

                    if (this.edited_report_template.report_of !== "") {
                        object_type = item.type == this.edited_report_template.report_of;
                    }
                    return object_type;
                });
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
        methods: {
            removeEmail(mail) {
                let removeIndex = this.selectedEmails.map(item => item.code).indexOf(mail.code);
                this.selectedEmails.splice(removeIndex, 1);
                if(this.recipients_radio !== 'role') {
                    this.mailsOptions.push(mail);
                }
            },
            editReportTemplate() {
                //todo: method for editing new report template
                this.loading = true;
                this.edited_report_template.recipients = [];
                if(this.edited_report_template.mailing)
                {
                    this.selectedEmails.forEach(mail =>{
                        this.edited_report_template.recipients.push(mail.code);
                    });
                }
                axios.patch(`/report-template/${this.report_template.id}`, this.edited_report_template)
                    .then( (resp) => {
                        this.loading = false;
                        window.location.href = "/report-templates";
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });
            },
            recipients() {
                this.mailsOptions = [];
                if(this.recipients_radio == 'email')
                {
                    this.users.forEach((user) => {
                        this.mailsOptions.push({label: user.email, code: user.id, email:user.email})
                    })
                }
                if(this.recipients_radio == 'name')
                {
                    this.users.forEach((user) => {
                        this.mailsOptions.push({label: user.name, code: user.id, email:user.email})
                    })
                }
                let temp = this.selectedEmails;
                this.selectedEmails = [];
                if(this.recipients_radio == 'email' || this.recipients_radio == 'name')
                {
                    temp.forEach((mail) => {
                        let removeIndex = this.mailsOptions.map(item => item.code).indexOf(mail.code);
                        if(removeIndex>-1)
                        {
                            this.selectedEmails.push(this.mailsOptions[removeIndex]);
                            this.mailsOptions.splice(removeIndex, 1);
                        }
                    })
                }

                if(this.recipients_radio == 'role') {
                    this.roles.forEach((role) => {
                        this.mailsOptions.push({label: role.name, code: role.id})
                    })
                }
            },
            selectObjectType() {
                this.edited_report_template.object='';
            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Шаблоны отчетов',
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
        margin-right:0px;
    }
    .recipients .sdm-checkbox, .recipients .sdm-checkbox-label {
        margin: 2px;
        font-weight: 400;
        font-size: 9px;
    }
    .recipients .form-check-inline
    {
        margin-right:10px;
    }
    .add-button-disabled {
        background: #dfe1ee !important;
        border:none!important;
    }
    .add-button{
        background: #6917f1 !important;
        color:white;
        border: none;
        font-size: 12px;
    }
</style>
