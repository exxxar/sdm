<template>
    <div>
        <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
            <div
                class="custom-filter col-4 pl-0"

                style="cursor: pointer;"
            >
                <p @click="sort('title')">
                    Название рубежа <span v-if="sortedList">({{sortedList.length}})</span>
                    <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                       v-if="currentSort == 'title'"
                       class="fas fa-angle-down filter-icon"
                    ></i>
                </p>
                <input type="search" class="form-control" v-model="search_title" placeholder="Быстрый поиск">
            </div>
            <div
                class="custom-filter col-3"
                @click="sort('devices_count')"
                style="cursor: pointer;"
            >
                Устройства
                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                   v-if="currentSort == 'devices_count'"
                   class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div
                @click="sort('created_at')"
                style="cursor: pointer;"
                class="custom-filter col px-1"
            >
                Дата установки
                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                   v-if="currentSort == 'created_at'"
                   class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div
                @click="sort('deleted_at')"
                style="cursor: pointer;"
                class="custom-filter col px-1"
            >
                Дата удаления
                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                   v-if="currentSort == 'deleted_at'"
                   class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div style="cursor: pointer;" class="custom-filter col-2">
            </div>
        </div>
        <div class="row w-100 mx-auto align-items-center justify-content-center">
            <div
                v-if="!preloader"
                class="col-12 p-0"
                :key="item.id"
                v-for="(item, index) in sortedList"
            >
                <div class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center"
                     style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap"
                >
                    <div class="col-12 col-md-4">
                        <div class="row w-100 my-1 ml-1 align-items-center justify-content-start">
                            <div v-on:click="editBoundary(item.id)" class="serial-number">
                                {{ item.title }}
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
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3"
                         style="display: flex; align-items: center; justify-content: space-between;padding-right: 10px;">
                        <div class="row w-100 m-auto align-items-center">
                            <div class="col-5 px-1 sdm-primary-text"
                                 :key="device.id"
                                 v-for="(device, deviceIndex) in item.devices"
                                 v-if="deviceIndex < 2"
                            >
                                <a :href="'/devices/'+ device.id" class="sdm-primary-text"
                                   style="color:black;text-decoration: none;word-wrap: anywhere;">
                                    {{ device.serial}}
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
                            <div class="col-2 pl-1">
                                <popover
                                    v-if="item.devices.length > 2"
                                    class="sdm-popover"
                                    :name="'' + item.id"
                                >
                                    <perfect-scrollbar>
                                        <div
                                            :key="device.id"
                                            v-for="(device, deviceIndex) in item.devices"
                                            v-if="deviceIndex > 1"
                                            class="mb-1 text-truncate" style="max-width: 135px"
                                        >
                                            <a :href="'/devices/'+ device.id" class="sdm-primary-text"
                                               style="color:black;text-decoration: none;">
                                                {{ device.serial}}
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
                                    </perfect-scrollbar>
                                </popover>
                                <button
                                    v-if="item.devices!=null && item.devices!=undefined && item.devices.length > 2"
                                    v-popover.top="{ name: '' + item.id }"
                                    type="button"
                                    class="btn"
                                    style="background:transparent; color: #7c34f2;font-size: 17px;"
                                >
                                    <svg
                                        version="1.1"
                                        id="Capa_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        width="13px"
                                        height="13px"
                                        viewBox="0 0 375.636 375.635"
                                        xml:space="preserve"
                                        style="fill:#7c34f2;cursor:pointer;min-width:13px"
                                    >
                                        <path d="M41.013,228.825C18.396,228.825,0,210.438,0,187.818c0-22.608,18.396-41.007,41.013-41.007
                                            c22.617,0,41.013,18.398,41.013,41.007C82.025,210.438,63.63,228.825,41.013,228.825z"/>

                                        <path d="M185.513,228.825c-22.617,0-41.013-18.387-41.013-41.007c0-22.608,18.396-41.007,41.013-41.007
                                            c22.613,0,41.013,18.398,41.013,41.007C226.525,210.438,208.126,228.825,185.513,228.825z"/>

                                        <path d="M334.623,228.825c-22.613,0-41.013-18.387-41.013-41.007c0-22.608,18.399-41.007,41.013-41.007
                                            c22.614,0,41.013,18.398,41.013,41.007C375.636,210.438,357.237,228.825,334.623,228.825z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col px-1">
                        {{(item.install_date||item.created_at ) | moment('DD.MM.YYYY')}}
                    </div>
                    <div class="col px-1">
                        <span v-if="(item.uninstall_date||item.deleted_at )!=null">{{(item.uninstall_date||item.deleted_at ) | moment('DD.MM.YYYY')}}</span>
                        <span v-if="(item.uninstall_date||item.deleted_at )==null">Не задано</span>
                    </div>
                    <div class="col-12 col-md-2" style="display: flex; align-items: center">
                        <div style="flex-wrap: nowrap; justify-content: end"
                             class="row w-100 mx-auto my-1 align-items-center">
                            <div style="display: flex" class="mr-2">
                                <button
                                    class="btn mr-2"
                                    v-on:click="editBoundary(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF"
                                >
                                    <svg
                                        version="1.1"
                                        id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 492 492"
                                        style="transform: rotate(180deg); fill: white; width: 10px; height:10px; min-width: 10px; min-height:10px"
                                        xml:space="preserve"
                                    >
                                        <path
                                            d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                        C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                        c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                        l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"
                                        />

                                    </svg>
                                </button>
                                <div
                                    style="display: flex;align-items: center; width: 116px; justify-content: center;"
                                    v-if="item.deleted_at"
                                >
                                    <p style="font-size: 14px; color: red; margin-bottom: 0">
                                        Удалено
                                    </p>
                                </div>
                                <button
                                    v-if="!item.deleted_at"
                                    class="btn"
                                    v-on:click="editBoundary(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;"
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
                                    v-if="!item.deleted_at"
                                    class="btn"
                                    v-on:click="deleteBoundary(item.id)"
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
                                            fill="red"
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

            <div class="col-12 d-flex justify-content-center" v-if="preloader">
                <img src="/preloader.gif" class="preloader" alt="">
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "BoundariesScheduleStatic",
        data: () => ({
            search_title: null,
            preloader: true,
            boundaries: [],
            currentSort: "title",
            currentSortDir: "asc",
        }),
        computed: {
            filteredList: function(){
                return this.search_title?this.boundaries.filter(item=>item.title.indexOf(this.search_title)!=-1):this.boundaries
            },
            sortedList: function () {
                if (!this.filteredList)
                    return [];

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
            editBoundary(id) {
                window.location.href = `/boundaries/edit/${id}`;
            },
            deleteBoundary(id) {
                const removeIndex = this.boundaries.map(item => item.id).indexOf(id);
                //console.log(id)
                this.boundaries.splice(removeIndex, 1);
                axios
                    .delete(`/boundary/${id}`)
                    .then(resp => {
                        console.log(resp);
                        this.sendNotify('Вы успешно удалили рубеж', 'success');
                        //this.data = resp.data.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });
            },

            uploadData() {
                axios.get('/boundary-schedule/static').then(resp => {

                    this.boundaries = resp.data.data

                    console.log(resp)

                    this.preloader = false
                })
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Расписание рубежей',
                    text: notification,
                    type: type
                });
            }
        },
        mounted() {

            window.eventBus.$on("scheduleStaticFilterEvent", (data) => {
                this.preloader = true

                if (!data)
                    this.uploadData()
                else {
                    let device = data.selected_device ? data.selected_device.code : null
                    let device_group = data.selected_device_group ? data.selected_device_group.code : null
                    let boundary = data.selected_boundary ? data.selected_boundary.code : null

                    axios.post('/boundary-schedule/filtered/static', {
                        "start_date": data.start_date,
                        "end_date": data.end_date,
                        "devices": device == null ? [] : [device],
                        "device_groups": device_group == null ? [] : [device_group],
                        "boundaries": boundary == null ? [] : [boundary]
                    }).then(resp => {

                        this.boundaries = resp.data.data

                        console.log(resp)

                        this.preloader = false
                    })
                }

            })

            this.preloader = true
            this.uploadData();
        },

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
