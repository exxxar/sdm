<template>
    <div>
        <div class="row w-100 m-auto justify-content-end align-items-center">
            <div style="z-index: 9" class="col-12 col-md-6 col-lg-9">
                <ol class="breadcrumb pl-0 m-0 align-items-center" style="background-color: transparent">
                    <li class="">
                        <a href="/home" style="color: #9d9ea5; text-decoration: none">
                            Панель управления
                        </a>
                    </li>
                    <li class="">
                        <div class="mx-3 mdi mdi-dots-horizontal"
                             style="color: rgb(157, 158, 165);font-size: 17px;"></div>
                    </li>
                    <li class="" aria-current="page">
                        <a href="/map"
                           style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                            Карта
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <user-menu :user="user"></user-menu>
            </div>
            <div class="col-12" style="border-bottom: 1px solid #e3e3e5">
            </div>
        </div>
        <div class="row w-100 m-auto align-items-start justify-content-center" style="height:90vh; overflow:hidden;">
            <div class="col-5">
                <div class="row w-100 mt-4 mb-2 mx-auto justify-content-center">
                    <div class="col-12 p-0">
                        <div class="row w-100 mx-auto justify-content-between align-items-center">
                            <h3 style="white-space: nowrap; font-weight: 700; font-size: 32px; font-family: Montserrat;">
                                Карта</h3>
                            <button class="btn my-auto float-right"
                                    style="background:#dfe0f0; color:#7224f2; font-size: 12px" @click="resetFilters">
                                Сбросить
                            </button>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <div class="row w-100 mb-3 mx-auto justify-content-between align-items-center">
                            <div class="col-8 pl-0 pr-1">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Период
                                </p>
                                <daterange-picker ref="picker" :opens="'right'" :locale-data="local_data"
                                                  :timePicker="true" :timePickerIncrement="1" :timePicker24Hour="true"
                                                  :timePickerSeconds="false" :showWeekNumbers="false"
                                                  :showDropdowns="true" :ranges="false" v-model="dateRange"
                                                  :linkedCalendars="true" class="w-100" @update="changePeriod">
                                    <!--                                    todo: check period click-->
                                    <div slot="header" slot-scope="header" class="slot">
                                        <div class="row w-100 m-auto">
                                            <div class="col-12">
                                                <div class="row m-auto w-100 justify-content-end sdm-primary-text">
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
                                                <div class="sdm-primary-text py-3 px-2">Выбранный период: <span
                                                    style="color:#7224f2">{{rangeText(header.rangeText)}}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-slot:input="picker" style="min-width: 350px;">
                                        <div class="row w-100 h-100 m-auto align-items-center justify-content-center">
                                            <div class="col-11 p-0 text-truncate" style="font-size: 12px">
                                                <span style="color: #7224f2">{{ picker.startDate | moment('DD.MM.YYYY')}}</span>
                                                {{ picker.startDate | moment('HH:mm')}} -
                                                <span
                                                    style="color: #7224f2">{{ picker.endDate | moment('DD.MM.YYYY')}}</span>
                                                {{ picker.endDate | moment('HH:mm')}}
                                            </div>
                                            <div class="col-1 pr-0">
                                                <svg class="float-right" height="15px" viewBox="0 0 512 512"
                                                     width="15px" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="#7224f2"
                                                          d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>
                                    <div slot="footer" slot-scope="data" class="slot">
                                    </div>
                                </daterange-picker>
                            </div>
                            <div class="col-4 pl-1 pr-0">
                                <div class="form-check form-check-inline float-right mt-3 mr-0">
                                    <input id="checkbox-2" class="sdm-checkbox sdm-primary-checkbox" name="checkbox-2"
                                           type="checkbox" v-model="has_appeals"/>
                                    <label for="checkbox-2"
                                           class="sdm-checkbox-label sdm-primary-text mx-0 text-truncate">
                                        Есть обращения
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pl-0 pr-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип устройства
                        </p>
                        <select class="sdm-select mb-3" v-model="device_type">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="type.id" :value="type.id" v-for="type in device_types">
                                {{ type.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-6 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Серийный номер
                        </p>
                        <select class="sdm-select mb-3" v-model="serial_number">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="device.id" :value="device.id" v-for="device in devices">
                                {{ device.serial }}
                            </option>
                        </select>
                    </div>
                    <div class="col-6 pl-0 pr-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Район
                        </p>
                        <select class="sdm-select mb-3" v-model="region">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="region.id" :value="region.id" v-for="region in regions">
                                {{ region.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-6 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Ошибки
                        </p>
                        <select class="sdm-select mb-3" v-model="malfunction">
                            <option value="" selected>
                                Все
                            </option>
                            <option :key="malf.id" :value="malf.id" v-for="malf in malfunctions">
                                {{ malf.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12 p-0">
                        <div class="row w-100 mx-auto align-items-center justify-content-center">
                            <div class="custom-filter col-4 pl-0 pr-1">
                                Серийный номер (всего: <span v-if="sortedList">{{sortedList.length}}</span><span v-else>0</span>)
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'serial'" class="fas fa-angle-down filter-icon"></i>
                            </div>
                            <div class="custom-filter col-6 p-1">
                                Название рубежа
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'device_boundary_id'" class="fas fa-angle-down filter-icon"></i>
                            </div>
                            <div class="custom-filter col-2 pl-1"></div>
                        </div>
                    </div>
                    <div class="col-12 p-0" style="height: 50vh; overflow: auto">
                        <div class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                             style="background: #FFFFFF; border-radius: 5px; font-size:12px" :key="index"
                             v-for="(item, index) in sortedList">
                            <div class="col-12 col-md-4 pr-1">
                                <div class="row w-100 mx-auto my-1 align-items-center">
                                    <div @click="showItem(item.id)">
                                        {{item.serial}}
                                    </div>
                                    <button class="btn p-0"
                                            style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                            @click="showItem(item.id)" title="Перейти к устройству">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px"
                                             height="15px" viewBox="0 0 612 612"
                                             style="enable-background:new 0 0 612 612; overflow:unset;"
                                             xml:space="preserve">
                                        <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                    </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-1 text-wrap text-break">
                                <span v-if="item.device_boundary != null">{{item.device_boundary.title}}</span>
                            </div>
                            <div class="col-2 pl-1">
                                <button class="btn float-right p-0 mdi mdi-chevron-right"
                                        style="height:36px; width: 36px; min-width: 36px; background: transparent; color: #6633ff; font-size: 18px"
                                        @click="showOnMap(item.id, index)">
                                </button>
                            </div>
                        </div>
                        <hr v-if="bad_records.length>0">
                        <h5 v-if="bad_records.length>0">Устройства без координат</h5>

                        <div class="row w-100 mx-auto align-items-center justify-content-center"
                             v-if="bad_records.length>0">
                            <div class="custom-filter col-4 pl-0 pr-1 text-left">
                                Серийный номер (всего: <span v-if="bad_records">{{bad_records.length}}</span><span
                                v-else>0</span>)
                            </div>
                            <div class="custom-filter col-8 p-1 text-left">
                                Название рубежа
                            </div>
                        </div>

                        <div class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                             style="background: #FFFFFF; border-radius: 5px; font-size:12px" :key="index"
                             v-if="bad_records.length>0"
                             v-for="(item, index) in bad_records">
                            <div class="col-12 col-md-4 pr-1">
                                <div class="row w-100 mx-auto my-1 align-items-center">
                                    <div @click="showItem(item.id)">
                                        {{item.serial}}
                                    </div>
                                    <button class="btn p-0"
                                            style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                            @click="showItem(item.id)" title="Перейти к устройству">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px"
                                             height="15px" viewBox="0 0 612 612"
                                             style="enable-background:new 0 0 612 612; overflow:unset;"
                                             xml:space="preserve">
                                        <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                    </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 p-1 text-wrap text-break">
                                <span v-if="item.device_boundary != null">{{item.device_boundary.title}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="row w-100 mt-4 mx-auto justify-content-center align-items-center">
                    <yandex-map :coords="center" :zoom="zoom" :init-without-markers="true" v-if="hide&&sortedList">
                        <ymap-marker v-if="location.is_active&&!location.has_appeals"
                                     v-for="(location, index) in sortedList" :key="location.id"
                                     :marker-id="'id'+location.id" :coords="location.coords[0]" :icon="activeMarkerIcon"
                                     @balloonopen="bindListener(location.id)"
                                     @balloonclose="unbindListener(location.id)">
                            <balloon :ref="'balloon'+location.id" :device="location" slot="balloon"></balloon>
                        </ymap-marker>
                        <ymap-marker v-if="!location.is_active&&!location.has_appeals"
                                     v-for="(location, index) in sortedList" :key="location.id"
                                     :marker-id="'id'+location.id" :coords="location.coords[0]"
                                     :icon="inactiveMarkerIcon" @balloonopen="bindListener(location.id)"
                                     @balloonclose="unbindListener(location.id)">
                            <balloon :ref="'balloon'+location.id" :device="location" slot="balloon"></balloon>
                        </ymap-marker>
                        <ymap-marker v-if="location.has_appeals" v-for="(location, index) in sortedList"
                                     :key="location.id" :marker-id="'id'+location.id" :coords="location.coords[0]"
                                     :icon="errorMarkerIcon" @balloonopen="bindListener(location.id)"
                                     @balloonclose="unbindListener(location.id)">

                            <balloon :ref="'balloon'+location.id" :device="location" slot="balloon"></balloon>
                        </ymap-marker>

                        <ymap-marker :key="'poly-id'+location.id" :marker-id="'poly-id'+location.id"
                                     v-for="(location, index) in sortedList" marker-type="Polyline"
                                     :coords="location.coords" :marker-stroke="device_route_stroke">
                        </ymap-marker>

                    </yandex-map>


                </div>
                <div class="row w-100 mx-auto my-4 justify-content-center align-items-center sdm-primary-text">
                    <span class="mark" style="border: 4px solid green"></span><span class="mr-3">Активные</span>
                    <span class="mark"></span><span class="mr-3">Есть ошибки</span>
                    <span class="mark" style="border: 4px solid #dfe1ee"></span><span class="mr-3">Неактивные</span>
                    <span class="poliline"></span><span class="mr-3">Маршруты мобильных комплексов</span>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {
        yandexMap,
        ymapMarker
    } from 'vue-yandex-maps';
    import moment from 'moment';
    import Balloon from "../../components/map/Balloon";

    export default {
        name: "MapPage",
        components: {
            yandexMap,
            ymapMarker,
            Balloon
        },
        props: ['user', 'devices', 'device_types', 'malfunctions', 'regions'],

        mounted() {
            this.init();
        },
        computed: {
            sortedList: function () {
                let sorted_list = this.filteredList.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === "desc") modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort])
                        return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort])
                        return 1 * modifier;
                    return 0;
                });
                if (sorted_list.length > 0) {
                    if (sorted_list.map(item => item.id).indexOf(this.active_device) === -1) {
                        // this.center = this.locations[0].coords;


                        this.center = sorted_list[0].coords[0] || [50, 50];


                        this.active_device = sorted_list[0].id;
                    }
                }

                /*  this.hide = !this.hide
                  setTimeout(()=>{
                      this.hide = !this.hide
                  }, 10000)
  */

                return sorted_list;
            },
            filteredList() {
                let filtered_devices = this.records.filter(item => {
                    let malfunction = true,
                        region = true,
                        has_appeals = true,
                        serial_number = true,
                        device_type = true,
                        date = false

                    if (item.appeals.length > 0) {
                        if (this.malfunction !== "") {
                            //console.log( item)
                            // malfunction = item.malfunction === this.malfunction;
                            // malfunction =
                            //     item.appeals[0].malfunction_id === this.malfunction;

                            if (item.appeals.map(task => task.malfunction_id).indexOf(this.malfunction) === -1) {

                                malfunction = false;
                            }
                        }
                    } else {
                        if (this.malfunction !== "") {
                            malfunction = false;
                        }
                    }

                    if (this.has_appeals) {
                        has_appeals = item.has_appeals;
                    }

                    if (this.region !== "") {
                        region = item.region_id === this.region;
                    }

                    if (this.device_type !== "") {
                        device_type = item.device_type_id === this.device_type;
                    }

                    if (this.serial_number !== "") {
                        serial_number = item.id === this.serial_number;
                    }

                    // if (
                    //     //todo: change to date that needed for comparison
                    //     moment(item.updated_at).isBetween(
                    //         this.dateRange.startDate,
                    //         this.dateRange.endDate
                    //     )
                    // ) {
                    //     date = true;
                    // }

                    if (item.coords)
                        if (item.coords.length > 0) {
                            if (parseInt(item.coords.reduce((a, b) => a + b, 0)) !== 0) {
                                date = true;
                            }
                        }


                    return region && device_type && has_appeals && malfunction && serial_number && date;
                });


                return filtered_devices;
            },
        },

        watch: {
            'sortedList.length': function (val) {
                if (val === 0) {
                    this.hide = false
                    this.$nextTick(() => {
                        this.hide = true
                    });
                }
            }
        },
        methods: {
            init() {
                this.devices.forEach(device => {
                    device.coords = [];
                    device.has_appeals = false;


                    if (device.lat != null && device.lon != null) {
                        device.coords.push([device.lat, device.lon]);
                    }

                    if (device.device_coords_history)
                        if (device.device_coords_history.length > 0)
                            device.device_coords_history.forEach(history => {
                                if (moment(history.created_at).isBetween(this.dateRange.startDate, this.dateRange.endDate, undefined, '[]')) {
                                    device.coords.push([history.lat, history.lon]);
                                }
                            });


                    device.appeals.forEach(item => {
                        if (item.status === 'Актуальные') {
                            device.has_appeals = true;
                        }
                    })

                    if (device.coords)
                        if (device.coords.length > 0)
                            this.records.push(device);
                        else
                            this.bad_records.push(device);

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
            resetFilters() {
                //window.location.reload()

                this.malfunction = '';
                this.region = '';
                this.has_appeals = false;
                this.serial_number = '';
                this.bad_records = [];
                this.records = [];
                this.device_type = '';
                // this.active_device='';
                let startDate = new Date();
                let endDate = new Date();
                startDate.setDate(endDate.getDate() - 6);
                this.dateRange = {
                    startDate,
                    endDate
                };
                this.init();
            },
            showItem(id) {
                window.location.href = "/devices/" + id;
            },
            showOnMap(id, index) {
                this.active_device = id;
                this.zoom = 17;

                if (this.sortedList[index].coords)
                    this.center = this.sortedList[index].coords[0];
            },
            isActive: function (item, coords) {
                //for test purpose
                // if (this.center[0] === 33 || this.center[0] ===  58 || this.center[0] === 57 )
                // {
                //     if(this.center[1] === 39 || this.center[1] === 40 || this.center[1] === 41){
                //          if (item.id == this.active_device)
                //          {
                //              return true
                //          }
                //     }
                // }
                // return this.center[0] === f[0] && this.center[1] === coords[1] && item.id == this.active_device;
                //for real data
                // return this.center[0] === item.coords[0] && this.center[1] === item.coords[1] && item.id == this.active_device;
                // or
                return this.center[0] === item.lat && this.center[1] === item.lon && item.id == this.active_device;
            },
            rangeText(range) {
                let text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
                return text;
            },
            bindListener(id) {
                // this.$refs.balloon[index].bindListener();
                this.$refs['balloon' + id][0].bindListener();
            },
            unbindListener(id) {
                // this.$refs.balloon[index].unbindListener();
                this.$refs['balloon' + id][0].unbindListener();
            },
            changePeriod() {
                this.records.forEach(device => {
                    device.coords = [];
                    device.has_appeals = false;
                    device.passages = 0;
                    device.violations = 0;
                    device.device_coords_history.forEach(history => {
                        if (moment(history.created_at).isBetween(this.dateRange.startDate, this.dateRange.endDate, undefined, '[]')) {
                            device.coords.push([history.lat, history.lon]);
                        }
                    });
                    device.appeals_for_period = device.appeals.filter(task => {
                        if (moment(task.started_at).isBetween(this.dateRange.startDate, this.dateRange.endDate, undefined, '[]')) {
                            if (task.executed_at == null) {
                                return true;
                            }
                        } else {
                            if (task.executed_at == null) {
                                return true;
                            }
                        }
                        return false;
                    });

                    if (device.appeals_for_period)
                        if (device.appeals_for_period.length > 0) {
                            device.has_appeals = true;
                        }

                    // appeals.forEach(task => {
                    //     if (moment(task.created_at).isBetween(this.dateRange.startDate, this.dateRange.endDate)) {
                    //
                    //     }
                    // })
                });
            }
        },

        data() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(endDate.getDate() - 6);
            return {
                hide: true,
                dateRange: {
                    startDate,
                    endDate
                },
                local_data: {
                    format: 'mm/dd/yyyy HH:MM',
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

                currentSort: "serial",
                currentSortDir: "asc",

                malfunction: '',
                region: '',
                has_appeals: false,
                serial_number: '',
                device_type: '',
                active_device: '',

                settings: {
                    apiKey: 'c3ddaef1-2a3e-4aea-bd55-698a8735fc7d',
                    lang: 'ru_RU',
                    coordorder: 'latlong',
                    version: '2.1'
                },
                device_route: [],
                device_route_stroke: {
                    color: '#6C18F1',
                    width: 4,
                    style: '2 0'
                },
                activeMarkerIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '',
                    imageSize: [40, 40],
                    imageOffset: [0, 0],
                    content: '123 v12',
                    contentOffset: [0, 0],
                    contentLayout: `<div class="p-2" style="border: 3px solid green; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><?xml version="1.0" encoding="iso-8859-1"?>
                        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 419.84 419.84" style="enable-background:new 0 0 419.84 419.84;" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#458d3c" d="M415.232,106.496c-3.072-2.048-6.656-2.048-9.728-0.512l-86.528,44.544v-15.36c0-28.16-23.04-51.2-51.2-51.2H51.2
                                    c-28.16,0-51.2,23.04-51.2,51.2v149.504c0,28.16,23.04,51.2,51.2,51.2h216.576c28.16,0,51.2-23.04,51.2-51.2v-15.36l86.528,44.544
                                    c5.12,2.56,11.264,0,13.312-5.12c0.512-1.536,1.024-3.072,1.024-4.096V115.2C419.84,111.616,418.304,108.032,415.232,106.496z"/>
                            </g>
                        </g>
                        </svg></div>`
                    //contentLayout: '<div class="p-2" style="border: 3px solid green; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><img class="m-auto" style="height: 17px; width: 17px;" src="/icons/active-video-camera.svg"/></div>'
                },
                errorMarkerIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '',
                    imageSize: [40, 40],
                    imageOffset: [0, 0],
                    content: '123 v12',
                    contentOffset: [0, 0],
                    contentLayout: `<div class="p-2" style="border: 3px solid red; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><?xml version="1.0" encoding="iso-8859-1"?>
                        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 419.84 419.84" style="enable-background:new 0 0 419.84 419.84;" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="red" d="M415.232,106.496c-3.072-2.048-6.656-2.048-9.728-0.512l-86.528,44.544v-15.36c0-28.16-23.04-51.2-51.2-51.2H51.2
                                    c-28.16,0-51.2,23.04-51.2,51.2v149.504c0,28.16,23.04,51.2,51.2,51.2h216.576c28.16,0,51.2-23.04,51.2-51.2v-15.36l86.528,44.544
                                    c5.12,2.56,11.264,0,13.312-5.12c0.512-1.536,1.024-3.072,1.024-4.096V115.2C419.84,111.616,418.304,108.032,415.232,106.496z"/>
                            </g>
                        </g>
                        </svg></div>`
                    //contentLayout: '<div class="p-2" style="border: 3px solid red; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><img class="m-auto" style="height: 17px; width: 17px;" src="/icons/error-video-camera.svg"/></div>'
                },
                inactiveMarkerIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '',
                    imageSize: [40, 40],
                    imageOffset: [0, 0],
                    content: '123 v12',
                    contentOffset: [0, 0],
                    contentLayout: `<div class="p-2" style="border: 3px solid #dfe1ee; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><?xml version="1.0" encoding="iso-8859-1"?>
                        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 419.84 419.84" style="enable-background:new 0 0 419.84 419.84;" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#dfe1ee" d="M415.232,106.496c-3.072-2.048-6.656-2.048-9.728-0.512l-86.528,44.544v-15.36c0-28.16-23.04-51.2-51.2-51.2H51.2
                                    c-28.16,0-51.2,23.04-51.2,51.2v149.504c0,28.16,23.04,51.2,51.2,51.2h216.576c28.16,0,51.2-23.04,51.2-51.2v-15.36l86.528,44.544
                                    c5.12,2.56,11.264,0,13.312-5.12c0.512-1.536,1.024-3.072,1.024-4.096V115.2C419.84,111.616,418.304,108.032,415.232,106.496z"/>
                            </g>
                        </g>
                        </svg></div>`
                    //contentLayout: '<div class="p-2" style="border: 3px solid #dfe1ee; width: 40px; height: 40px; border-radius: 50%; background: #FFFFFF;"><img class="m-auto" style="height: 17px; width: 17px;" src="/icons/inactive-video-camera.svg"/></div>'
                },
                center: [54, 39],
                zoom: 5,
                records: [],
                bad_records: []
            };
        },


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

    .active_device {
        background: #6633ff !important;
        color: white !important;
    }

    .active_device button {
        background: #6633ff !important;
        color: white !important;
    }

    .active_device svg path {
        fill: white !important;
    }

    .ymap-container {
        height: 80vh;
        width: 100%;
    }

    .mark {
        border-radius: 50%;
        background: white;
        width: 15px;
        height: 15px;
        border: 4px solid red;
        margin: 5px;
    }

    .poliline {
        border-radius: 30%;
        background: #6633ff;
        width: 20px;
        height: 4px;
        margin: 5px;
    }
</style>
<style>
    .ymaps-2-1-78-balloon {
        position: absolute;
        z-index: 1;
        padding: 1px;
        box-shadow: 0px 0px 35px -7px rgba(0, 0, 0, .5) !important;
        border-radius: 5px !important;
    }

    .ymaps-2-1-78-balloon__layout {
        border-radius: 5px !important;
    }
</style>
