<template>
    <div>
        <layout title="Рубежи" :info="true" :info_text="'Это рубежи.'">
            <template v-slot:menu>
                <div class="row w-100 m-auto justify-content-end align-items-center">
                    <div style="z-index: 9"  class="col-12 col-md-6">
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
                                    href="/boundaries"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Рубежи
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div
                            id="top-slider"
                            class="row w-100 mx-auto d-flex align-items-center justify-content-center"
                        >
                            <p class="switch-label">Все рубежи</p>
                            <label class="switch mr-2 ml-2">
                                <input type="checkbox"
                                       v-model="groups"
                                       :disabled="groups"
                                       v-on:change="toGroups($event.target.checked)"
                                >
                                <span class="slider round"></span>
                            </label>
                            <p style="color:#9d9ea5" class="switch-label">Группы рубежей</p>
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
                            title="Выключает все рубежи"
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
                            title="Включает все рубежи"
                        >
                            <span style="font-size: 10px; border-bottom: 2px solid #458e3c">
                                Включить все
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <button
                            v-on:click="addBoundary"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                            title="Позволяет добавить рубеж"
                        >
                            Добавить рубеж
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 px-0">
                        <button
                            @click="toBoundariesSchedule"
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;"
                            title="Позволяет просмотреть расписание рубежей"
                        >
                            Расписание рубежей
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div class="row w-100 m-auto justify-content-center align-items-center">
                    <div class="col-12 col-md-2 p-0">
                        <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                            <div class="col-12 pl-0 pr-2">
                                <p
                                    class="mb-1 d-flex"
                                    style="font-size: 9px; color: #959597; font-weight: 400"
                                >
                                    Название рубежа
                                </p>
                                <input
                                    v-model="title"
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
                                    Группа рубежей
                                </p>
                                <select
                                    class="sdm-select"
                                    style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                    v-model="boundary_group"
                                >
                                    <option value="" selected>Все</option>
                                    <option :key="boundaries_group.id" :value="boundaries_group.id" v-for="boundaries_group in boundaries_groups">
                                        {{ boundaries_group.title }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 p-0">
                        <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                            <div class="col-12  pl-0 pr-2">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Устройство
                                </p>
                                <input
                                    class="form-control"
                                    placeholder="Все"
                                    style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                    v-model="device"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 p-0">
                        <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                            <div class="col-12  pl-0 pr-2">
                                <p class="mb-1 d-flex sdm-secondary-text">
                                    Тип
                                </p>
                                <select
                                    v-model="type"
                                    class="sdm-select"
                                    style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                >
                                    <option value="" selected>Все</option>
                                    <option :value="true">Передвижное</option>
                                    <option :value="false">Стационарное</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 p-0">
                        <p class="mb-1 d-flex sdm-secondary-text" style="visibility: hidden">
                            Тип
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
                    <div class="col-12 col-md-2" style="padding-right:0;padding-left:0" >
                        <p class="mb-1 d-flex sdm-secondary-text" style="visibility: hidden">
                            Тип
                        </p>
                        <button
                            type="button"
                            class="btn w-100 reset-button py-2"
                            v-on:click="resetFilters"
                            :class="{ 'reset-button-active' : title || boundary_group || device || type }"
                            :disabled="!title && !boundary_group && !device && !type"
                        >
                            Сбросить
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <boundaries
                    ref="Boundaries"
                    :title ="title"
                    :boundary_group ="boundary_group"
                    :device ="device"
                    :type ="type"
                    :deleted="deleted"
                ></boundaries>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import Boundaries from "../../components/boundaries/Boundaries";

export default {
    name: "BoundariesPage",
    props: ['user', 'boundaries_groups'],
    components: {
        Layout, Boundaries
    },
    data: () => ({
        format_table: true,
        // filters
        title: '',
        boundary_group: '',
        device: '',
        type: '',
        deleted: false,
        groups: false
    }),
    methods: {
        handleFileUpload() {
            this.file = this.$refs.file.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post('/send-boundaries-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(resp => {
                this.sendNotify('Файл успешно загружен', 'success');

                window.location.href = '/dictionary-types'
            })
                .catch(() => {
                    this.sendNotify('Ошибка загрузки файла', 'error');
                });
        },
        turnOffAll: function () {
            this.$refs.Boundaries.turnOffAll()
        },
        turnOnAll: function () {
            this.$refs.Boundaries.turnOnAll()
        },
        toGroups: function (event) {
            window.location.href = `/boundary-groups`;
        },
        addBoundary: function () {
            window.location.href = "/boundaries/add";
        },
        toBoundariesSchedule() {
            window.location.href = "/boundaries/schedule";
        },
        resetFilters: function () {
            this.title = ''
            this.boundary_group = ''
            this.device = ''
            this.type = ''
            this.deleted = false
        },
    }
};
</script>

<style scoped>
.reset-button {
    background: #dfe1ee;
    border: none;
    color: white;
    font-size: 11px;
    font-weight: 500;
    opacity: 1!important;
}

.reset-button:hover, .reset-button:focus, .reset-button:active {
    background: #dfe1ee;
    color: white;
}

.reset-button-active {
    background: #6633ff!important;
}

.reset-button-active:hover {
    background: #7224f2!important;
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
