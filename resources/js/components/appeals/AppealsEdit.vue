<template>
    <div style="min-height: 80vh">
        <div class="row">
            <div class="col-12 col-md-6 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-6 pl-0 pr-2">
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
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.boundary_id }}</strong>
                        </span>
                    </div>
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Статус
                        </p>
                        <select
                            v-model="edited_appeal.status"
                            class="form-select custom-select"
                        >
                            <option selected value="Актуальные"
                                >В работе
                            </option>
                            <option>Готово </option>
                        </select>
                    </div>
                </div>
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                            :class="{ 'is-invalid': errors.device_id }"
                        >
                            Устройство
                        </p>
                        <v-select
                            v-model="selected_device"
                            :options="devicesOptions"
                        >
                        </v-select>

                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.device_id }}</strong>
                        </span>
                    </div>
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Ответственный
                        </p>
                        <select
                            v-model="edited_appeal.responsible_id"
                            class="form-select custom-select"
                            :class="{ 'is-invalid': errors.responsible_id }"
                        >
                            <option value="" selected disabled
                                >Выберите ответственного
                            </option>
                            <option
                                :key="user.id"
                                :value="user.id"
                                v-for="user in users"
                            >
                                {{ user.name }}
                            </option>
                        </select>
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.responsible_id }}</strong>
                        </span>
                    </div>
                </div>
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-start"
                >
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Неисправность
                        </p>
                        <select
                            v-model="edited_appeal.malfunction_id"
                            class="form-select custom-select"
                            :class="{ 'is-invalid': errors.malfunction_id }"
                        >
                            <option value="" selected disabled
                                >Выберите неисправность
                            </option>
                            <option
                                :key="malfunction.id"
                                :value="malfunction.id"
                                v-for="malfunction in malfunctions"
                            >
                                {{ malfunction.title }}
                            </option>
                        </select>
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.malfunction_id }}</strong>
                        </span>
                    </div>
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Название неисправности
                        </p>
                        <input
                            :disabled="edited_appeal.malfunction_id === 29"
                            v-model="edited_appeal.custom_reason"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.custom_reason }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.custom_reason }}</strong>
                        </span>
                    </div>
                    <div class="col-6 pl-0 pr-2">
                        <p
                            class="mt-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Отчет
                        </p>
                        <select
                            v-model="edited_appeal.report_id"
                            class="form-select custom-select"
                            :class="{ 'is-invalid': errors.report_id }"
                        >
                            <option value="" selected disabled
                                >Выберите отчет
                            </option>
                            <option
                                :key="report.id"
                                :value="report.id"
                                v-for="report in reports"
                            >
                                {{ report.title }}
                            </option>
                        </select>
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.report_id }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-12 pl-0 pr-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Примечание
                        </p>
                        <textarea
                            style="border-color: #dfe1ee; background-color: transparent; border-radius: 3px; height: 152px"
                            class="w-100"
                            v-model="edited_appeal.note"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="align-items: baseline">
            <div class="col-12 offset-md-7 col-md-3 pr-0 d-flex">
                <div
                    class="row w-100 mx-auto d-flex align-items-center justify-content-center"
                >
                    <input
                        id="checkbox-2"
                        class="checkbox-custom"
                        name="checkbox-2"
                        type="checkbox"
                        v-model="notify_by_mail"
                    />
                    <label for="checkbox-2" class="checkbox-custom-label">
                        Оповестить на e-mail
                    </label>
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
    name: "AppealsAdd",
    props: ["users", "boundaries", "devices", "malfunctions", "user", "appeal"],
    created() {
        this.edited_appeal.boundary_id = this.appeal.boundary_id;
        this.edited_appeal.device_id = this.appeal.device_id;
        this.edited_appeal.malfunction_id = this.appeal.malfunction_id;
        this.edited_appeal.responsible_id = this.appeal.responsible_id;
        this.edited_appeal.note = this.appeal.note;
        this.edited_appeal.custom_reason = this.appeal.custom_reason;
        this.edited_appeal.status = this.appeal.status;

        let boundary = this.boundaries.filter(
            item => item.id === this.appeal.boundary_id
        );

        if (boundary.length > 0) {
            this.selected_boundary = {
                label: boundary[0].title,
                code: boundary[0].id
            };
        }

        let device = this.devices.filter(
            item => item.id === this.appeal.device_id
        );
        console.log(device);
        if (device.length > 0) {
            this.selected_device = {
                label: device[0].serial,
                code: device[0].id
            };
        }
    },
    data: () => ({
        boundariesOptions: [],
        selected_boundary: { label: "Выберите рубеж", code: "" },
        selected_device: { label: "Выберите устройство", code: "" },
        edited_appeal: {
            report_id: null
        },
        errors: {
            boundary_id: null,
            device_id: null,
            malfunction_id: null,
            responsible_id: null,
            custom_reason: null
        },
        //загрузка
        notify_by_mail: true,
        loading: false,
        reports: []
    }),

    computed: {
        devicesOptions() {
            let tmp = [];

            if (!this.edited_appeal.boundary_id) {
                tmp = this.devices;
            } else {
                tmp = this.devices.filter(
                    item =>
                        item.device_boundary_id === this.new_appeal.boundary_id
                );
            }

            let array = [{ label: "Выберите устройство", code: "" }];

            tmp.forEach(item => {
                array.push({ label: item.serial, code: item.id });
            });

            return array;
        }
    },
    mounted() {
        this.loadReports();
        this.preparedBoundaries();
        this.edited_appeal.report_id = this.appeal.report_id;
    },
    watch: {
        selected_boundary: function(newVal, oldVal) {
            this.edited_appeal.boundary_id =
                newVal != null ? newVal.code : null;
            this.selected_device = { label: "Выберите устройство", code: "" };
            //console.log(newVal.code);
        },
        selected_device: function(newVal, oldVal) {
            this.edited_appeal.device_id = newVal != null ? newVal.code : null;
            //console.log(newVal.code);
        }
    },
    methods: {
        preparedBoundaries() {
            let array = [{ label: "Выберите рубеж", code: "" }];

            this.boundaries.forEach(item => {
                array.push({ label: item.title, code: item.id });
            });

            this.boundariesOptions = array;
        },
        loadReports() {
            axios.get("/report").then(resp => {
                this.reports = resp.data.data;
                console.log(this.reports);
            });
        },

        submit() {
            this.loading = true;
            this.edited_appeal.user_id = this.user.id;
            this.edited_appeal.notify = this.notify_by_mail;

            axios
                .patch(`/task/${this.appeal.id}`, this.edited_appeal)
                .then(() => {
                    this.sendNotify(
                        "Задача успешно отредактирована",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = "/home";
                    }, 3000);
                })
                .catch(error => {
                    this.sendNotify(
                        "Произошла ошибка, повторите попытку позже",
                        "error"
                    );

                    this.loading = false;

                    const errors = error.response.data.errors;

                    for (const [key, value] of Object.entries(this.errors)) {
                        if (errors.hasOwnProperty(key)) {
                            this.errors[key] = errors[key][0];
                            console.log(this.errors);
                        }
                    }
                });
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Отчеты",
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
