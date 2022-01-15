<template>

    <div>


        <p class="mb-1 mt-2 d-flex sdm-secondary-text">
           Адреса
        </p>


        <multiselect
            placeholder="Выберите адрес"
            :taggable="true"
            @tag="addLocation"
            @remove="removeLocation"
            selectedLabel="Выбрано"
            tagPlaceholder="Добавить адрес"
            selectLabel="Выберите адрес"
            deselectLabel="Enter для удаления адреса"
            v-model="currentLocation"
            label="name"
            :options="locationOptions">
        </multiselect>


        <div class="row " v-if="currentLocation!=''">
            <div class="col-md-12 p-4">
                <div>Все устройства</div>
                <div class="row my-1">
                    <div class="col-12 p-2">
                        <input placeholder="Поиск..." class="form-control custom-input" type="text" v-model="all_device_filter">
                    </div>
                    <div class="col-12 p-2 d-flex justify-content-center">
                        <span v-on:click="selectAll()" style="font-size: 10px; border-bottom: 1px solid #7224f2; cursor: pointer">Выбрать все ({{allDeviceFilter.length}})</span>
                    </div>
                </div>
                <ul class="list-group list-scrollable">
                    <li style="min-height: 47px;" v-on:click="select(device)" v-for="device in allDeviceFilter" class="list-group-item">
                        <div style="display: flex;align-items: center">
                            <svg style="height: 14px;width: 14px;margin-right: 5px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 487.65 487.65" xml:space="preserve">
                            <g>
                                <path fill="#7224f2" d="M243.824,0C109.163,0,0,109.163,0,243.833C0,378.487,109.163,487.65,243.824,487.65
                                    c134.662,0,243.826-109.163,243.826-243.817C487.65,109.163,378.486,0,243.824,0z M243.762,103.634
                                    c20.416,0,36.977,16.555,36.977,36.977c0,20.425-16.561,36.978-36.977,36.978c-20.424,0-36.986-16.553-36.986-36.978
                                    C206.775,120.189,223.338,103.634,243.762,103.634z M307.281,381.228c0,3.695-2.995,6.691-6.684,6.691h-21.509h-70.663h-21.492
                                    c-3.689,0-6.683-2.996-6.683-6.691v-13.719c0-3.694,2.993-6.689,6.683-6.689h21.492V230.706h-22.153
                                    c-3.689,0-6.685-2.996-6.685-6.692V210.28c0-3.695,2.996-6.69,6.685-6.69h22.153h63.981h0.216c3.686,0,6.683,2.995,6.683,6.69
                                    v150.539h21.293c3.688,0,6.684,2.995,6.684,6.689V381.228z"/>
                            </g>
                            </svg>
                            <div>{{device.serial}}</div>
                        </div>
                        <svg style="width: 9px; height: 9px; transform: rotate(180deg)" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 492 492" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#458e3c" d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
                            </g>
                        </g>
                        </svg>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 p-4">
                <div>Выбранные устройства</div>
                <div class="row my-1">
                    <div class="col-12 p-2">
                        <input placeholder="Поиск..." class="form-control custom-input" type="text" v-model="selected_device_filter">
                    </div>
                    <div class="col-12 p-2 d-flex justify-content-center">
                        <span v-on:click="unSelectAll()" style="font-size: 10px; border-bottom: 1px solid #7224f2; cursor: pointer">Удалить все</span>
                    </div>
                </div>
                <ul class="list-group list-scrollable">
                    <li style="min-height: 47px;" v-on:click="deselect(device)" v-for="device in selectedDeviceFilter" class="list-group-item">
                        <div style="display: flex;align-items: center">
                            <svg style="height: 14px;width: 14px;margin-right: 5px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 487.65 487.65" xml:space="preserve">
                            <g>
                                <path fill="#7224f2" d="M243.824,0C109.163,0,0,109.163,0,243.833C0,378.487,109.163,487.65,243.824,487.65
                                    c134.662,0,243.826-109.163,243.826-243.817C487.65,109.163,378.486,0,243.824,0z M243.762,103.634
                                    c20.416,0,36.977,16.555,36.977,36.977c0,20.425-16.561,36.978-36.977,36.978c-20.424,0-36.986-16.553-36.986-36.978
                                    C206.775,120.189,223.338,103.634,243.762,103.634z M307.281,381.228c0,3.695-2.995,6.691-6.684,6.691h-21.509h-70.663h-21.492
                                    c-3.689,0-6.683-2.996-6.683-6.691v-13.719c0-3.694,2.993-6.689,6.683-6.689h21.492V230.706h-22.153
                                    c-3.689,0-6.685-2.996-6.685-6.692V210.28c0-3.695,2.996-6.69,6.685-6.69h22.153h63.981h0.216c3.686,0,6.683,2.995,6.683,6.69
                                    v150.539h21.293c3.688,0,6.684,2.995,6.684,6.689V381.228z"/>
                            </g>
                            </svg>
                            <div>{{device.serial}}</div>
                        </div>
                        <svg style="width: 9px; height: 9px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 492 492" xml:space="preserve">
                        <g>
                            <g>
                                <path fill="#d93030" d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"/>
                            </g>
                        </g>
                        </svg>
                    </li>
                </ul>
            </div>
        </div>




    </div>

