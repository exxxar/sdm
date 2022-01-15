<template>
    <div>
        <layout title="Устройства" :info="true" :info_text="'Это устройства.'">
            <template v-slot:menu>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center"
                >
                    <div style="z-index: 9" class="col-12 col-md-6">
                        <ol
                            class="breadcrumb m-0 align-items-center"
                            style="background-color: transparent; padding-left: 0"
                        >
                            <li class="">
                                <a
                                    href="/home"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Панель управления
                                </a>
                            </li>
                            <li class="">
                                <div
                                    class="mx-3 mdi mdi-dots-horizontal"
                                    style="color: rgb(157, 158, 165);font-size: 17px;"
                                ></div>
                            </li>
                            <li class="" aria-current="page">
                                <a
                                    href="/devices"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Устройства
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div
                            id="top-slider"
                            class="row w-100 mx-auto d-flex align-items-center justify-content-center"
                        >
                            <p class="switch-label">Все устройства</p>
                            <label class="switch mr-2 ml-2">
                                <input
                                    type="checkbox"
                                    v-model="groups"
                                    :disabled="groups"
                                    v-on:change="
                                        toGroups($event.target.checked)
                                    "
                                />
                                <span class="slider round"></span>
                            </label>
                            <p style="color: #9d9ea5" class="switch-label">
                                Группы устройств
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <user-menu :user="user"></user-menu>
                    </div>
                    <div
                        class="col-12"
                        style="border-bottom: 1px solid #e3e3e5"
                    ></div>
                </div>
            </template>
            <template v-slot:header>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                >
                    <div class="col-12 col-md-2 col-sm-6 pr-0 pl-0">
                        <button
                            v-on:click="turnOffAll()"
                            class="btn w-100 my-1 mr-1 py-1 border-copy-button pr-0 mr-0"
                        >
                            <span
                                style="font-size: 10px; border-bottom: 2px solid #d93030"
                            >
                                Выключить все
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-2 col-sm-6 pr-0 pl-0">
                        <button
                            v-on:click="turnOnAll()"
                            class="btn w-100 my-1 mr-1 py-1 border-copy-button pl-0 ml-0"
                        >
                            <span
                                style="font-size: 10px; border-bottom: 2px solid #458e3c"
                            >
                                Включить все
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <button
                            v-on:click="addDevice"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                            title="Позволяет добавить устройство"
                        >
                            Добавить устройство
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 px-0">
                        <input
                            type="file"
                            id="file"
                            style="display:none"
                            ref="file"
                            v-on:change="handleFileUpload()"
                        />

                        <label
                            for="file"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;"
                            >Загрузить из файла
                        </label>
                        <a
                            class="sub-text"
                            target="_blank"
                            href="/templates/devices"
                            >Скачать шаблон</a
                        >
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div
                    class="row w-100 m-auto justify-content-center align-items-center"
                >
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-2 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12 pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Серийный номер
                                        </p>
                                        <input
                                            v-model="serial"
                                            class="form-control"
                                            placeholder="Все"
                                            style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Класс
                                        </p>
                                        <select
                                            class="sdm-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                            v-model="deviceClass"
                                        >
                                            <option value="" selected
                                                >Все</option
                                            >
                                            <option :value="1" selected
                                                >Стационарные</option
                                            >
                                            <option :value="2" selected
                                                >Передвижные</option
                                            >
                                            <option :value="3" selected
                                                >Мобильные</option
                                            >
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Тип устройства
                                        </p>
                                        <select
                                            class="sdm-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                            v-model="typeId"
                                        >
                                            <option value="" selected
                                                >Все</option
                                            >
                                            <option
                                                :key="type.id"
                                                :value="type.id"
                                                v-for="type in device_types"
                                            >
                                                {{ type.title }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Группа устройств
                                        </p>
                                        <select
                                            v-model="groupId"
                                            class="sdm-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                        >
                                            <option value="" selected
                                                >Все</option
                                            >
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
                            <div class="col-12 col-md-4 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Рубеж
                                        </p>
                                        <input
                                            class="form-control"
                                            placeholder="Все"
                                            style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                            v-model="boundary"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="visibility: hidden"
                        >
                            удаленные
                        </p>
                        <div class="form-check form-check-inline">
                            <input
                                id="checkbox-2"
                                class="checkbox-custom"
                                name="checkbox-2"
                                type="checkbox"
                                v-model="deleted"
                            />
                            <label
                                for="checkbox-2"
                                class="checkbox-custom-label"
                            >
                                Удаленные
                            </label>
                        </div>
                    </div>
                    <div
                        style="padding-right:0;padding-left:0"
                        class="col-12 col-md-2"
                    >
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="visibility: hidden"
                        >
                            Тип
                        </p>
                        <div style="display:flex">
                            <button
                                type="button"
                                class="btn w-100 py-2 reset-button reset-button-active"
                                v-on:click="applyFilters"
                            >
                                Применить
                            </button>
                            <button
                                type="button"
                                class="btn w-100 py-2 reset-button ml-3 reset-button-active"
                                v-on:click="resetFilters"
                            >
                                Сбросить
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <devices
                    ref="Devices"
                    :format_table="format_table"
                    :devices="devices"
                    :serial="serial"
                    :boundary="boundary"
                    :groupId="groupId"
                    :typeId="typeId"
                    :deleted="deleted"
                    :deviceClass="deviceClass"
                ></devices>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import Devices from "../../components/devices/Devices";

export default {
    name: "DevicesPage",
    props: ["user", "device_groups", "device_types", "devices"],
    components: {
        Layout,
        Devices
    },
    data: () => ({
        format_table: true,
        // filters
        serial: "",
        boundary: "",
        groupId: "",
        typeId: "",
        deleted: false,
        deviceClass: "",
        // переключатель на группы
        groups: false
    }),
    methods: {
        applyFilters() {
            this.$refs.Devices.getData();
        },
        handleFileUpload() {
            this.sendNotify("Отправляем файл на сервер");

            this.file = this.$refs.file.files[0];

            let formData = new FormData();
            formData.append("file", this.file);

            axios
                .post("/send-devices-file", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(resp => {
                    this.sendNotify("Файл успешно загружен", "success");

                    window.location.href = "/devices";
                })
                .catch(() => {
                    this.sendNotify("Ошибка загрузки файла", "error");
                });
        },
        turnOffAll: function() {
            this.$refs.Devices.turnOffAll();
        },
        turnOnAll: function() {
            this.$refs.Devices.turnOnAll();
        },
        addDevice: function() {
            window.location.href = "/devices/add";
        },
        resetFilters: function() {
            this.serial = "";
            this.boundary = "";
            this.groupId = "";
            this.typeId = "";
            this.deviceClass = "";
            this.deleted = false;
            setTimeout(() => this.$refs.Devices.getData(), 0);
        },
        toGroups: function(event) {
            window.location.href = `/device-groups`;
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

<style lang="scss" scoped>
select:focus {
    outline: none;
}

.reset-button {
    background: #dfe1ee;
    border: none;
    color: white;
    font-size: 11px;
    font-weight: 500;
    opacity: 1 !important;
}

.reset-button:hover,
.reset-button:focus,
.reset-button:active {
    background: #dfe1ee;
    color: white;
}

.reset-button-active {
    background: #6633ff !important;
}

.reset-button-active:hover {
    background: #7224f2 !important;
}

#dropdownMenuButton::after {
    display: none;
}

.active-toggler {
    color: #6633ff;
}

.form-select {
    display: block;
    width: 100%;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    font-size: 1rem;
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

.checkbox-custom {
    opacity: 0;
    position: absolute;
}

.checkbox-custom,
.checkbox-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px;
    cursor: pointer;
    font-weight: 500;
    font-size: 10px;
}

.checkbox-custom-label {
    position: relative;
}

.checkbox-custom + .checkbox-custom-label:before {
    content: "";
    /*background: #fff;*/
    border: 1px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    width: 17px;
    height: 17px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
    border-radius: 3px;
}

#checkbox-1 + .checkbox-custom-label:before {
    border: 1px solid #d62627;
}

#checkbox-2 + .checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox-3 + .checkbox-custom-label:before {
    border: 1px solid #458d3c;
}

#checkbox-1:checked + .checkbox-custom-label:before {
    background: #d62627;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-2:checked + .checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-3:checked + .checkbox-custom-label:before {
    background: #458d3c;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

.checkbox-custom:focus + .checkbox-custom-label {
    outline: none;
}
</style>
