<template>
<div>
    <modal :id="'mailing'">
        <template v-slot:main>
            <div class="row w-100 h-100 mx-auto my-3 align-items-center justify-content-center">
                <div class="col-12">
                    <h2 class="sdm-primary-text">Выберите адресатов</h2>
                </div>
                <div class="col-12">
                    <v-select placeholder="Поиск..." v-model="currentEmail" :options="mailsOptions"></v-select>
                </div>
                <div class="col-12">
                    <div class="row w-100 mx-auto mt-3 align-items-center justify-content-start">
                        <div style="display: flex" class="mr-2 mb-1" :key="mail.code" v-for="mail in selectedEmails">
                            <div class="mr-1">{{ mail.label}}</div>
                            <div @click="removeEmail(mail)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                                <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                    <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
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
                            <button class="btn w-100 mx-auto py-2 sdm-red-button" @click="sendReportToEmails">
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal>
    <modal :id="'deleting'">
        <template v-slot:main>
            <div class="row w-100 h-100 mx-auto my-3 align-items-center justify-content-center">
                <div class="col-12">
                    <h2 class="sdm-primary-text">Вы действительно хотите удалить выбранный объект?</h2>
                </div>
                <div class="col-12">
                    <div class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
                        <div class="col-5">
                            <button class="btn w-100 mx-auto py-2 sdm-reset-button" data-bs-dismiss="modal">
                                Отмена
                            </button>
                        </div>
                        <div class="col-5">
                            <button class="btn w-100 mx-auto py-2 sdm-red-button" @click="deleteReport">
                                Удалить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal>
    <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-2 align-items-center justify-content-center">
        <div class="custom-filter col-5 pl-0" @click="sort('title')" style="cursor: pointer;">
            Название отчета
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'title'" class="fas fa-angle-down filter-icon"></i>
        </div>
        <div class="col-1 px-2"></div>
        <div class="custom-filter col-2 px-2" @click="sort('created_at')" style="cursor: pointer; padding-left: 30px">
            Дата создания
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'created_at'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-2" @click="sort('report_of')" style="cursor: pointer; display: flex;flex-wrap: nowrap; align-items: center; padding-left: 0;">
            Отчет по
            <i v-bind:class="{ 'sort-icon-rotation': currentSortDir == 'asc' }" v-if="currentSort == 'report_of'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-2">
        </div>
    </div>
    <div class="row w-100 mx-auto align-items-center justify-content-center" v-if="sortedList.length>0">
        <div class="col-12 p-0" :key="item.id" v-for="(item, index) in sortedList">
            <div class="row w-100 mx-auto mb-1 py-3 px-3 align-items-center justify-content-center sdm-primary-text" style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap">
                <div class="col-5 text-wrap">
                    {{item.title}}
                </div>
                <div class="col-12 col-md-1 px-2">
                    <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                        <div class="col-6 pl-0 pr-1">
                            <div class="mr-2 d-flex align-items-center justify-content-center sdm-icon-button" v-bind:class="{'active': item.important ==true}" style="border: none !important;" v-tooltip="{
                              content: 'Избранное' ,
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512.002 512.002;" xml:space="preserve">
                                    <path fill="#7c34f2" v-bind:class="{'readonly': item.important !=true}" d="M511.267,197.258c-1.764-5.431-6.457-9.389-12.107-10.209l-158.723-23.065L269.452,20.157
                                            c-2.526-5.12-7.741-8.361-13.45-8.361c-5.71,0-10.924,3.241-13.451,8.361l-70.988,143.827l-158.72,23.065
                                            c-5.649,0.82-10.344,4.778-12.108,10.208c-1.765,5.431-0.293,11.392,3.796,15.377l114.848,111.954L92.271,482.671
                                            c-0.966,5.628,1.348,11.314,5.967,14.671c2.613,1.898,5.708,2.864,8.818,2.864c2.388,0,4.784-0.569,6.978-1.723l141.967-74.638
                                            l141.961,74.637c5.055,2.657,11.178,2.215,15.797-1.141c4.619-3.356,6.934-9.044,5.969-14.672l-27.117-158.081l114.861-111.955
                                            C511.56,208.649,513.033,202.688,511.267,197.258z" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-6 pl-1 pr-0">
                            <div v-if="item.automatic" class="mr-2 d-flex align-items-center justify-content-center sdm-icon-button" style="border-radius: 50% !important;" v-tooltip="{
                              content: 'Автоматические отчеты' ,
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
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
                                            s38.272-85.333,85.333-85.333s85.333,38.272,85.333,85.333S303.08,341.333,256.019,341.333z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-2 px-2">
                    {{item.created_at | moment('DD MMMM YYYY в HH:mm')}}
                </div>
                <div class="col-12 col-md-2">
                    <span v-if="item.report_of == 1">Устройству</span>
                    <span v-if="item.report_of == 2">Группе устройств</span>
                    <span v-if="item.report_of == 3">Рубежу</span>
                    <span v-if="item.report_of == 4">Группе рубежей</span>
                </div>
                <div class="col-12 col-md-2 px-1">
                    <div style="flex-wrap: nowrap; justify-content: end" class="row w-100 mx-auto my-1 align-items-center">
                        <button @click="editReport(item.id)" class="btn ml-0 mr-1 d-flex align-items-center justify-content-center" style="height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;">
                            <svg id="Capa_1" style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px" enable-background="new 0 0 488.471 488.471" height="512" viewBox="0 0 488.471 488.471" width="512" xmlns="http://www.w3.org/2000/svg">
                                <path d="m166.093 240.214h88.205v194.288h-88.205z" transform="matrix(.707 -.707 .707 .707 1.415 9.959)" />
                                <path d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z" />
                            </svg>
                        </button>
                        <button @click="toReport(item.id)" class="btn ml-0 mr-1 d-flex align-items-center justify-content-center" style="height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 492 492" style="transform: rotate(180deg); fill: white; width: 10px; height:10px; min-width: 10px; min-height:10px" xml:space="preserve">
                                <path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                        C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                        c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                        l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z" />
                            </svg>
                        </button>
                        <button @click="sendEmailReport(item)" class="btn ml-0 mr-1" data-bs-toggle="modal" data-bs-target="#mailing" style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent; color: black">
                            <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px; enable-background:new 0 0 474.624 474.624;" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 474.624 474.624" xml:space="preserve">
                                <path d="M428.544,52.736H45.568c-7.168,0-13.824,1.536-19.968,4.608l211.456,171.52l211.456-171.52
                                        C442.368,54.272,436.224,52.736,428.544,52.736z" />

                                <path d="M251.392,275.968c-4.096,3.584-9.216,5.12-14.336,5.12s-10.24-1.536-14.336-5.12L0,95.232c0,1.024,0,1.536,0,3.072V376.32
                                        c0,25.088,20.48,45.568,45.568,45.568h383.488c25.088,0,45.568-20.48,45.568-45.568V98.304c0-1.024,0-1.536,0-3.072
                                        L251.392,275.968z" />
                            </svg>
                        </button>
                        <button @click="showDeletingModal(item.id)" data-bs-toggle="modal" data-bs-target="#deleting" class="btn ml-0 mr-1" style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: green;">
                            <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />

                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mx-auto mt-2 align-items-center justify-content-center" v-if="sortedList.length==0">
        <div class="col-12">
            <div class="d-flex justify-content-center align-items-center">
                <h3 class="sdm-primary-label sdm-primary-text" style="font-size:1.375rem">Нет записей по заданным
                    параметрам</h3>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import moment from 'moment';
