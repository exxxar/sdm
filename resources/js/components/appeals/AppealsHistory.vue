<template>
    <div class="row w-100 m-auto">
        <div class="col-12 p-0">
            <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
                <div class="sdm-filter col-3"
                     @click="sort('id')"
                >
                    Номер обращения
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'id'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </div>
                <div class="sdm-filter col-3"
                     @click="sort('boundary_id')"
                >
                    Рубеж
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'boundary_id'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </div>
                <div class="sdm-filter col-2"
                     @click="sort('device_id')"
                >
                    Устройство
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'device_id'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </div>
                <div class="sdm-filter col-2"
                     @click="sort('malfunction_id')"
                >
                    Неисправность
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'malfunction_id'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </div>
                <div class="sdm-filter col-2"
                     @click="sort('created_at')"
                >
                    Дата создания
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'created_at'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </div>
            </div>
            <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center">
                    <div style="color:#7c34f2" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            <div v-if="!loading" class="row w-100 mx-auto align-items-center justify-content-center" style="font-size: 12px">
                <div class="col-12 p-0" :key="index" v-for="(item, index) in sortedList">
                    <div class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                         style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; ">
                        <div class="col-12 col-md-2">
                            <div class="row w-100 mx-auto my-1 align-items-center">
                                <div>
                                    {{item.id}}
                                </div>
                                <button class="btn p-0 mr-2"
                                        style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                        @click="toTask(item.id)"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                        <g id="_x35__2_">
                                            <g>
                                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row w-100 mx-auto my-1 align-items-center flex-nowrap" v-if="item.boundary != null">
                                <div @click="toBoundary(item.boundary.id)">
                                    {{item.boundary.title}}
                                </div>
                                <button class="btn p-0 mr-2"
                                        style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                        @click="toBoundary(item.boundary.id)"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                            <g id="_x35__2_">
                                                <g>
                                                    <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                                </g>
                                            </g>
                                        </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="row w-100 mx-auto my-1 align-items-center flex-nowrap" v-if="item.device != null">
                                <div @click="toDevice(item.device.id)">
                                   {{item.device.serial}}
                                </div>
                                <button class="btn p-0 mr-2"
                                        style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                        @click="toDevice(item.device.id)"
                                >
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                         y="0px"
                                         width="16px" height="15px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                        <g id="_x35__2_">
                                            <g>
                                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <span v-if="item.malfunction != null">{{item.malfunction.title}}</span>
                        </div>
                        <div class="col-12 col-md-2">
                            {{item.created_at | moment('DD MMMM YYYY')}}
                        </div>
                    </div>
                </div>
                <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "AppealsHistory",
        props:[
            "boundary", "malfunction","device", "dateRange", "appeal_number"
        ],
        data: () => ({
            //sort
            currentSort: "id",
            currentSortDir: "asc",
            appeals: [],
            laravelData: {},
            loading: false
        }),
        mounted() {
            this.getData();
        },
        computed: {
            sortedList: function () {
                return this.appeals.sort((a, b) => {
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
                return this.appeals.filter(item => {
                    let boundary = true, malfunction = true, date = false, appeal_number = true, device = true;

                    if(item.boundary != null) {
                        if (this.boundary !== "") {
                            boundary = item.boundary.id === this.boundary
                        }
                    }
                    if (this.appeal_number !== "") {
                        if (item.id) {
                            appeal_number = item.id.toString().includes(this.appeal_number.toString())
                        } else {
                            appeal_number = false
                        }
                    }
                    if(item.boundary != null) {
                        if (this.boundary !== "") {
                            boundary = item.boundary.id === this.boundary
                        }
                    }
                    if (this.device !== "") {
                            boundary = item.device_id === this.device
                    }
                    
                    if(item.malfunction != null) {
                        if (this.malfunction !== "") {
                            malfunction = item.malfunction.id === this.malfunction
                        }
                    }

                    if( moment(item.created_at).isBetween(this.dateRange.startDate, this.dateRange.endDate)){
                        date = true
                    }

                    return boundary && malfunction && date && appeal_number;
                })
            },
        },
        watch: {
            boundary: {
                handler: function () {
                    this.getData()
                }
            },
            device: {
                handler: function () {
                    this.getData()
                }
            },
            malfunction: {
                handler: function () {
                    this.getData()
                }
            },
            appeal_number: {
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
                    .get("/task?page=" + page, {
                        params: {
                            boundary_id: this.boundary,
                            start_date: this.dateRange.startDate,
                            end_date: this.dateRange.endDate,
                            device_id: this.device,
                            malfunction: this.malfunction,
                            task_id: this.appeal_number,
                            deleted: 1,
                            actual: 1,
                            ready: 1
                            /*
                            boundary: this.boundary,
                            malfunction: this.malfunction,
                            direction: this.show_first == "Актуальные" ? "asc" : "desc"*/
                        }
                    })
                    .then((resp) => {
                        this.loading = false;
                        this.appeals = resp.data.data;
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
            toDevice(id) {
                window.location.href = "/devices/"+id;
            },
            toBoundary(id){
                window.location.href = "/boundaries/edit/"+id;
            },
            toTask(id) {
                window.location.href = "/tasks/"+id;
            }
        }
    }
</script>

<style scoped>
    .sdm-primary-text{
        font-family: Montserrat;
        font-size:12px;
        font-weight:500;
    }
    .sdm-secondary-text{
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
        font-family: Montserrat;
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
    .sdm-filter {
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
