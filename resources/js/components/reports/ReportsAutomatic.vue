<template>
    <div>
        <div
            class="row mx-auto my-2 align-items-center"
            v-if="selected.length > 0"
            style="padding: 15px; border: 1px solid #dfe1ee; border-radius: 5px"
        >
            <div class="col-8">
                <div class="row w-100 mx-auto align-items-center">
                    <div
                        style="display: flex"
                        class="mr-2 mt-1"
                        :key="report.id"
                        v-for="report in selected"
                    >
                        <div class="mr-1">{{ report.title }}</div>
                        <div v-on:click="uncheck(report)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                            <svg
                                style="width: 7px; height: 7px"
                                version="1.1"
                                id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512.001 512.001"
                                xml:space="preserve"
                            >
                                <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 custom-filter" style="display: flex; align-items: center; justify-content: flex-end">
                (всего {{ selected.length }})
                <button
                    class="btn border-copy-button pt-0 pb-0 sdm-primary-underline-button"
                    v-on:click="checkAll()"
                >
                    <span>
                        Выбрать все
                    </span>
                </button>
                <button
                    class="btn mdi mdi-close"
                    v-on:click="uncheckAll()"
                    style="height:36px; width: 36px; min-width: 36px; background: transparent; color: red; font-size: 15px"
                ></button>
            </div>
        </div>
        <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-2 align-items-center justify-content-center">
            <div class="custom-filter col-3 pl-0"
                 @click="sort('title')"
                 style="cursor: pointer;"
            >
                Название отчета
                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                   v-if="currentSort == 'title'"
                   class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div class="custom-filter col-2 px-1"
                 @click="sort('recipients')"
                 style="cursor: pointer;"
            >
                Адресат
                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                   v-if="currentSort == 'recipients'"
                   class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div class="col-1 px-2"></div>
            <div class="custom-filter col px-2"
                 @click="sort('regularity')"
                 style="cursor: pointer; padding-left: 30px"
            >
                Регулярность
                <i
                    v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                    v-if="currentSort == 'regularity'"
                    class="fas fa-angle-down filter-icon"
                >
                </i>
            </div>
            <div class="custom-filter col"
                 @click="sort('period')"
                 style="cursor: pointer; display: flex;flex-wrap: nowrap; align-items: center; padding-left: 0;"
            >
                Период
                <i
                    v-bind:class="{ 'sort-icon-rotation': currentSortDir == 'asc' }"
                    v-if="currentSort == 'period'"
                    class="fas fa-angle-down filter-icon"
                >
                </i>
            </div>
            <div class="custom-filter col-2"
                 @click="sort('is_active')"
                 style="cursor: pointer; display: flex;flex-wrap: nowrap; align-items: center; padding-left: 0;"
            >
                Статус
                <i
                    v-bind:class="{ 'sort-icon-rotation': currentSortDir == 'asc' }"
                    v-if="currentSort == 'is_active'"
                    class="fas fa-angle-down filter-icon"
                >
                </i>
            </div>
            <div class="custom-filter col-1 px-1">
            </div>
        </div>
        <div class="row w-100 mx-auto align-items-center justify-content-center" v-if="sortedList.length>0">
            <div
                class="col-12 p-0"
                :key="item.id"
                v-for="(item, index) in sortedList"
            >
                <div
                    v-bind:class="{ 'checked-border': isSelected(item.id) }"
                    class="row w-100 mx-auto mb-1 py-3 px-3 align-items-center justify-content-center sdm-primary-text"
                    style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap"
                >
                    <div class="col-3 pl-0">
                        <div class="row w-100 my-1 align-items-center justify-content-start text-wrap text-break">
                            <div
                                class="form-check form-check-inline custom-menu-checkbox"
                                style="padding-left: 10px"
                            >
                                <input
                                    :id="'checkbox-' + index + 2"
                                    :name="'checkbox-' + index + 2"
                                    class="checkbox-custom"
                                    @change="check(item, item.selected)"
                                    type="checkbox"
                                    v-model="item.selected"
                                />
                                <label
                                    :id="'checkbox-' + index + 2"
                                    :for="'checkbox-' + index + 2"
                                    style="font-size:14px;"
                                    class="checkbox-custom-label"
                                ></label>
                                {{item.title}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 px-1">
                        <div class="row w-100 m-auto align-items-center text-wrap text-break" v-if="item.recipients_emails&&item.recipients_emails.length>0">
                            <span>{{item.recipients_emails[0]}}</span>
                            <span v-if="item.recipients_emails.length>1"
                                  v-popover.top="{ name: '' + item.id }"
                                  class="ml-1 mdi mdi-information d-flex" style="cursor:pointer;color: #7224f2; font-size:18px"
                            >
                            </span>
                        </div>
                        <popover
                            v-if="item.recipients_emails&&item.recipients_emails.length>1"
                            class="sdm-popover"
                            :name="'' + item.id"
                        >
                            <perfect-scrollbar>
                                <div class="row w-100 m-auto">
                                    <div class="col-12" v-for="(email, key) in item.recipients_emails" v-if="key!=0">
                                        {{email}}
                                    </div>
                                </div>
                            </perfect-scrollbar>
                        </popover>
                    </div>
                    <div class="col-12 col-md-1 px-2">
                        <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                            <div class="col-6 pl-0 pr-1">
                                <div
                                    class="mr-2 d-flex align-items-center justify-content-center sdm-icon-button"
                                    v-bind:class="{'active': item.important ==true, 'nonactive':item.important ==false}"
                                    style="border: none !important;"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512.002 512.002;" xml:space="preserve">
                                        <path fill="#dfe1ee" v-bind:class="{'readonly': item.important !=true}" d="M511.267,197.258c-1.764-5.431-6.457-9.389-12.107-10.209l-158.723-23.065L269.452,20.157
                                            c-2.526-5.12-7.741-8.361-13.45-8.361c-5.71,0-10.924,3.241-13.451,8.361l-70.988,143.827l-158.72,23.065
                                            c-5.649,0.82-10.344,4.778-12.108,10.208c-1.765,5.431-0.293,11.392,3.796,15.377l114.848,111.954L92.271,482.671
                                            c-0.966,5.628,1.348,11.314,5.967,14.671c2.613,1.898,5.708,2.864,8.818,2.864c2.388,0,4.784-0.569,6.978-1.723l141.967-74.638
                                            l141.961,74.637c5.055,2.657,11.178,2.215,15.797-1.141c4.619-3.356,6.934-9.044,5.969-14.672l-27.117-158.081l114.861-111.955
                                            C511.56,208.649,513.033,202.688,511.267,197.258z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-6 pl-1 pr-0">
                                <div
                                    v-if="item.automatic"
                                    class="mr-2 d-flex align-items-center justify-content-center sdm-icon-button"
                                    style="border-radius: 50% !important;"
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col px-2">
                        <span v-if="item.regularity == 'day'">Раз в день</span>
                        <span v-if="item.regularity == 'week'">Раз в неделю</span>
                        <span v-if="item.regularity == 'month'">Раз в месяц</span>
                        <span v-if="item.regularity == 'year'">Раз в год</span>
                    </div>
                    <div class="col px-1">
                        <span v-if="item.period == 'day'">За последние сутки</span>
                        <span v-if="item.period == 'week'">За неделю</span>
                        <span v-if="item.period == 'month'">За месяц</span>
                        <span v-if="item.period == 'year'">За год</span>
                        <span v-if="item.period == 'date-range'">Произвольный</span>
                    </div>
                    <div class="col-2">
                        <div style="width: 100px; display: flex;justify-content: space-between;align-items: center;">
                            <p class="switch-label">ВЫКЛ</p>
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    v-model="item.is_active"
                                    v-on:change="checkAutomaticReport($event.target.checked,item.id)"
                                />
                                <span class="slider round"></span>
                            </label>
                            <p class="switch-label">ВКЛ</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-1 px-1">
                        <div style="flex-wrap: nowrap; justify-content: end" class="row w-100 mx-auto my-1 align-items-center">
                            <button
                                @click="editAutomaticReport(item.id)"
                                class="btn ml-0 mr-1 d-flex align-items-center justify-content-center"
                                style="height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;"
                            >
                                <svg
                                    id="Capa_1"
                                    style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px"
                                    enable-background="new 0 0 488.471 488.471"
                                    height="512"
                                    viewBox="0 0 488.471 488.471"
                                    width="512"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="m166.093 240.214h88.205v194.288h-88.205z"
                                        transform="matrix(.707 -.707 .707 .707 1.415 9.959)"
                                    />
                                    <path
                                        d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z"
                                    />
                                </svg>
                            </button>
                            <button
                                @click="deleteAutomaticReport(item.id)"
                                class="btn ml-0 mr-1"
                                style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;"
                            >
                                <svg
                                    style="width: 14px; height: 14px; min-width: 14px; min-height: 14px"
                                    version="1.1"
                                    id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px"
                                    y="0px"
                                    viewBox="0 0 512.001 512.001"
                                    xml:space="preserve"
                                >
                                    <path
                                        fill="#d62627"
                                        d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                    />
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
                    <h3 class="sdm-primary-label sdm-primary-text" style="font-size:1.375rem">Нет записей по заданным параметрам</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReportsAutomatic",
        props: [
            "report_title",
            'period', 'important', 'automatic', 'hidden', 'report_of',
            'automatic_reports'
        ],
        data: () => ({
            // sort
            currentSort: "title",
            currentSortDir: "asc",
            selected: [],
        }),
        created() {

        },
        watch: {
            automatic_reports: {
                handler: function() {},
                deep: true,
                immediate: true,
            }
        },
        computed: {
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
                return this.automatic_reports.filter(item => {

                    let report_title = true,
                        period = true,
                        report_of = true,
                        important = true,
                        hidden = true;

           
                    if (this.report_title !== "") {
                        if (item.title) {
                            report_title = item.title.toLowerCase().includes(this.report_title.toLowerCase());
                        } else {
                            report_title = false;
                        }
                    }

                    if (this.period !== "") {
                        if (item.period) {
                            period = item.period === this.period;
                        } else {
                            period = false;
                        }
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
                    if (!this.hidden) {
                        if (item.hidden) {
                            hidden = false;
                        }
                    }

                    return (
                        report_title &&
                        period &&
                        report_of &&
                        important &&
                        hidden
                    );
                });
            }
        },
        methods:{
            sort: function (s) {
                //if s == current sort, reverse
                if (s === this.currentSort) {
                    this.currentSortDir =
                        this.currentSortDir === "asc" ? "desc" : "asc";
                }
                this.currentSort = s;
            },
            uncheck: function (report) {
                let index = this.selected.findIndex(el => el.id === report.id);
                if (index !== -1) {
                    let report_index = this.filteredList.findIndex(el => el.id === report.id);
                    this.filteredList[report_index].selected = false;
                    this.selected.splice(index, 1);
                }
            },
            checkAll: function () {
                this.selected=[];
                this.automatic_reports.forEach(report => {
                    report.selected = true;
                    this.selected.push(report);
                });
            },
            uncheckAll: function () {
                this.automatic_reports.forEach(item => {
                    item.selected = false;
                });
                this.selected = [];
            },
            check: function (item, selected) {
                let index = this.selected.findIndex(el => el.id === item.id);
                if(index !== -1)
                {
                    this.selected.splice(index, 1);
                }
                else{
                    this.selected.push(item);
                }
            },
            isSelected: function (id) {
                const index = this.selected.map(item => item.id).indexOf(id);
                return index !== -1;
            },
            editAutomaticReport(id) {
                window.location.href = `/reports/edit/${id}`;
            },
            deleteAutomaticReport(id) {
                //todo:TRY   method for deleting automatic report
                const removeIndex = this.automatic_reports.map(item => item.id).indexOf(id);
                this.automatic_reports.splice(removeIndex, 1);
                axios
                    .delete(`/report/${id}`)
                    .then(resp => {
                        console.log(resp);
                        this.sendNotify('Вы успешно удалили автоматический отчет', 'success');
                        //this.data = resp.data.data;
                    })
                    .catch((error) => {
                        console.log(resp);
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });

            },
            checkAutomaticReport: function(checked, id) {
                //todo:TRY   method to toggle active state of automatic report
                axios
                    .post(`/report/toggle/${id}`, {
                        is_active: checked
                    })
                    .then(resp => {
                        let report_index = this.automatic_reports.findIndex(el => el.id === id);
                        this.automatic_reports[report_index]= resp.data.report;
                        this.sendNotify('Вы успешно изменили состояние автоматического отчета', 'success');
                        console.log(resp);
                        //this.data = resp.data.data;
                    })
                    .catch((error) => {
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                        console.log(resp);
                    });
            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Автоматические отчеты',
                    text: notification,
                    type: type
                });
            },
            getRecipientsEmails(item) {
                let emails = [];
                    item.recipients.forEach(recipient =>{
                        let index = this.users.map(item => item.id).indexOf(recipient);
                        emails.push(this.users[index].email);
                    });
                return emails;
            },
        }
    }
