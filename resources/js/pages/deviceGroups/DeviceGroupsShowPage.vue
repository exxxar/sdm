<template>
    <div>
        <layout :title="device_group.title" :info="false">
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
                                    href=""
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    {{ device_group.title }}
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div
                            id="top-slider"
                            class="row w-100 mx-auto d-flex align-items-center justify-content-center"
                        >
                            <p style="color:#9d9ea5" class="switch-label">
                                Все устройства
                            </p>
                            <label class="switch mr-2 ml-2">
                                <input
                                    type="checkbox"
                                    v-model="groups"
                                    :disabled="!groups"
                                    v-on:change="toDevices($event.target.checked)"
                                />
                                <span class="slider round"></span>
                            </label>
                            <p class="switch-label">Группы устройств</p>
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
                <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                    <div class="col-12 col-md-2 col-sm-6 pr-0 pl-0">
                        <button
                            v-on:click="turnOffAll()"
                            class="btn w-100 my-1 mr-1 py-1 border-copy-button pr-0 mr-0"
                        >
                            <span style="font-size: 10px; border-bottom: 2px solid #d93030">
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
                    <div
                        style="display: flex; align-items: center;"
                        class="col-12 col-md-4 col-sm-6 pl-0 pr-0"
                    >
                        <button
                            class="btn mr-1"
                            v-on:click="editDevice(device_group.id)"
                            style="display: flex; align-items: center; justify-content: center; height:35px; border: 1px solid #dfe1ee; font-size: 15px; width: 35px; min-width: 35px; background: transparent; color: black"
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
                            v-on:click="editDevice(device_group.id)"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="min-height:35px; background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Добавить устройство
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 px-0">
                        <input type="file" id="file" style="display:none" ref="file" v-on:change="handleFileUpload()"/>


                        <label for="file"
                               class="btn w-100 btn-dark my-1 mr-1 py-2"
                               style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;"
                        >Загрузить из файла</label>
                        <a class="sub-text" target="_blank" href="/templates/device_groups_current">Скачать шаблон</a>
                    </div>
                    <div class="col-md-1 px-0" style="display: contents;">
                        <button
                            class="btn my-1 ml-1"
                            style="fill:red;border: 1px solid red; display: flex; align-items: center; justify-content: center; height:35px; width: 35px; min-width: 35px; background: transparent;"
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

                                    d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div class="row w-100 m-auto justify-content-center align-items-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-2 p-0">
                                <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                                    <div class="col-12 pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex"
                                            style="font-size: 9px; color: #959597; font-weight: 400"
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
                                <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                                    <div class="col-12  pl-0 pr-2">
                                        <p class="mb-1 d-flex sdm-secondary-text">
                                            Класс
                                        </p>
                                        <select
                                            class="sdm-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                            v-model="deviceClass"
                                        >
                                            <option value="" selected>Все</option>
                                            <option :value="0" selected>Стационарные</option>
                                            <option :value="1" selected>Передвижные</option>
                                            <option :value="2" selected>Мобильные</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 p-0">
                                <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                                    <div class="col-12  pl-0 pr-2">
                                        <p class="mb-1 d-flex sdm-secondary-text">
                                            Тип устройства
                                        </p>
                                        <select
                                            class="sdm-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                            v-model="typeId"
                                        >
                                            <option value="" selected>Все</option>
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
                            <div class="col-12 col-md-6 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p class="mb-1 d-flex sdm-secondary-text">
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
                        <p class="mb-1 d-flex sdm-secondary-text"
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
                        <button
                            type="button"
                            class="btn w-100 py-2 reset-button"
                            v-on:click="resetFilters"
                            :class="{
                                'reset-button-active':
                                    serial ||
                                    boundary ||
                                    typeId ||
                                    deleted ||
                                    deviceClass
                            }"
                            :disabled="
                                !serial &&
                                    !boundary &&
                                    !typeId &&
                                    !deleted &&
                                    !deviceClass
                            "
                        >
                            Сбросить
                        </button>
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
                    :typeId="typeId"
                    :deleted="deleted"
                    :deviceClass="deviceClass"
                    :device_group="device_group"
                ></devices>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import Devices from "../../components/deviceGroups/DeviceGroupsShow";

export default {
    name: "DevicesPage",
    props: ["user", "device_groups", "device_types", "devices", "device_group"],
    components: {
        Layout,
        Devices
    },
    data: () => ({
        format_table: true,
        // filters
        serial: "",
        boundary: "",
        typeId: "",
        deleted: false,
        deviceClass: "",
        // переключатель на группы
        groups: true
    }),
    methods: {
        handleFileUpload() {

            this.sendNotify('Отправляем файл на сервер');

            this.file = this.$refs.file.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post('/send-device-groups-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(resp => {
                this.sendNotify('Файл успешно загружен', 'success');

                window.location.href = '/device-groups'
            })
                .catch(() => {
                    this.sendNotify('Ошибка загрузки файла', 'error');
                });
        },
        turnOffAll: function() {
            this.$refs.Devices.turnOffAll();
        },
        turnOnAll: function() {
            this.$refs.Devices.turnOnAll();
        },
        editDevice(id) {
            window.location.href = `/device-groups/edit/${id}`;
        },
        resetFilters: function() {
            this.serial = "";
            this.boundary = "";
            this.typeId = "";
            this.deviceClass = "";
            this.deleted = false;
        },
        toDevices: function(event) {
            window.location.href = `/devices`;
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

<style scoped>
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
