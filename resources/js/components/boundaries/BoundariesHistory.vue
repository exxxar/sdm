<template>
    <div>
        <div class="row w-100 m-auto align-items-center justify-content-center">
            <div class="col-4 pr-1">
                <p
                    class="mb-1 d-flex sdm-secondary-text"
                >
                    Период операций
                </p>
                <daterange-picker
                    ref="picker"
                    :opens="'center'"
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
                                    <button @click="header.clickCancel"
                                            class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                            <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                                Сбросить
                                            </span>
                                    </button>
                                    <button @click="header.clickApply"
                                            class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                            <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                                Подтвердить
                                            </span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12" style="border-top: 1px solid #ced4da">
                                <div class="sdm-primary-text py-3 px-2">Выбранный период: <span style="color:#7224f2">{{header.rangeText}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-slot:input="picker" style="min-width: 350px;">
                        <div class="row w-100 m-auto align-items-center justify-content-center">
                            <div class="col-10 p-0" style="font-size: 10px">
                                <span style="color: #7224f2">{{ picker.startDate | moment('DD.MM.YYYY')}}</span>
                                {{ picker.startDate | moment('HH:mm:ss')}} -
                                <span style="color: #7224f2">{{ picker.endDate | moment('DD.MM.YYYY')}}</span> {{
                                picker.endDate | moment('HH:mm:ss')}}
                            </div>
                            <div class="col-2 pr-0">
                                <i class="float-right far fa-calendar" style="font-size:15px; color:#7224f2"></i>
                            </div>
                        </div>
                    </template>
                    <div slot="footer" slot-scope="data" class="slot">
                    </div>
                </daterange-picker>
            </div>
            <div class="col-2 px-1">
                <p
                    class="mb-1 d-flex"
                    style="font-size: 9px; color: #959597; font-weight: 400"
                >
                    Тип операции
                </p>
                <select class="form-select custom-select" v-model="action_type">
                    <option value="" selected>
                        Все
                    </option>
                    <option>
                        Создание
                    </option>
                    <option>
                        Редактирование
                    </option>
                    <option>
                        Удаление
                    </option>
                </select>
            </div>
            <div class="col-2 px-1">
            </div>
            <div class="col-2 px-1">
            </div>
            <div class="col-2 pl-1 h-100">
                <div class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end">
                    <button class="btn mb-0 mt-auto float-right"
                            style="background:#dfe0f0; color:#7224f2; font-size: 12px">Сбросить
                    </button>
                </div>
            </div>
        </div>
        <div class="row w-100 m-auto">
            <div class="col-12">
                <div style="padding-bottom: 10px"
                     class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
                    <div class="custom-filter col-2 pl-0" @click="sort('created_at')">Дата и время
                        <i class="fas fa-angle-down filter-icon"
                           v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                           v-if="currentSort == 'created_at'"></i>
                    </div>
                    <div class="custom-filter col-8" @click="sort('action')">Тип операции<i
                        class="fas fa-angle-down filter-icon"
                        v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                        v-if="currentSort == 'action'"
                    ></i>
                    </div>
                    <div class="custom-filter col-2" @click="sort('user.name')">Пользователь
                        <i class="fas fa-angle-down filter-icon"
                           v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                           v-if="currentSort == 'user.name'"
                        ></i>
                    </div>
                </div>
                <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center">
                    <div style="color:#7c34f2" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div v-if="!loading" class="row w-100 mx-auto align-items-center justify-content-center" style="font-size: 12px">
                    <div class="col-12 p-0" :key="index"
                         v-for="(item, index) in sortedList">
                        <div class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                             style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; ">
                            <div class="d-none col-12 col-md-2">
                                <span style="color:#7224f2">14.12.2020</span> 08:06:54
                            </div>
                            <div class="col-12 col-md-2">
                                {{item.created_at}}
                            </div>
                            <div class="col-12 col-md-8">
                                {{item.action}}
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="row w-100 mx-auto my-1 align-items-center">
                                    <div>
                                        {{item.user.name}}
                                    </div>
                                    <button class="btn p-1 mr-2 mdi mdi-arrow-right-circle-outline"
                                            style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2; font-size: 15px">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        name: "DeviceHistory",
        props: ['boundary'],

        created() {
            this.getData();
        },
        computed: {
            sortedList: function () {

                if (this.currentSort === 'user.name')
                    return this.filteredList.sort((a, b) => {
                        let modifier = 1;
                        if (this.currentSortDir === "desc") modifier = -1;
                        if (a.user.name < b.user.name)
                            return -1 * modifier;
                        if (a.user.name > b.user.name)
                            return 1 * modifier;
                        return 0;
                    });

                return this.data.sort((a, b) => {

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
                return this.data.filter(item => {
                    let action = true;
                    if (this.action_type != '') {
                        if (item.action) {
                            action = item.action === this.action_type

                        } else {
                            action = false;
                        }

                    }

                    return action;

                })
            }
        },
        watch: {
            action_type: {
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
                            operation_type: this.action_type,
                            object_type: 1,
                            object_id: this.boundary.id,
                            object_type_id: 1,
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
            sort: function (s) {
                //if s == current sort, reverse
                if (s === this.currentSort) {
                    this.currentSortDir =
                        this.currentSortDir === "asc" ? "desc" : "asc";
                }
                this.currentSort = s;
            },
        },
        data() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(startDate.getDate() - 6);
            return {
                loading: false,
                currentSort: "created_at",
                currentSortDir: "asc",
                data: [],
                laravelData: {},
                dateRange: {startDate, endDate},
                action_type: '',
                local_data: {
                    format: moment().format('DD MMMM YYYY HH:mm'),
                    separator: ' - ',
                    applyLabel: 'Подтвердить',
                    cancelLabel: 'Сбросить',
                    daysOfWeek: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
                    monthNames: ['Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
                    firstDay: 1
                }
            }
        }
    }
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
        font-weight: 400
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
        border-color: #dfe1ee
    }
</style>