</script>

<style scoped>
    .sort-icon-rotation {
        transform: rotate(180deg);
    }

    .icon-grey-border {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: solid 1px #dfe1ee;
        border-radius: 50px;
        min-width: 28px;
        margin-right: 8px;
    }

    .custom-icon {
        width: 12px;
        height: 12px;
    }

    .custom-filter {
        color: #9d9ea5;
        font-size: 12px;
    }

    .filter-icon {
        color: #7c34f2;
        margin-left: 5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 30px;
        height: 20px;
        margin-bottom: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        border: 1px solid #9d9ea5;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 11px;
        width: 11px;
        left: 4px;
        bottom: 4px;
        background-color: #9d9ea5;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    input:checked + .slider {
        background-color: white;
    }

    /*input:focus + .slider {*/
    /*    box-shadow: 0 0 1px #2196F3;*/
    /*}*/

    input:checked + .slider:before {
        -webkit-transform: translateX(10px);
        -ms-transform: translateX(10px);
        transform: translateX(10px);
        background-color: green;
    }

    input:checked + .slider {
        border: 1px solid green;
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .switch-label {
        margin-bottom: 0;
        font-size: 10px;
    }
    .sdm-popover {
        left: -96px !important;
        top: -108px !important;
        height: 120px !important;
        width: 155px !important;
        font-size: 12px;
        padding-top: 15px;
        padding-left: 15px;
        padding-bottom: 15px;
        padding-right: 0px;
    }
    .sdm-popover.dropdown-position-top::before {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #fff;
        bottom: -6px;
        left: calc(84% - 6px);
        filter: drop-shadow(0px 2px 2px rgba(52, 73, 94, 0.1));
    }
</style>
<style>
    .sdm-popover .ps {
        width: 100%;
        height: 90px;
    }
    .sdm-popover .ps .ps__rail-y {
        background: #fff !important;
        opacity: 1 !important;
        width: 3px !important;
    }
    .sdm-popover .ps .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
    .sdm-popover .ps .ps__thumb-y:hover {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
    .sdm-popover .ps .ps__rail-y:hover > .ps__thumb-y, .ps__rail-y:focus > .ps__thumb-y, .ps__rail-y.ps--clicking .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
</style>
