<template>
    <div>
        <div class="row w-100 m-auto align-items-center justify-content-center">
            <div class="col-4 pr-1">
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
                                {{ picker.startDate | moment('HH:mm:ss')}}  -
                                <span style="color: #7224f2">{{ picker.endDate | moment('DD.MM.YYYY')}}</span> {{ picker.endDate | moment('HH:mm:ss')}}
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
            <div class="col-2 px-1">
                <p class="mb-1 d-flex sdm-secondary-text">
                    Тип операции
                </p>
                <select class="form-select custom-select" v-model="operation_type">
                    <option value="" selected>
                        Все
                    </option>
                    <option value="Создание">
                        Создание
                    </option>
                    <option value="Редактирование">
                        Редактирование
                    </option>
                    <option value="Удаление">
                        Удаление
                    </option>
                    <option value="Восстановление">
                        Восстановление
                    </option>
                </select>
            </div>
            <div class="col-2 px-1"></div>
            <div class="col-2 px-1"></div>
            <div class="col-2 pl-1 h-100">
                <div
                    class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end"
                >
                    <button
                        class="btn mb-0 mt-auto float-right"
                        style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                        @click="resetFilters"
                    >
                        Сбросить
                    </button>
                </div>
            </div>
        </div>
        <div class="row w-100 m-auto" v-if="(sortedList || sortedList.length>0)&&!loading">
            <div class="col-12">
                <div
                    style="padding-bottom: 10px"
                    class="row w-100 mx-auto mt-3 align-items-center justify-content-center"
                >
                    <div class="sdm-filter col-2 pl-0" @click="sort('created_at')">
                        Дата и время
                        <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                           v-if="currentSort == 'created_at'"
                           class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-8" @click="sort('action')">
                        Тип операции
                        <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                           v-if="currentSort == 'action'"
                           class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-2" @click="sort('user')">
                        Пользователь
                        <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                           v-if="currentSort == 'user'"
                           class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                </div>
                <div
                    class="row w-100 mx-auto align-items-center justify-content-center"
                    style="font-size: 12px"
                >
                    <div
                        class="col-12 p-0"
                        :key="index"
                        v-for="(item, index) in sortedList"
                    >
                        <div
                            class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                            style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; "
                        >
                            <div class="col-12 col-md-2">
                                <span style="color:#7224f2">{{item.created_at | moment("DD.MM.YYYY")}}</span>
                                {{item.created_at | moment("HH:mm:ss")}}
                            </div>
                            <div class="col-12 col-md-8">
                                {{ item.action }}
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="row w-100 mx-auto my-1 align-items-center">
                                    <div>
                                        {{item.user.name}}
                                    </div>
                                    <button
                                        class="btn p-0 mr-2"
                                        style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                        @click="toUserPage(item.user_id)"
                                    >
                                        <svg
                                            version="1.1"
                                            id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            x="0px"
                                            y="0px"
                                            width="16px"
                                            height="15px"
                                            viewBox="0 0 612 612"
                                            style="enable-background:new 0 0 612 612; overflow:unset;"
                                            xml:space="preserve"
                                        >
                                            <path
                                                fill="#7224f2"
                                                d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
                </div>
            </div>
        </div>
        <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center mt-3">
                <div style="color:#7c34f2" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        <div class="row w-100 mx-auto my-3 align-items-center justify-content-center" v-if="(!sortedList || sortedList.length==0)&&!loading">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center">
                    <h3 class="sdm-primary-label sdm-primary-text" style="font-size:1.375rem">Нет записей</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    name: "DeviceHistory",
    props: ["device"],
    data() {
        let startDate = new Date();
        let endDate = new Date();
        startDate.setDate(startDate.getDate() - 6);
        return {
            data: [],
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
            //sort
            currentSort: "created_at",
            currentSortDir: "asc",
            operation_type:'',
            loading:false,
        };
    },
    created() {
        this.getData();
    },
    computed: {
        sortedList: function () {
            return this.data.sort((a, b) => {
                let modifier = 1;
                if (this.currentSortDir === "desc") modifier = -1;
                if(this.currentSort == 'user') {
                    if (a.user.name < b.user.name)
                        return -1 * modifier;
                    if (a.user.name > b.user.name)
                        return 1 * modifier;
                }
                else {
                    if (a[this.currentSort] < b[this.currentSort])
                        return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort])
                        return 1 * modifier;
                }

                return 0;
            });
        },
        filteredList() {
            return this.data.filter(item => {
                let operation_type = true,
                    date = false;

                if (this.operation_type !== "") {
                    operation_type =
                        item.action === this.operation_type;
                }

                if (
                    moment(item.created_at).isBetween(
                        this.dateRange.startDate,
                        this.dateRange.endDate, undefined, '[]'
                    )
                ) {
                    date = true;
                }

                return operation_type && date;
            });
        },
    },
    watch: {
            operation_type: {
                handler: function () {
                    this.getData()
                }
            },
            dateRange: {
                handler: function () {
                    this.getData()
                },
                deep: true
            }
        },
    methods: {
        getData(page = 1) {
                this.loading = true;
                axios
                    .get("/history?page=" + page, {
                        params: {
                            operation_type: this.operation_type,
                            object_type: 4,
                            object_id: this.device.id,
                            object_type_id: 4,
                            start_date: this.dateRange.startDate,
                            end_date: this.dateRange.endDate
                        }
                    })
                    .then(resp => {
                        //console.log(resp.data.data);
                        this.loading = false;
                        this.data = resp.data.data;
                        this.laravelData = resp.data;
                    })
                    .catch((resp) => {
                        this.loading = false;
                        console.log(resp);
                    });
            },
        rangeText(range) {
            let text = range.split(' - ');
            text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
            return text;
        },
        sort: function (s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        toUserPage(id) {
            window.location.href = "/users/" + id;
        },
        resetFilters() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(endDate.getDate() - 6);
            this.dateRange = { startDate, endDate };

        },
        sendNotify(notification, type='primary') {
            this.$notify({
                title: 'История операций устройства',
                text: notification,
                type:type
            });
        }
    },
};
</script>

<style>
.reportrange-text {
    background: transparent !important;
    border: 1px solid #dfe1ee !important;
    width: 100% !important;
    line-height: 1.5 !important;
    height: calc(1.6em + 0.75rem + 2px) !important;
    font-size: 12px !important;
}
</style>
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
.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}
.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}
.custom-select {
    color: black;
    font-weight: 500;
    font-size: 12px;
    border-color: #dfe1ee;
}
</style>
