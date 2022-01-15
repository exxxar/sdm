<template>
    <div>
        <layout :title="device.serial" :info="false">
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
                            <li class="">
                                <a
                                    href="/devices"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Устройства
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
                                    href="#"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    {{ device.serial }}
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
                    <div
                        class="col-md-2"
                        style="display: flex;justify-content: flex-end;padding-right: 4px;"
                    >
                        <button
                            v-if="!device.deleted_at"
                            class="btn"
                            style="margin-right:4px; display: flex; align-items: center; justify-content: center; height:35px; border: 1px solid #dfe1ee; font-size: 15px; width: 35px; min-width: 35px; background: transparent; color: black"
                            v-on:click="openStream"
                            data-toggle="modal"
                            data-target="#video-from-device"
                            title="Просмотр изображения с устройства"
                        >
                            <svg
                                version="1.1"
                                id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 488.85 488.85"
                                style="fill: black; width: 18px; height:18px; min-width: 18px; min-height:18px"
                                xml:space="preserve"
                            >
                                <g>
                                    <path
                                        d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2
                                    s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025
                                    c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3
                                    C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7
                                    c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"
                                    />
                                </g>
                            </svg>
                        </button>
                        <button
                            v-if="!device.deleted_at && !edit"
                            class="btn small-btn"
                            v-on:click="editDevice"
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
                            v-if="!device.deleted_at"
                            v-on:click="refreshDevice"
                            class="btn"
                            style="display: flex; align-items: center; justify-content: center; height:35px; border: 1px solid #dfe1ee; font-size: 15px; width: 35px; min-width: 35px; background: transparent; color: black"
                            title="Обновить"
                        >
                            <svg
                                v-bind:class="{ rotating: refreshing }"
                                version="1.1"
                                id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 492.883 492.883"
                                style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px"
                                xml:space="preserve"
                            >
                                <g>
                                    <g>
                                        <path
                                            d="M122.941,374.241c-20.1-18.1-34.6-39.8-44.1-63.1c-25.2-61.8-13.4-135.3,35.8-186l45.4,45.4c2.5,2.5,7,0.7,7.6-3
                                                l24.8-162.3c0.4-2.7-1.9-5-4.6-4.6l-162.4,24.8c-3.7,0.6-5.5,5.1-3,7.6l45.5,45.5c-75.1,76.8-87.9,192-38.6,282
                                                c14.8,27.1,35.3,51.9,61.4,72.7c44.4,35.3,99,52.2,153.2,51.1l10.2-66.7C207.441,421.641,159.441,407.241,122.941,374.241z"
                                        />
                                        <path
                                            d="M424.941,414.341c75.1-76.8,87.9-192,38.6-282c-14.8-27.1-35.3-51.9-61.4-72.7c-44.4-35.3-99-52.2-153.2-51.1l-10.2,66.7
                                                c46.6-4,94.7,10.4,131.2,43.4c20.1,18.1,34.6,39.8,44.1,63.1c25.2,61.8,13.4,135.3-35.8,186l-45.4-45.4c-2.5-2.5-7-0.7-7.6,3
                                                l-24.8,162.3c-0.4,2.7,1.9,5,4.6,4.6l162.4-24.8c3.7-0.6,5.4-5.1,3-7.6L424.941,414.341z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 px-0 mr-1">
                        <button
                            @click="createAppeal"
                            v-if="!device.deleted_at"
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Создать обращение
                        </button>
                    </div>
                    <div class="col-12 col-md-2 col-sm-6 px-0 mr-1">
                        <button
                            @click="createReport"
                            v-if="!device.deleted_at"
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Создать отчет
                        </button>
                        <button
                            v-if="device.deleted_at"
                            type="button"
                            v-on:click="restoreDevice"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Восстановить
                        </button>
                    </div>
                    <div class="col-12 col-md-2 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <button
                            @click="createSummary"
                            type="button"
                            class="btn w-100 btn-dark my-1 py-2"
                            style="background: transparent;border: 1px solid #7224f2; color:black; font-size: 11px;font-weight: 500;"
                        >
                            Сводка
                        </button>
                    </div>
                    <div class="col-md-1 px-0" style="display: contents;">
                        <div
                            class="ml-2"
                            style="display: flex; align-items: center; justify-content: center;"
                            v-if="device.deleted_at"
                        >
                            <p
                                style="font-size: 14px; color: red; margin-bottom: 0"
                            >
                                Удалено
                            </p>
                        </div>
                        <button
                            v-if="!device.deleted_at"
                            class="btn delete-button my-1"
                            v-on:click="checkForRemove"
                            title="Удалить"
                        >
                            <svg
                                style="width: 14px; height: 14px; min-width: 14px; min-height: 14px;fill:red"
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
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <div class="row" v-if="!device.deleted_at">
                    <div class="col-3">
                        <div style="color: #9d9ea5; font-size: 10px">
                            Группа устройств
                        </div>
                        <div
                            style="font-size: 14px;display: flex;align-items: center;"
                        >
                            {{ getGroup() }}
                            <a
                                v-if="device.device_group_id"
                                :href="
                                    `/device-groups/${device.device_group_id}`
                                "
                                class="ml-1"
                                style='width:16px;height:16px;background-image: url("/icons/right-arrow-circular-button-outline.svg");background-repeat: no-repeat;background-size: cover'
                            ></a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div style="color: #9d9ea5; font-size: 10px">
                            Кол-во проездов
                        </div>
                        <div style="color: #7224f2; font-size: 14px;">
                            <p>
                                {{ passagesDay
                                }}<sub class="ml-1 mr-1">день</sub>
                            </p>
                            <p>
                                {{ passages_month
                                }}<sub class="ml-1">с начала месяца</sub>
                            </p>
                        </div>
                    </div>
                    <div class="col-2">
                        <div style="color: #9d9ea5; font-size: 10px">
                            Кол-во нарушений
                        </div>
                        <div style="color: #d93030; font-size: 14px;">
                            <p>
                                {{ violationsDay
                                }}<sub class="ml-1 mr-1">день</sub>
                            </p>
                            <p>
                                {{ violations_month
                                }}<sub class="ml-1">с начала месяца</sub>
                            </p>
                        </div>
                    </div>
                    <div
                        style="display: flex; justify-content: flex-end;align-items: center;"
                        class="col-5"
                    >
                        <div
                            v-if="certificate != -1"
                            style="display: flex;flex-direction:column;margin-right:auto;align-self:start"
                        >
                            <div style="color: #9d9ea5; font-size: 10px">
                                Сертификат
                            </div>
                            <div
                                v-if="certificate != -2"
                                style="color: #7224f2; font-size: 14px;"
                            >
                                <p>
                                    {{ certificate
                                    }}<sub class="ml-1 mr-1">дней осталось</sub>
                                </p>
                            </div>
                            <div
                                v-else
                                style="color: #d93030; font-size: 14px;"
                            >
                                <p>просрочен!</p>
                            </div>
                        </div>

                        <div
                            style="width: 100px;display: flex;justify-content: space-between;align-items: center;"
                        >
                            <p class="switch-label">ВЫКЛ</p>
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    v-model="device.is_active"
                                    v-on:change="
                                        checkDevice(
                                            $event.target.checked,
                                            device.id
                                        )
                                    "
                                />
                                <span class="slider round"></span>
                            </label>
                            <p class="switch-label">ВКЛ</p>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li style="margin-left: 20px" class="nav-item">
                        <a
                            class="nav-link active"
                            id="home-tab"
                            data-toggle="tab"
                            href="#home"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true"
                        >
                            {{
                                device.deleted_at
                                    ? "Сведения об устройстве"
                                    : "Настройки устройства"
                            }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="profile-tab"
                            data-toggle="tab"
                            href="#profile"
                            role="tab"
                            aria-controls="profile"
                            aria-selected="false"
                        >
                            Обращения
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="contact-tab"
                            data-toggle="tab"
                            href="#contact"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            История операций
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="coords-tab"
                            data-toggle="tab"
                            href="#coords"
                            role="tab"
                            aria-controls="coords"
                            aria-selected="false"
                        >
                            История координат
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div
                        class="tab-pane fade show active"
                        id="home"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                    >
                        <devices-edit
                            :device_groups="device_groups"
                            :boundaries="boundaries"
                            :device_types="device_types"
                            :regions="regions"
                            :device="device"
                            :edit="device.deleted_at ? false : edit"
                        ></devices-edit>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="profile-tab"
                    >
                        <devices-appeals :device="device"></devices-appeals>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="contact"
                        role="tabpanel"
                        aria-labelledby="contact-tab"
                    >
                        <devices-history :device="device"></devices-history>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="coords"
                        role="tabpanel"
                        aria-labelledby="coords-tab"
                    >
                        <devices-coords-history
                            :device="device"
                            :edit="device.deleted_at ? false : edit"
                        ></devices-coords-history>
                    </div>
                </div>
            </template>
        </layout>

        <modal id="accept-remove">
            <template v-slot:header>
                Единичное удаление
            </template>
            <template v-slot:main>
                <h4 class="w-100 text-center">
                    Вы хотите удалить {{ device.serial }}?
                </h4>

                <div class="row d-flex justify-content-center">
                    <div class="col-4">
                        <button
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            @click="deleteDevice()"
                            style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;"
                        >
                            Удалить
                        </button>
                    </div>
                </div>
            </template>
        </modal>

        <video-modal v-if="device" id="video-from-device">
            <template v-slot:header>
                Видеопоток с камеры {{ device.serial }}
            </template>
            <template v-slot:main>
                <h4 class="w-100 text-center">
                    Видеопоток с камеры {{ device.serial }}
                </h4>
                <iframe
                    v-if="device.device_type_id == 2"
                    :src="'http://81.200.248.156:3001/?id=' + device.id"
                    height="460px"
                    width="760px"
                ></iframe>
                <img
                    id="img"
                    v-if="
                        (device.device_type_id == 5 ||
                            device.device_type_id == 3) &&
                            currentImage
                    "
                    v-bind:src="currentImage + currentTime"
                    alt="no image"
                    style="width: 760px; height: 460px; object-fit: contain;"
                />
            </template>
        </video-modal>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import DevicesEdit from "../../components/devices/DevicesEdit";
import DevicesAppeals from "../../components/devices/DevicesAppeals";
import DevicesHistory from "../../components/devices/DevicesHistory";
import DevicesCoordsHistory from "../../components/devices/DevicesCoordsHistory";

import Modal from "../../components/Modal";
import VideoModal from "../../components/VideoModal";

export default {
    name: "DevicesPage",
    props: [
        "user",
        "device_groups",
        "boundaries",
        "device_types",
        "regions",
        "device",
        "edit",
        "certificate",
        "passages_week",
        "violations_week",
        "passages_month",
        "violations_month"
    ],
    components: {
        Modal,
        VideoModal,
        Layout,
        DevicesEdit,
        DevicesAppeals,
        DevicesHistory,
        DevicesCoordsHistory
    },
    created() {
        this.passagesDay = this.device.passages_day;
        this.violationsDay = this.device.violations_day;
        //this.refreshDevice();

        setInterval(() => {
            this.currentTime = "&t=" + new Date().getTime();
        }, 2000);
    },
    data: () => ({
        refreshing: false,
        content: {
            violations: "загрузка...",
            passages: "загрузка..."
        },
        violationsDay: "",
        passagesDay: "",
        groups: false,
        // for video stream
        currentImage: "",
        currentTime: ""
    }),
    methods: {
        openStream() {
            if (
                this.device.device_type_id == 5 ||
                this.device.device_type_id == 3
            ) {
                this.currentImage = `http://81.200.248.156:3000/video?login=${
                    this.device.login
                }&start_time=${new Date().getTime()}&ip=${
                    this.device.ip
                }&password=${
                    this.device.password
                }&end_time=${new Date().getTime()}&device_type=${
                    this.device.device_type_id
                }`;
            }
        },
        editDevice() {
            window.location.href = `/devices/edit/${this.device.id}`;
        },
        createSummary() {
            localStorage.setItem(
                "summary",
                JSON.stringify({
                    type: 1,
                    user: this.user,
                    device: this.device
                })
            );

            window.location.href = "/summary";
        },
        createReport() {
            localStorage.setItem(
                "report",
                JSON.stringify({
                    type: 1,
                    user: this.user,
                    device: this.device
                })
            );
            window.location.href = "/reports/add";
        },
        createAppeal() {
            localStorage.setItem(
                "appeal",
                JSON.stringify({
                    user: this.user,
                    device: this.device
                })
            );
            window.location.href = "/tasks/add";
        },
        refreshDevice: function() {
            this.refreshing = true;
            axios
                .post(
                    `/devices/info/${this.device.id}`,
                    {
                        ip: this.device.ip,
                        password: this.device.password,
                        login: this.device.login,
                        device_type: this.device.device_type_id,
                        port: this.device.port
                    },
                    { timeout: 10000 }
                )
                .then(resp => {
                    this.refreshing = false;
                    this.sendNotify("Данные успешно загружены", "success");
                    this.violationsDay =
                        parseInt(resp.data.violations) >
                        parseInt(this.violationsDay)
                            ? resp.data.violations
                            : this.violationsDay;
                    this.passagesDay =
                        parseInt(resp.data.passages) >
                        parseInt(this.passagesDay)
                            ? resp.data.passages
                            : this.passagesDay;
                })
                .catch(error => {
                    this.refreshing = false;
                    this.sendNotify(
                        "Ошибка обновления информации по устройству",
                        "error"
                    );
                    this.content.violations = "недоступно";
                    this.content.passages = "недоступно";
                });
        },
        toGroups: function(event) {
            window.location.href = `/device-groups`;
        },
        getGroup: function() {
            if (!this.device.device_group_id) {
                return "Нет группы";
            }

            const index = this.device_groups
                .map(select => select.id)
                .indexOf(this.device.device_group_id);

            if (index !== -1) {
                return this.device_groups[index].title;
            }

            return "Название группы";
        },
        checkDevice: function(checked, id) {
            axios
                .post(`/device/toggle/${id}`, {
                    is_active: checked
                })
                .then(resp => {
                    this.sendNotify(
                        "Режим устройства успешно переключен",
                        "success"
                    );
                    //this.data = resp.data.data;
                })
                .catch(function(resp) {
                    this.sendNotify("Ошибка переключения устройства", "error");
                });
        },
        checkForRemove() {
            $("#accept-remove").modal("show");
        },
        deleteDevice() {
            axios
                .delete(`/device/${this.device.id}`)
                .then(resp => {
                    this.sendNotify("Устройство успешно удалено!", "success");
                    window.location.reload();
                    //this.data = resp.data.data;
                })
                .catch(() => {
                    this.sendNotify("Ошибка удаления устройства", "error");
                });
        },
        restoreDevice() {
            axios
                .get(`/devices/restore/${this.device.id}`)
                .then(resp => {
                    this.sendNotify(
                        "Устройство успешно восстановлено",
                        "success"
                    );
                    window.location.reload();
                })
                .catch(() => {
                    this.sendNotify(
                        "Ошибка восстановления устройства",
                        "error"
                    );
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

<style lang="scss" scoped>
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

/* active */
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
    background-color: green;
}

input:checked + .slider {
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

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 20px;
    margin-bottom: 0;
}
</style>
