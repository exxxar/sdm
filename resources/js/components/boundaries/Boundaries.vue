<template>
<div>
    <div class="row mx-auto mt-2 align-items-center" v-if="selected.length > 0" style="padding: 15px; border-top: 1px solid #dfe1ee; border-left: 1px solid #dfe1ee; border-right: 1px solid #dfe1ee; border-radius: 5px">
        <div class="col-8">
            <div class="row w-100 mx-auto align-items-center">
                <div style="display: flex" class="mr-2 mt-1" :key="device.id" v-for="device in selected">
                    <div class="mr-1">{{ device.title }}</div>
                    <div v-on:click="uncheck(device)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                        <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                            <g>
                                <g>
                                    <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 custom-filter" style="display: flex; align-items: center; justify-content: flex-end">
            (всего {{ selected.length }})
            <button class="btn border-copy-button pt-0 pb-0" v-on:click="checkAll()" title="Позволяет выбрать все объекты">
                <span style="font-size: 10px; border-bottom: 2px solid #7c34f2">Выбрать все</span>
            </button>
            <button class="btn mdi mdi-close" v-on:click="uncheckAll()" style="height:36px; width: 36px; min-width: 36px; background: transparent; color: red; font-size: 15px" title="Позволяет сбросить выбор всех объектов"></button>
        </div>
    </div>
    <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
        <div class="custom-filter col-3 pl-0" @click="sort('title')" style="cursor: pointer;">
            Название рубежа ({{filteredList.length}})
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'title'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div style="cursor: pointer;display: flex;flex-wrap: nowrap; align-items: center" class="custom-filter col-2" @click="sort('boundary_group_id')">
            Группа рубежей<i v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }" v-if="currentSort == 'boundary_group_id'" class="fas fa-angle-down filter-icon"></i>
        </div>
        <div class="custom-filter col-3" @click="sort('devices_count')" style="cursor: pointer;">
            Устройства
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'devices_count'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div @click="sort('is_active')" style="cursor: pointer;padding-left: 50px" class="custom-filter col-4">
            Статус
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'is_active'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
    </div>
    <div class="row w-100 mx-auto align-items-center justify-content-center">
        <div class="col-12 p-0 b-index" :data-after="index+1" :key="item.id" v-for="(item, index) in sortedList">
            <div v-bind:class="{ 'checked-border': isSelected(item.id) }" class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center" style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap">
                <div class="col-12 col-md-3">
                    <div class="row w-100 my-1 ml-1 align-items-center justify-content-start flex-nowrap">

                        <div class="col-md-12 custom-menu-checkbox" style="flex-wrap: nowrap;display: flex;align-items: center;">
                            <input :id="'checkbox-' + index + 2" :name="'checkbox-' + index + 2" class="checkbox-custom" @change="check(item, item.selected)" type="checkbox" v-model="item.selected" />
                            <label :id="'checkbox-' + index + 2" :for="'checkbox-' + index + 2" style="font-size:14px;" class="checkbox-custom-label"></label>
                            <div v-on:click="editItem(item.id)" class="serial-number">
                                {{ item.title }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-2 mb-1">
                    <div v-if="item.group" class="d-flex table-text" style="font-size: 12px;font-weight: 500">
                        {{ item.group.title}}
                        <a :href="`/boundary-groups/edit/${item.group.id}`">
                            <i style="padding:3px 3px 3px 4px; border: 1px solid #7c34f2; border-radius: 50px;width: 17px;height: 17px;" class="fas fa-arrow-right filter-icon fa-xs">
                            </i>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-7" style="display: flex; align-items: center">
                    <div class="d-flex table-text" style="font-size: 12px;font-weight: 500;flex-direction: row;width: 100%;justify-content: space-between;align-items: center;">

                        <div :key="device.id" v-for="(device, deviceIndex) in item.devices" v-if="deviceIndex == 0" class="mb-1 mr-1 d-flex justify-content-between">
                            {{ device.serial }}
                            <a :href="`/devices/edit/${device.id}`">
                                <i style="padding:3px 3px 3px 4px; border: 1px solid #7c34f2; border-radius: 50px;width: 17px;height: 17px;" class="fas fa-arrow-right filter-icon fa-xs">
                                </i>
                            </a>

                            <div class="ml-2" v-popover.top="{ name: 'devices' + item.id }" v-if="item.devices.length > 0">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13px" height="13px" viewBox="0 0 375.636 375.635" xml:space="preserve" style="fill:#7c34f2;cursor:pointer;min-width:13px">
                                    <path d="M41.013,228.825C18.396,228.825,0,210.438,0,187.818c0-22.608,18.396-41.007,41.013-41.007 c22.617,0,41.013,18.398,41.013,41.007C82.025,210.438,63.63,228.825,41.013,228.825z" />
                                    <path d="M185.513,228.825c-22.617,0-41.013-18.387-41.013-41.007c0-22.608,18.396-41.007,41.013-41.007 c22.613,0,41.013,18.398,41.013,41.007C226.525,210.438,208.126,228.825,185.513,228.825z" />
                                    <path d="M334.623,228.825c-22.613,0-41.013-18.387-41.013-41.007c0-22.608,18.399-41.007,41.013-41.007 c22.614,0,41.013,18.398,41.013,41.007C375.636,210.438,357.237,228.825,334.623,228.825z" />
                                </svg>
                                <popover class="popover-custom-window" :name="'devices' + item.id">
                                    <div class="scroll1" style="height:90px;width:200px;overflow-y:scroll;padding:15px;border-radius:5px">
                                        <div :key="device.id" v-for="(device,
                                            deviceIndex) in item.devices" class="mb-1 mr-1">
                                            {{ device.serial }}
                                            <a :href="`/devices/edit/${device.id}`">
                                                <i style="padding:3px 3px 3px 4px; border: 1px solid #7c34f2; border-radius: 50px;width: 17px;height: 17px;" class="fas fa-arrow-right filter-icon fa-xs">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                </popover>
                            </div>
                        </div>

                    </div>
                    <!--  <i
                              v-if="item.mobile&&item.movable"
                              style="border: 1px solid darkgrey; border-radius: 50px; padding: 7px; margin-right:5px;"
                              class="fas fa-car-alt"
                              v-tooltip="{
                                content: 'Перемещаемый',
                                placement: 'bottom-center',
                                classes: ['info'],
                                targetClasses: ['it-has-a-tooltip'],
                                offset: 0,
                                delay: {
                                  show: 500,
                                  hide: 300,
                                },
                              }"
                          ></i>-->

                    <div v-if="!item.mobile&!item.movable" class="icon-grey-border" v-tooltip="{
                              content: 'Стационарный',
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">
                        <svg class="custom-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
                            <path fill="black" d="M256,0C156.011,0,74.667,81.344,74.667,181.333c0,96.725,165.781,317.099,172.843,326.443
                                        c1.984,2.667,5.163,4.224,8.491,4.224c3.328,0,6.507-1.557,8.491-4.224c7.061-9.344,172.843-229.717,172.843-326.443
                                        C437.333,81.344,355.989,0,256,0z M256,277.333c-52.928,0-96-43.072-96-96c0-52.928,43.072-96,96-96s96,43.072,96,96
                                        C352,234.261,308.928,277.333,256,277.333z" />
                        </svg>
                    </div>
                    <div v-if="item.mobile&& !item.movable" class="icon-grey-border" v-tooltip="{
                              content: 'Мобильные, но не передвижные',
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" viewBox="0 0 1627.000000 1571.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,1571.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                <path d="M13570 14765 l-1915 -945 -3 -2058 -2 -2059 1921 -946 1920 -947 390
                                    0 389 0 0 3950 0 3950 -392 0 -393 -1 -1915 -944z" />
                                <path d="M0 11760 l0 -3470 2390 0 2390 0 0 -1350 0 -1350 -1157 0 -1158 0
                                    -907 -2557 c-499 -1407 -905 -2559 -904 -2560 4 -5 1154 -412 1171 -415 14 -2
                                    158 395 774 2132 l758 2135 711 3 712 2 0 -2165 0 -2165 630 0 630 0 0 2165 0
                                    2165 714 0 714 0 10 -28 c5 -15 346 -974 757 -2132 410 -1158 750 -2108 753
                                    -2111 11 -11 1177 407 1179 422 2 8 -404 1159 -901 2559 l-903 2545 -1161 3
                                    -1162 2 0 1350 0 1350 2185 0 2185 0 0 3470 0 3470 -5205 0 -5205 0 0 -3470z
                                    m5410 550 l0 -620 -1660 0 -1660 0 0 620 0 620 1660 0 1660 0 0 -620z" />
                            </g>
                        </svg>
                    </div>
                    <div v-if="item.mobile&& item.movable" class="icon-grey-border" v-tooltip="{
                              content: 'Мобильные передвижные',
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">
                        <svg class="custom-icon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="m14.794 5.1662-1.12213-3.74042c-.255859-.853027-1.02588-1.42578-1.91602-1.42578h-7.51172c-.890137 0-1.66016.572754-1.91602 1.42578l-1.12213 3.74042c-.708557.307922-1.20599 1.01306-1.20599 1.8338v4c0 .552246.447754 1 1 1h.000061l-.000061.999939c0 .552307.447693 1.00006 1 1.00006h1.00006c.552246 0 1-.447754 1-1l-.0004272-1h8.00037l-.000061.999939c0 .552307.447693 1.00006 1 1.00006h1.00006c.552307 0 1-.447754 1-1v-.999939l-.0003662-.000061h.0003662c.552246 0 1-.447754 1-1v-4c0-.82074-.497436-1.52588-1.20599-1.8338zm-10.5499-3.1662h7.51172l.900024 3h-9.31177l.900024-3zm-.244141 7.5c-.552307 0-1-.447754-1-1 0-.552307.447693-1 1-1s1 .447693 1 1c0 .552246-.447693 1-1 1zm8 0c-.552307 0-1-.447754-1-1 0-.552307.447693-1 1-1s1 .447693 1 1c0 .552246-.447693 1-1 1z" transform="translate(0 1)" />
                        </svg>
                    </div>
                    <div style="flex-wrap: nowrap; justify-content: space-between" class="row w-100 mx-auto my-1 align-items-center">
                        <div style="width: 100px;
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;">
                            <p class="switch-label">ВЫКЛ</p>
                            <label class="switch">
                                <input type="checkbox" v-model="item.is_active" v-on:change="checkBoundary($event.target.checked,item.id)" />
                                <span class="slider round"></span>
                            </label>
                            <p class="switch-label">ВКЛ</p>
                        </div>

                        <div style="display: flex" class="mr-2">
                            <button class="btn mr-2" title="Просмотр" v-on:click="toBoundary(item.id)" style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF" v-if="!item.deleted_at">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 492 492" style="transform: rotate(180deg); fill: white; width: 10px; height:10px; min-width: 10px; min-height:10px" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                                C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                                c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                                l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z" />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <div style="display: flex;
                                            align-items: center;
                                            width: 116px;
                                            justify-content: center; flex-wrap:wrap;" v-if="item.deleted_at">
                                <p style="font-size: 14px; color: red; margin-bottom: 0">
                                    Удалено
                                </p>
                                <a :disabled="!can('Восстановление рубежа')" href="#restore" style="color:green;" @click="restore(item)">Восстановить</a>
                            </div>
                            <button :disabled="!can('Изменение рубежа')" v-if="!item.deleted_at" title="Редактировать" class="btn" v-on:click="editItem(item.id)" style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;">
                                <svg id="Capa_1" style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px" enable-background="new 0 0 488.471 488.471" height="512" viewBox="0 0 488.471 488.471" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m166.093 240.214h88.205v194.288h-88.205z" transform="matrix(.707 -.707 .707 .707 1.415 9.959)" />
                                    <path d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z" />
                                </svg>
                            </button>
                            <button :disabled="!can('Удаление рубежа')" title="Удалить элемент" v-if="!item.deleted_at" class="btn" v-on:click="askForDelete(item)" style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;">
                                <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path fill="red" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <modal id="accept-remove">
        <template v-slot:header>
            Единичное удаление
        </template>
        <template v-slot:main>

            <h4 class="w-100 text-center" v-if="removedItem">Вы хотите удалить ?</h4>

            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <button :disabled="!can('Удаление рубежа')" class="btn w-100 btn-dark my-1 mr-1 py-2" @click="deleteBoundary( removedItem.id, true)" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                        Удалить
                    </button>
                </div>
            </div>

        </template>
    </modal>
