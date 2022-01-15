<template>
    <div>
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
                            Серийный номер*
                        </p>
                        <input
                            v-model="new_device.serial"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.serial }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.serial }}</strong>
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
                            IP*
                        </p>
                        <input
                            v-model="new_device.ip"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.ip }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.ip }}</strong>
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
                            Группа устройств
                        </p>
                        <select
                            v-model="new_device.device_group_id"
                            class="form-select custom-select"
                        >
                            <option value="" selected
                                >Выберите группу устройств
                            </option>
                            <option
                                :key="device_group.id"
                                :value="device_group.id"
                                v-for="device_group in device_groups"
                            >
                                {{ device_group.title }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Рубеж
                        </p>

                        <v-select
                            v-model="selected_boundary"
                            :options="boundariesOptions"
                        >
                        </v-select>
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
                            v-model="new_device.lat"
                            v-mask="'##.#######'"
                            class="form-control custom-input"
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
                            v-model="new_device.lon"
                            class="form-control custom-input"
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
            <div class="col-12 col-md-3 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Тип устройства*
                        </p>
                        <select
                            v-model="new_device.device_type_id"
                            class="form-select custom-select"
                            :class="{ 'is-invalid': errors.device_type_id }"
                        >
                            <option value="" selected disabled
                                >Выберите тип устройства
                            </option>
                            <option
                                :key="type.id"
                                :value="type.id"
                                v-for="type in device_types"
                            >
                                {{ type.title }}
                            </option>
                        </select>
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.device_type_id }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Район
                        </p>
                        <select
                            v-model="new_device.region_id"
                            class="form-select custom-select"
                        >
                            <option value="" selected>Выберите район </option>
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
            <div class="col-12 col-md-2 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Связь
                        </p>
                        <input
                            v-model="new_device.connection"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.connection }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.connection }}</strong>
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
                            Порт
                        </p>
                        <input
                            v-model="new_device.port"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.port }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.port }}</strong>
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
                            Логин*
                        </p>
                        <input
                            v-model="new_device.login"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.login }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.login }}</strong>
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
                            Пароль*
                        </p>
                        <input
                            v-model="new_device.password"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.password }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.password }}</strong>
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
                            Секретный код*
                        </p>
                        <input
                            v-model="new_device.secret"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.secret }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.secret }}</strong>
                        </span>
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
                            Дата установки
                        </p>
                        <input
                            type="date"
                            class="form-control custom-input"
                            v-model="new_device.installation_date"
                            :class="{ 'is-invalid': errors.installation_date }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.installation_date }}</strong>
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
                            Дата снятия
                        </p>
                        <input
                            type="date"
                            class="form-control custom-input"
                            v-model="new_device.withdrawal_date"
                            :class="{ 'is-invalid': errors.withdrawal_date }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.withdrawal_date }}</strong>
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
                            :class="{ 'add-button-disabled': loading }"
                            :disabled="loading"
                        >
                            Добавить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DevicesAdd",
    props: ["device_groups", "boundaries", "device_types", "regions"],
    data: () => ({
        boundariesOptions: [],
        selected_boundary: { label: "Выберите рубеж", code: "" },
        new_device: {
            serial: "",
            ip: "",
            device_group_id: "",
            device_boundary_id: "",
            lat: null,
            lon: null,
            device_type_id: "",
            region_id: "",
            connection: "",
            port: "",
            login: "",
            password: "",
            secret: "",
            installation_date: null,
            withdrawal_date: null,
            mobile: false,
            movable: false,
            is_active: false
        },
        errors: {
            serial: null,
            ip: null,
            lat: null,
            lon: null,
            device_type_id: null,
            connection: null,
            port: null,
            login: null,
            password: null,
            secret: null,
            installation_date: null,
            withdrawal_date: null
        },
        //загрузка
        mobile: false,
        movable: false,
        loading: false
    }),
    watch: {
        selected_boundary: function(newVal, oldVal) {
            this.new_device.device_boundary_id =
                newVal != null ? newVal.code : null;
            console.log(newVal.code);
        }
    },
    mounted() {
        this.preparedBoundaries();
    },
    methods: {
        preparedBoundaries() {
            let array = [{ label: "Выберите рубеж", code: "" }];

            this.boundaries.forEach(item => {
                array.push({ label: item.title, code: item.id });
            });

            this.boundariesOptions = array;
        },
        checkMobile(value) {
            if (!value) {
                this.movable = false;
            }
        },
        submit() {
            this.loading = true;
            this.new_device.movable = this.movable;
            this.new_device.mobile = this.mobile;
            axios
                .post("/device", this.new_device)
                .then(resp => {
                    this.sendNotify("Устройство успешно создано", "success");
                    setTimeout(() => {
                        window.location.href = "/devices";
                    }, 3000);
                })
                .catch(error => {
                    this.sendNotify("Произошла ошибка", "error");
                    const errors = error.response.data.errors;

                    for (const [key, value] of Object.entries(this.errors)) {
                        if (errors.hasOwnProperty(key)) {
                            this.errors[key] = errors[key][0];
                            console.log(this.errors);
                        }
                    }
                    this.loading = false;
                });
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Устройства",
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style scoped>
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
