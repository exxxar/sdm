<template>
    <div style="min-height: 80vh">
        <div class="row">
            <div class="col-12 col-md-6 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Название рубежа
                        </p>
                        <input
                            v-model="edited_boundary.title"
                            class="form-control custom-input"
                            :readonly="!edit"
                            :class="{ 'is-invalid': errors.title }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.title }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Группа рубежей
                        </p>
                        <select
                            v-model="edited_boundary.boundary_group_id"
                            class="form-select custom-select"
                            :disabled="!edit"
                        >
                            <option value="" selected
                                >Выберите группу рубежей
                            </option>
                            <option
                                :key="boundary_group.id"
                                :value="boundary_group.id"
                                v-for="boundary_group in boundary_groups"
                            >
                                {{ boundary_group.title }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Регион
                        </p>
                        <select
                            v-model="edited_boundary.region_id"
                            class="form-select custom-select"
                            :disabled="!edit"
                        >
                            <option value="" selected>Выберите регион </option>
                            <option
                                :key="region.id"
                                :value="region.id"
                                v-for="region in regions"
                            >
                                {{ region.title }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Выберите устройства
                        </p>
                        <v-select
                            v-model="currentDevice"
                            :disabled="!edit"
                            :options="options"
                        ></v-select>
                    </div>
                </div>
            </div>
            <div
                class="col-12 col-md-9 pr-0"
                style="display: flex;align-items: flex-end;"
            >
                <div class="row w-100 mx-auto mb-2">
                    <div
                        style="display: flex"
                        class="mr-2 mb-1"
                        :key="device.code"
                        v-for="device in selectedDevices"
                    >
                        <div class="mr-1">{{ device.label }}</div>
                        <div
                            v-if="edit"
                            @click="removeDevice(device)"
                            style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px"
                        >
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
                                <g>
                                    <g>
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Типы нарушений
                        </p>
                        <v-select
                            class="v-select-custom"
                            :disabled="!edit"
                            v-model="currentViolation"
                            :options="violationsOptions"
                        ></v-select>
                    </div>
                </div>
            </div>
            <div
                class="col-12 col-md-9 pr-0"
                style="display: flex;align-items: flex-end;"
            >
                <div class="row w-100 mx-auto mb-3">
                    <div
                        style="display: flex"
                        class="mr-2"
                        :key="violation.code"
                        v-for="violation in selectedViolations"
                    >
                        <div class="mr-1">{{ violation.label }}</div>
                        <div
                            v-if="edit"
                            @click="removeViolation(violation)"
                            style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px"
                        >
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
                                <g>
                                    <g>
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-2 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Скоростной режим
                        </p>
                        <select
                            v-model="edited_boundary.speed_mode"
                            :disabled="!edit"
                            class="form-select custom-select"
                        >
                            <option value="" selected>Не задан </option>
                            <option>40</option>
                            <option>50</option>
                            <option>60</option>
                            <option>70</option>
                            <option>80</option>
                            <option>90</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-2 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Широта
                        </p>
                        <input
                            v-mask="'##.#######'"
                            v-model="edited_boundary.lat"
                            class="form-control custom-input"
                            :readonly="!edit"
                            :class="{ 'is-invalid': errors.lat }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.lat }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Долгота
                        </p>
                        <input
                            v-mask="'##.#######'"
                            v-model="edited_boundary.lon"
                            class="form-control custom-input"
                            :readonly="!edit"
                            :class="{ 'is-invalid': errors.lon }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.lon }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 offset-md-1 col-md-3 pr-0 d-flex">
                <div
                    class="mt-3 row w-100 mx-auto d-flex align-items-center justify-content-center"
                >
                    <p class="switch-label">Стационарное</p>
                    <label class="switch mr-3 ml-3">
                        <input
                            type="checkbox"
                            v-model="mobile"
                            :disabled="!edit"
                            v-on:change="checkMobile($event.target.checked)"
                        />
                        <span class="slider round"></span>
                    </label>
                    <p class="switch-label">Передвижное</p>
                </div>
            </div>
            <div class="col-12 col-md-2 pr-0 d-flex">
                <div
                    class="mt-3 row w-100 mx-auto d-flex align-items-center justify-content-center"
                >
                    <input
                        id="checkbox-2"
                        class="checkbox-custom"
                        name="checkbox-2"
                        type="checkbox"
                        v-model="movable"
                        :readonly="!edit"
                        :disabled="!mobile"
                    />
                    <label for="checkbox-2" class="checkbox-custom-label"
                        >Мобильное</label
                    >
                </div>
            </div>
            <div class="d-flex col-12 col-md-2 pr-0">
                <div
                    class="row w-100 mx-auto mt-3 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <button
                            v-on:click="submit"
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2 add-button"
                            style=""
                            :class="{
                                'add-button-disabled': loading || !edit
                            }"
                            :disabled="loading || !edit"
                        >
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BoundariesEdit",
    props: [
        "boundary_groups",
        "regions",
        "devices",
        "violations",
        "boundary",
        "current_violations",
        "current_devices",
        "edit"
    ],
    created() {
        // заполняем массив уже выбранных устройств
        this.current_devices.forEach(device => {
            this.selectedDevices.push({
                label: device.serial,
                code: device.id
            });
        });
        // заполняем массив устройств доступных для выбора
        this.devices.forEach(device => {
            let removeIndex = this.selectedDevices
                .map(item => item.code)
                .indexOf(device.id);
            if (removeIndex < 0) {
                this.options.push({ label: device.serial, code: device.id });
            }
        });
        // заполняем массив выбранных нарушений
        this.current_violations.forEach(violation => {
            this.selectedViolations.push({
                label: violation.title,
                code: violation.id
            });
        });
        // заполняем массив нарушений доступных для выбора
        this.violations.forEach(violation => {
            let removeIndex = this.selectedViolations
                .map(item => item.code)
                .indexOf(violation.id);
            if (removeIndex < 0) {
                this.violationsOptions.push({
                    label: violation.title,
                    code: violation.id
                });
            }
        });
        this.edited_boundary.title = this.boundary.title;
        this.edited_boundary.boundary_group_id = this.boundary.boundary_group_id;
        this.edited_boundary.region_id = this.boundary.region_id;
        this.edited_boundary.speed_mode = this.boundary.speed_mode;
        this.edited_boundary.lat = this.boundary.lat;
        this.edited_boundary.lon = this.boundary.lon;
        this.mobile = !!this.boundary.mobile;
        this.movable = !!this.boundary.movable;
        this.edited_boundary.is_active = this.boundary.is_active;
    },
    data: () => ({
        edited_boundary: {},
        errors: {
            title: null,
            lat: null,
            lon: null
        },
        // v-select
        options: [],
        selectedDevices: [],
        violationsOptions: [],
        selectedViolations: [],
        //загрузка
        loading: false,
        mobile: false,
        movable: false
    }),
    computed: {
        currentDevice: {
            get: function() {
                return null;
            },
            set: function(newValue) {
                let removeIndex = this.options
                    .map(item => item.code)
                    .indexOf(newValue.code);
                this.options.splice(removeIndex, 1);
                this.selectedDevices.push(newValue);
            }
        },
        currentViolation: {
            get: function() {
                return null;
            },
            set: function(newValue) {
                let removeIndex = this.violationsOptions
                    .map(item => item.code)
                    .indexOf(newValue.code);
                this.violationsOptions.splice(removeIndex, 1);
                this.selectedViolations.push(newValue);
            }
        }
    },
    watch: {
        selectedDevices: {
            handler: function() {},
            deep: true
        },
        options: {
            handler: function() {},
            deep: true
        },
        violationsOptions: {
            handler: function() {},
            deep: true
        },
        selectedViolations: {
            handler: function() {},
            deep: true
        }
    },
    methods: {
        checkMobile(value) {
            if (!value) {
                this.movable = false;
            }
        },
        removeDevice(device) {
            let removeIndex = this.selectedDevices
                .map(item => item.code)
                .indexOf(device.code);
            this.selectedDevices.splice(removeIndex, 1);
            this.options.push(device);
        },
        removeViolation(violation) {
            let removeIndex = this.selectedViolations
                .map(item => item.code)
                .indexOf(violation.code);
            this.selectedViolations.splice(removeIndex, 1);
            this.violationsOptions.push(violation);
        },
        submit() {
            this.loading = true;
            this.edited_boundary.devices = this.selectedDevices;
            this.edited_boundary.violations = this.selectedViolations;
            this.edited_boundary.movable = this.movable;
            this.edited_boundary.mobile = this.mobile;
            axios
                .patch(`/boundary/${this.boundary.id}`, this.edited_boundary)
                .then(function() {
                    window.location.href = "/boundaries";
                })
                .catch(error => {
                    const errors = error.response.data.errors;

                    for (const [key, value] of Object.entries(this.errors)) {
                        if (errors.hasOwnProperty(key)) {
                            this.errors[key] = errors[key][0];
                            console.log(this.errors);
                        }
                    }
                    this.loading = false;
                });
        }
    }
};
</script>

<style scoped>
.vs__search {
    border: none !important;
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
    border-color: #dfe1ee;
}

.custom-select {
    color: black;
    font-weight: 500;
    font-size: 12px;
    border-color: #dfe1ee;
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
    background-color: #7c34f2;
}

input:checked + .slider {
    border: 1px solid #7c34f2;
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
</style>