</template>
<script>


    export default {
        data() {
            return {

                selected_device_filter: '',
                all_device_filter: '',


                locations: [],
                devices: [],
                currentLocation: '',
                locationOptions: [  ],


            }

        },
        mounted() {
            this.uploadLocationsAndDevices()
        },
        computed: {
            allDeviceFilter: function () {
                console.log(this.all_device_filter )
                return this.all_device_filter === '' ? this.devices :
                    this.devices
                        .filter(item => item.serial.toLowerCase().indexOf(this.all_device_filter.toLowerCase()) !== -1)
            },

            selectedDeviceFilter: function () {
                console.log(this.selected_device_filter )
                if (this.getLocation()==null)
                    return []

                return this.selected_device_filter === '' ? this.getLocation().devices :
                    this.getLocation().devices
                        .filter(item => item.serial.toLowerCase().indexOf(this.selected_device_filter.toLowerCase()) !== -1)
            }
        },

        methods: {
            getLocation(){
                if (this.currentLocation==='')
                    return null;

              return this.locations.filter(item=>item.id===this.currentLocation.code)[0];
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Адреса',
                    text: notification,
                    type: type
                });
            },
            removeLocation(locationTitle) {
                if (!this.locations)
                    return;
                let id = this.locations.filter(item => item.title === locationTitle)[0].id;

                axios
                    .delete(`/location/${id}`).then(() => {
                    this.sendNotify("Адрес успешно удален", "success")
                    this.uploadLocationsAndDevices();
                }).catch(()=>{
                    this.sendNotify("Ошибка удаления адреса", "error")
                })
            },

            addLocation(item) {
                axios
                    .post('/location', {
                        title: item,
                    }).then(() => {
                    this.sendNotify("Адрес успешно создан", "success")
                    this.uploadLocationsAndDevices()
                })


            },
            uploadLocationsAndDevices() {
                axios.get('/location').then(resp => {
                    this.currentLocation = ''
                    this.locationOptions = []

                    this.locations = resp.data.data

                    this.locations.forEach(item => {
                        this.locationOptions.push({name:item.title,code:item.id})
                    })




                })

                axios.get('/device').then(resp => {
                    this.devices = resp.data.data
                })
            },

            selectAll() {
                this.selected = this.selected.concat(this.not_selected);
                this.not_selected = [];
            },
            unSelectAll() {
                this.not_selected = this.not_selected.concat(this.selected);
                this.selected = [];
            },
            select(device) {
                console.log(this.currentLocation)

                let removeIndex = this.devices.map(item => item.id).indexOf(device.id);
                this.devices.splice(removeIndex, 1);


                axios.post('/device/assign',{
                    location_id:this.currentLocation.code,
                    device_id:device.id
                }).then(resp=>{
                   // this.uploadLocationsAndDevices();
                })
                //this.selected.push(device);
            },
            deselect(device) {
                let removeIndex = this.selected.map(item => item.id).indexOf(device.id);
                this.selected.splice(removeIndex, 1);
                this.not_selected.push(device);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .list-scrollable {
        height: 300px;
        overflow-y: scroll;
        .list-group-item {
            margin-bottom: 5px;
            border-radius: 5px;
            border: 1px solid white;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }

    .add-button {
        background: #7224f2;
        border: none;
        color: white;
        font-size: 11px;
        font-weight: 500;
    }

    .add-button-disabled {
        background: #dfe1ee !important;
        border: none !important;
    }

    .custom-input {
        background: transparent;
        color: black;
        font-weight: 500;
        font-size: 12px;
        border-color: #dfe1ee
    }

    .custom-select {
        color: black;
        font-weight: 500;
        font-size: 12px;
        border-color: #dfe1ee
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
        -webkit-transition: .4s;
        transition: .4s;
        border: 1px solid #7c34f2;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 11px;
        width: 11px;
        left: 4px;
        bottom: 4px;
        background-color: #7c34f2;
        -webkit-transition: .4s;
        transition: .4s;
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
        background-color: #7c34f2;
    }

    input:checked + .slider {
        border: 1px solid #7c34f2;
    }

    input:focus {
        border: 1px solid #7c34f2;
        box-shadow: inset 0px 0px 0px 0px red;
    }

    select:focus {
        border: 1px solid #7c34f2;
        box-shadow: inset 0px 0px 0px 0px red;
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

    textarea:focus {
        outline: none !important;
        border: 1px solid #7c34f2 !important;
    }
</style>