</div>
</template>

<script>
import Modal from "../../components/Modal";

export default {
    components: {
        Modal
    },
    name: "Boundaries",
    props: ["title", "boundary_group", "device", "type", "deleted"],
    created() {
        this.getData();
    },
    data: () => ({
        // sort
        currentSort: "",
        currentSortDir: "asc",
        data: [],
        selected: [],
        removedItem: null
    }),
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
            return this.data.filter(item => {
                const title = item.title
                    .toLowerCase()
                    .includes(this.title.toLowerCase());

                let boundary_group = true,
                    type = true,
                    device = false,
                    deleted = true;

                if (this.boundary_group !== "") {
                    if (item.group) {
                        boundary_group = item.group.id === this.boundary_group;
                    } else {
                        boundary_group = false;
                    }
                }

                if (this.device !== "") {
                    if (item.devices.length > 0) {
                        item.devices.map(currentDevice => {
                            if (
                                currentDevice.serial
                                .toLowerCase()
                                .includes(this.device.toLowerCase())
                            ) {
                                device = true;
                            }
                        });
                    } else {
                        device = false;
                    }
                } else {
                    device = true;
                }

                if (this.type !== "") {
                    type = item.mobile === this.type;
                }

                if (!this.deleted) {
                    if (item.deleted_at) {
                        deleted = false;
                    }
                }

                return title && boundary_group && type && device && deleted;
            });
        }
    },
    methods: {
        can(permission){
          return window.can(permission)
        },
        askForDelete(item) {
            this.removedItem = item

            $('#accept-remove').modal('show')
        },
        restore(item) {

            axios
                .get(`/boundaries/restore/${item.id}`)
                .then(resp => {
                    this.sendNotify('Вы успешно восстановили рубеж', 'success');
                    window.location.href = `/boundaries`;
                })
                .catch(() => {
                    this.sendNotify('Ошибка восстановления рубежа', 'error');
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
        turnOffAll: function () {
            this.filteredList.forEach(device => {
                device.is_active = false;
            });
            axios
                .post(`/boundary/toggle-all`, {
                    is_active: false
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        turnOnAll: function () {
            this.filteredList.forEach(device => {
                device.is_active = true;
            });
            axios
                .post(`/boundary/toggle-all`, {
                    is_active: true
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        uncheck: function (device) {
            const index = this.selected
                .map(select => select.id)
                .indexOf(device.id);
            if (index !== -1) {
                this.selected.splice(index, 1);
            }
            const indexData = this.data
                .map(select => select.id)
                .indexOf(device.id);
            if (indexData !== -1) {
                this.data[indexData].selected = false;
            }
        },
        checkAll: function () {
            this.filteredList.forEach(device => {
                device.selected = true;
            });
            this.selected = this.filteredList;
        },
        uncheckAll: function () {
            this.selected.forEach(device => {
                const indexData = this.data
                    .map(select => select.id)
                    .indexOf(device.id);
                if (indexData !== -1) {
                    this.data[indexData].selected = false;
                }
            });
            this.selected = [];
        },
        isSelected: function (id) {
            const index = this.selected.map(item => item.id).indexOf(id);
            return index !== -1;
        },
        check: function (item, selected) {
            if (selected) {
                this.selected.push(item);
            } else {
                const index = this.selected
                    .map(select => select.id)
                    .indexOf(item.id);
                if (index !== -1) {
                    this.selected.splice(index, 1);
                }
            }
            //const index = this.data.map(item => item.id).indexOf(id);
            //this.data[index].selected = selected;
        },
        editItem(id) {
            window.location.href = `/boundaries/edit/${id}`;
        },
        toBoundary(id) {
            window.location.href = `/boundaries/${id}`;
        },
        checkBoundary: function (checked, id) {
            axios
                .post(`/boundary/toggle/${id}`, {
                    is_active: checked
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        getData() {
            axios
                .get("/boundary")
                .then(resp => {
                    this.data = resp.data.data;
                    this.data.forEach(item => {
                        item.selected = false;
                    });
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        deleteBoundary(id) {
            const removeIndex = this.data.map(item => item.id).indexOf(id);
            this.data.splice(removeIndex, 1);
            axios
                .delete(`/boundary/${id}`)
                .then(resp => {
                    this.sendNotify('Вы успешно удалили рубеж', 'success');
                    $('#accept-remove').modal('hide')

                })
                .catch(() => {
                    this.sendNotify('Ошибка удаления рубежа', 'error');
                    $('#accept-remove').modal('hide')
                });
        },
        sendNotify(notification, type = 'primary') {
            this.$notify({
                title: 'Рубежи',
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style lang="scss" scoped>
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

.sort-icon-rotation {
    transform: rotate(180deg);
}

.serial-number {
    cursor: pointer;
    font-size: 14px;
}

.serial-number:hover {
    color: #7c34f2 !important;
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

input:checked+.slider {
    background-color: white;
}

/*input:focus + .slider {*/
/*    box-shadow: 0 0 1px #2196F3;*/
/*}*/

input:checked+.slider:before {
    -webkit-transform: translateX(10px);
    -ms-transform: translateX(10px);
    transform: translateX(10px);
    background-color: green;
}

input:checked+.slider {
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

.popover-custom-window {
    right: 0 !important;
    top: -100px !important;
    left: -17px !important;
}

.b-index {
    position: relative;

    &:after {
        content: attr(data-after);
        position: absolute;
        left: -24px;
        top: 0;
        font-size: 10px;
        height: 100%;
        display: flex;
        align-items: center;
        color: #b9bdcc;
    }

}
</style>