import Modal from "../../components/Modal";

export default {
    name: "Reports",
    props: ['dateRange', 'important', 'automatic', 'hidden', 'report_of', 'report_title', 'reports', 'users'],
    components: {
        Modal
    },
    data() {
        return {
            //sort
            currentSort: "date",
            currentSortDir: "asc",
            mailsOptions: [],
            selectedEmails: [],
            report_id: '',
            records: [],
            deleting_report_id: '',
        }
    },
    created() {
        this.users.forEach((user) => {
            this.mailsOptions.push({
                label: user.email,
                code: user.id
            })
        });
        this.reports.forEach(item => {
            this.records.push(item);
        });
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
        sortedList: function () {
            return this.filteredList.sort((a, b) => {
                let modifier = 1;
                if (this.currentSortDir === "desc") modifier = -1;
                if (a[this.currentSort] < b[this.currentSort])
                    return -1 * modifier;
                if (a[this.currentSort] > b[this.currentSort])
                    return 1 * modifier;
                return 0;
            });
        },
        filteredList() {
            return this.records.filter(item => {

                let report_title = true,
                    date = false,
                    report_of = true,
                    important = true,
                    automatic = true,
                    hidden = true;

                if (this.report_title !== "") {
                    if (item.title) {
                        report_title = item.title.toLowerCase().includes(this.report_title.toLowerCase());
                    } else {
                        report_title = false;
                    }
                }
                // if (this.report_title !== "") {
                //     if (item.title) {
                //         report_title = item.title === this.report_title;
                //     } else {
                //         report_title = false;
                //     }
                // }

                if (moment(item.created_at).isBetween(this.dateRange.startDate, this.dateRange.endDate)) {
                    date = true;
                }

                if (this.report_of !== "") {

                    if (item.report_of) {
                        report_of = item.report_of == this.report_of;

                    } else {
                        report_of = false;
                    }
                }

                if (this.important) {
                    if (!item.important) {
                        important = false;
                    }
                }
                if (this.automatic) {
                    if (!item.automatic) {
                        automatic = false;
                    }
                }
                if (!this.hidden) {
                    if (item.is_hidden) {
                        hidden = false;
                    }
                }
                return (
                    report_title &&
                    date &&
                    report_of &&
                    important &&
                    automatic &&
                    hidden
                );
            });
        }
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
        sort: function (s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        editReport(id) {
            window.location.href = `/reports/edit/${id}`;
        },
        toReport(id) {
            window.location.href = `/reports/${id}`;
        },
        sendEmailReport(report) {
            this.selectedEmails = [];
            this.mailsOptions = [];
            this.users.forEach((user) => {
                this.mailsOptions.push({
                    label: user.email,
                    code: user.id
                })
            });
            this.report_id = report.id;
            report.recipients.forEach((recipient) => {
                let removeIndex = this.mailsOptions.map(item => item.code).indexOf(recipient);
                if (removeIndex > -1) {
                    this.mailsOptions.splice(removeIndex, 1);
                }
                let userIndex = this.users.map(item => item.id).indexOf(recipient);
                if (userIndex > -1) {
                    this.selectedEmails.push({
                        label: this.users[userIndex].email,
                        code: this.users[userIndex].id
                    })
                }
            })
        },
        sendReportToEmails() {
            //todo: TRY   method for sending report to emails(?)
            let recipients = this.users.filter(recipient => {
                if (this.selectedEmails.map(item => item.code).indexOf(recipient.id) > -1) {
                    return true;
                }
            });
            let data = {
                id: this.report_id,
                recipients: recipients
            };
            axios
                .post(`/report/sendReportToEmails`, data)
                .then(resp => {
                    console.log(resp);
                    $('#mailing').modal('hide');
                    this.selectedEmails = [];
                    this.mailsOptions = [];
                    this.users.forEach((user) => {
                        this.mailsOptions.push({
                            label: user.email,
                            code: user.id
                        })
                    });
                    this.sendNotify('Вы успешно послали отчет на указанные email', 'success');
                    //this.data = resp.data.data;
                })
                .catch((error) => {
                    $('#mailing').modal('hide');
                    this.selectedEmails = [];
                    this.mailsOptions = [];
                    this.users.forEach((user) => {
                        this.mailsOptions.push({
                            label: user.email,
                            code: user.id
                        })
                    });
                    console.log(error);
                    this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                });
        },
        showDeletingModal(id) {
            this.deleting_report_id = id;
        },
        deleteReport() {
            //todo: TRY   method for deleting report
            const removeIndex = this.records.map(item => item.id).indexOf(this.deleting_report_id);
            this.records.splice(removeIndex, 1);
            axios
                .delete(`/report/${this.deleting_report_id}`)
                .then(resp => {
                    $('#deleting').modal('hide');
                    console.log(resp);
                    this.sendNotify('Вы успешно удалили отчет', 'success');
                    //this.data = resp.data.data;
                })
                .catch((error) => {
                    $('#deleting').modal('hide');
                    console.log(error);
                    this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                });
        },
        removeEmail(mail) {
            let removeIndex = this.selectedEmails.map(item => item.label).indexOf(mail.code);
            this.selectedEmails.splice(removeIndex, 1);
            this.mailsOptions.push(mail);
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
.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}

.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}

.readonly {
    color: #9d9ea5 !important;
    fill: #9d9ea5 !important;
}
</style>
