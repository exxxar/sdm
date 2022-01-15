<template>
    <div class="boundaries-schedule">


        <div class="table100 ver1">
            <div v-if="!preloader">
                <div class="table100-firstcol shadow-table100-firstcol">
                    <!--                    this table only for test data-->
                    <table>
                        <thead>
                        <tr class="row100 head">
                            <th class="column1">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="row100 body" v-for="day in dates">
                            <td class="column1">{{day | moment("DD-MM-YYYY") }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <perfect-scrollbar>
                    <div class="wrap-table100-nextcols">
                        <div class="table100-nextcols">
                            <table>
                                <thead>
                                <tr class="row100 head">
                                    <th class="cell100 " v-for="boundary in boundaries">

                                        <div class="d-flex flex-nowrap w-100 justify-content-center">
                                            <p class="simple-title">{{boundary.title}}</p>
                                            <a :href="`/boundaries/edit/${boundary.id}`">
                                                <i
                                                    style="padding:3px 3px 3px 4px; color: #7224f2;border: 1px solid #7c34f2; border-radius: 50px;width: 17px;height: 17px;"
                                                    class="fas fa-arrow-right filter-icon fa-xs"
                                                >
                                                </i>
                                            </a>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="row100 body" v-for="(row, row_index) in table">
                                    <td class="cell100"
                                        @click="editItem(col, row_index, col_index)"
                                        v-bind:class="{'border-success':col.success_update|false,
                                    'border-danger':col.error_update|false
                                    }"
                                        v-for="(col, col_index) in row">
                                        <div class="row w-100 m-auto align-items-center justify-content-start">
                                            <div class="col-12 p-0 text-truncate" v-if="col.is_installed">
                                                {{col.start_at | moment("HH:mm")}} -
                                                {{col.end_at | moment("HH:mm")}}


                                            </div>
                                            <div class="col-12 p-0 text-truncate">

                                            <span
                                                v-if="!col.is_installed">  Не выставлялся</span>
                                                <span v-else>{{col.address}}</span>


                                            </div>

                                            <popover
                                                v-if="col.is_installed"
                                                class="sdm-popover"
                                                :name="'shd'+col.id+col.boundary_id"
                                            >
                                                <perfect-scrollbar>
                                                    <div
                                                        class="row w-100 m-auto align-items-center justify-content-start text-left">
                                                        <div class="col-12 p-0 text-truncate">
                                                            <span>{{col.start_at }} - {{col.end_at}}</span>
                                                        </div>
                                                        <div class="col-12 p-0">
                                                            <a :href="`/boundaries/edit/${col.boundary.id}`"
                                                               class="sdm-primary-text"
                                                               style="color:black;text-decoration: none;word-wrap: anywhere;">
                                                                {{ col.address}}
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
                                                            </a>
                                                        </div>
                                                        <div class="col-6 p-0 text-truncate">
                                                            <p class="mb-1 d-flex sdm-secondary-text">
                                                                Кол-во проездов
                                                            </p>
                                                            <span
                                                                style="color:#6917f1;">{{col.boundary.passages}}</span>
                                                        </div>
                                                        <div class="col-6 p-0 text-truncate">
                                                            <p class="mb-1 d-flex sdm-secondary-text">
                                                                Кол-во нарушений
                                                            </p>
                                                            <span style="color:#d62627 !important;">{{col.boundary.violations}}</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="row w-100 mt-2 mx-auto align-items-center justify-content-start text-left">
                                                        <button
                                                            type="button"
                                                            class="btn report-btn btn-dark px-3 py-2"

                                                        >
                                                            Создать отчет
                                                        </button>
                                                    </div>
                                                </perfect-scrollbar>
                                            </popover>
                                        </div>

                                    </td>

                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </perfect-scrollbar>
            </div>
            <div class="w-100 d-flex justify-content-center" v-if="preloader">
                <img src="/preloader.gif" class="preloader" alt="">
            </div>

        </div>


        <modal id="add-new-scheduler" v-if="filter.selected_boundary">
            <template v-slot:header>
                Единичное удаление задачи
            </template>
            <template v-slot:main>


                <form v-on:submit.prevent="addNewItem()">
                    <h6 class="w-100 text-center" required>Изменить расписание у рубежа №
                        {{filter.selected_boundary.id}}</h6>

                    <div class="row mb-2" v-if="filter.selected_boundary">
                        <div class="col-12">
                            <p>Рубеж</p>
                            <p>{{filter.selected_boundary.title}}</p>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Дата установки</p>
                            <p>{{new_item.day | moment("DD-MM-YYYY") }}</p>
                        </div>
                    </div>

                    <div class="row mb-2" v-if="new_item.is_installed">
                        <div class="col-6">
                            <p>Время установки</p>
                            <input type="time" v-mask="'##:##'" class="form-control" v-model="new_item.start_time"
                                   required>
                        </div>
                        <div class="col-6">
                            <p>Время окончания</p>
                            <input type="time" v-mask="'##:##'" class="form-control" v-model="new_item.end_time"
                                   required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <p>Статус установки</p>
                            <div class="d-flex mt-2">

                                <label class="switch mr-2 ml-2">
                                    <input type="checkbox" id="installed" v-model="new_item.is_installed" required>
                                    <span class="slider round"></span>
                                </label>
                                <label for="installed" v-if="!new_item.is_installed">Не устанавливался</label>
                                <label for="installed" v-else>Устанавливался</label>
                            </div>


                        </div>
                    </div>


                    <div class="row mb-2" v-if="new_item.is_installed">
                        <div class="col-12">
                            <p>Адрес установки</p>
                            <input type="text" class="form-control" v-model="new_item.address" required>
                        </div>
                    </div>


                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <button class="btn w-100 btn-dark my-1 mr-1 py-2"
                                    type="submit"
                                    style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                                Обновить
                            </button>
                        </div>
                    </div>

                </form>

            </template>
        </modal>
    </div>
</template>

<script>
    import Modal from "../../components/Modal";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import moment from 'moment';


    export default {
        name: "BoundariesScheldueMoveable",
        components: {
            Modal, DatePicker
        },
        data() {
            return {
                filter: {
                    selected_boundary: null,
                },
                preloader: true,
                dates: [],
                table: [],
                is_edited: false,
                currentSortDir: "asc",
                boundaries: [],
                boundary_schedule: [],
                new_item: {
                    row_index: null,
                    col_index: null,
                    date: null,
                    boundary_id: null,
                    is_installed: false,
                    address: '',
                    type: 1,
                    start_time: null,
                    end_time: null,
                    start_time_h: null,
                    start_time_m: null,
                    end_time_h: null,
                    end_time_m: null
                }
            }
        },
        mounted() {

            window.eventBus.$on("scheduleMovableFilterEvent", (data) => {
                this.preloader = true

                if (!data)
                    this.uploadData()
                else {
                    let device = data.selected_device ? data.selected_device.code : null
                    let device_group = data.selected_device_group ? data.selected_device_group.code : null
                    let boundary = data.selected_boundary ? data.selected_boundary.code : null

                    axios.post('/boundary-schedule/filtered/movable', {
                        "start_date": data.start_date,
                        "end_date": data.end_date,
                        "devices": device == null ? [] : [device],
                        "device_groups": device_group == null ? [] : [device_group],
                        "boundaries": boundary == null ? [] : [boundary]
                    }).then(resp => {


                        this.table = resp.data.table
                        this.boundaries = resp.data.boundaries
                        this.dates = resp.data.dates

                        this.preloader = false
                    })
                }

            })

            this.preloader = true
            this.uploadData();
        },
        computed: {},
        methods: {
            goToReports(item) {

                if (item.boundary != null)
                    localStorage.setItem("report", JSON.stringify({
                        type: 3,
                        boundary: item.boundary,
                    }));
                else if (item.device != null)
                    localStorage.setItem("report", JSON.stringify({
                        type: 1,
                        device: item.device,
                        user: null
                    }));
                window.location.href = "/reports/add"

            },

            editItem(item, row_index, col_index) {

                this.filter.selected_boundary = item.boundary

                this.is_edited = true
                this.new_item.id = item.id

                this.new_item.row_index = row_index
                this.new_item.col_index = col_index
                //this.new_item.date = new Date(item.date)
                this.new_item.boundary_id = item.boundary.id
                this.new_item.address = item.address
                this.new_item.type = item.type
                this.new_item.day = item.day
                this.new_item.start_time_h = (new Date(item.start_at)).getHours()
                this.new_item.start_time_m = (new Date(item.start_at)).getMinutes()
                this.new_item.end_time_h = (new Date(item.end_at)).getHours()
                this.new_item.end_time_m = (new Date(item.end_at)).getMinutes()
                this.new_item.is_installed = item.is_installed ? true : false


                $('#add-new-scheduler').modal('show')

            },
            addNewItem() {


                this.new_item.start_time_h = this.new_item.start_time.split(':')[0]
                this.new_item.start_time_m = this.new_item.start_time.split(':')[1]
                this.new_item.end_time_h = this.new_item.end_time.split(':')[0]
                this.new_item.end_time_m = this.new_item.end_time.split(':')[1]

                this.sendNotify("Добавляем новую дату для рубежа", "success")
                $('#add-new-scheduler').modal('hide')


                axios.put(`/boundary-schedule/${this.new_item.id}`, this.new_item).then(resp => {


                    this.table[this.new_item.row_index][this.new_item.col_index].start_at = this.new_item.start_time
                    this.table[this.new_item.row_index][this.new_item.col_index].end_at = this.new_item.end_time
                    this.table[this.new_item.row_index][this.new_item.col_index].address = this.new_item.address

                    this.table[this.new_item.row_index][this.new_item.col_index].is_installed = this.new_item.is_installed
                    this.table[this.new_item.row_index][this.new_item.col_index].success_update = true

                }).catch(() => {
                    this.table[this.new_item.row_index][this.new_item.col_index].error_update = true
                })


            },

            uploadData() {
                axios.get('/boundary-schedule').then(resp => {
                    this.table = resp.data.table
                    this.boundaries = resp.data.boundaries
                    this.dates = resp.data.dates

                    this.preloader = false
                })
            },

            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Обращения',
                    text: notification,
                    type: type
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

    .report-btn {
        height: 36px;
        background: #448d3b;
        border: none;
        color: white;
        font-size: 11px;
        font-weight: 500;
    }

    .error-cell-border {
        border-color: red !important;
    }

    .error-cell-background {
        background: red !important;
        color: white !important;
    }

    .green-cell-border {
        border-color: #458d3c !important;
    }

    .green-cell-border span {
        color: #458d3c !important;
    }

    .blue-cell-border {
        border-color: #050c42 !important;
    }

    .blue-cell-border span {
        color: #7c34f2 !important;
    }

    .primary-cell-background {
        background: #7c34f2 !important;
        color: white !important;
    }

    .table100 {
        background-color: #fff
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th, td {
        font-weight: unset;
        padding-right: 10px
    }

    .column1 {
        width: 100%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .head .cell100 {
        width: 140px;
        padding: 10px !important;
    }

    .cell100 {
        width: 140px;
        padding: 5px 10px !important;
        position: relative;
    }

    .table100 th {
        padding-top: 20px;
        padding-bottom: 20px
    }

    .table100 td {
        padding-top: 14px;
        padding-bottom: 15px
    }

    .table100 {
        width: 100%;
        position: relative
    }

    td.cell100 {
        height: 50px !important;
    }

    .table100-firstcol {
        background-color: #fff;
        position: absolute;
        z-index: 1;
        width: 140px;
        top: 0;
        left: 0;
        text-align: center;
    }

    .table100-firstcol th, .table100-lastcol th {
        position: sticky;
        top: 0;
        background: #050c42;
        color: white;
        border: 1px solid #050c42;
    }

    .table100-firstcol td, .table100-lastcol td {
        position: sticky;
        background: #dfe1ee;
        color: black;
        border: 1px solid white;
    }

    .table100-firstcol table {
        background-color: #fff
    }

    .wrap-table100-nextcols {
        padding-top: 20px;
    }

    .table100-nextcols table {
        table-layout: fixed;
        text-align: center;
    }

    .shadow-table100-firstcol {
        box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
        -moz-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
        -webkit-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
        -o-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
        -ms-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    }

    .table100.ver1 th {
        font-family: Montserrat;
        font-size: 12px;
        color: white;
        line-height: 1.4;
    }

    .table100-nextcols th {
        font-family: Montserrat;
        font-size: 12px;
        color: black !important;
        background: #dfe1ee;
    }

    .table100-lastcols table td {
        width: 100px !important;
    }

    .table100.ver1 td {
        font-family: Montserrat;
        font-size: 12px;
    }

    .table100.ver1 .table100-firstcol td {
        color: #000
    }

    .table100.ver1 .table100-nextcols th {
        border: 1px solid white;
    }

    .table100.ver1 .table100-nextcols td {
        border: 1px solid #dfe1ee;
        color: #000;
        background: white;
    }

    .table100.ver1 tr {
        border-bottom: 1px solid #dfe1ee;
    }

    .boundaries-schedule .sdm-popover {
        left: 0px !important;
        top: -153px !important;
        height: 150px !important;
        width: 220px !important;
        font-size: 12px;
        padding-top: 15px;
        padding-left: 15px;
        padding-bottom: 15px;
        padding-right: 0px;
    }

    .boundaries-schedule .sdm-popover.dropdown-position-top::before {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #fff;
        bottom: -6px;
        left: calc(9% - 6px);
        filter: drop-shadow(0px 2px 2px rgba(52, 73, 94, 0.1));
    }
</style>
<style>
    .boundaries-schedule .ps {
        width: 100%;
        overflow: hidden;
        padding-left: 140px;
        background: #7224f2 !important;
    }

    .boundaries-schedule .ps__rail-x {
        width: 100%;
        top: 0px !important;
        height: 20px !important;
        margin-left: 140px !important;
        background: #7224f2 !important;
        opacity: 1 !important;
    }

    .boundaries-schedule .ps__thumb-x {
        background-color: #fff;
        height: 10px;
        bottom: 5px;
    }

    .boundaries-schedule .ps__thumb-x:hover {
        background-color: #fff;
        height: 10px;
        bottom: 5px;
    }

    .boundaries-schedule .ps__rail-x:hover > .ps__thumb-x, .ps__rail-x:focus > .ps__thumb-x, .ps__rail-x.ps--clicking .ps__thumb-x {
        background-color: #fff;
        height: 10px;
    }

    .boundaries-schedule .sdm-popover .ps {
        width: 100%;
        height: 120px;
        padding-left: 0px !important;
        background: #fff !important;
    }

    .boundaries-schedule .sdm-popover .ps .ps__rail-y {
        background: #fff !important;
        opacity: 1 !important;
        width: 3px !important;
    }

    .boundaries-schedule .sdm-popover .ps .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }

    .boundaries-schedule .sdm-popover .ps .ps__thumb-y:hover {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }

    .boundaries-schedule .sdm-popover .ps .ps__rail-y:hover > .ps__thumb-y, .ps__rail-y:focus > .ps__thumb-y, .ps__rail-y.ps--clicking .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
</style>
