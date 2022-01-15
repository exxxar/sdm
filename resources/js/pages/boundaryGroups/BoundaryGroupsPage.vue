<template>
<div>
    <layout title="Группы рубежей" :info="true" :info_text="'Это группы рубежей.'">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <div style="z-index: 9" class="col-12 col-md-6">
                    <ol class="breadcrumb m-0 align-items-center" style="background-color: transparent; padding-left: 0">
                        <li class="">
                            <a href="/home" style="color: #9d9ea5; text-decoration: none">
                                Панель управления
                            </a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal" style="color: rgb(157, 158, 165);font-size: 17px;"></div>
                        </li>
                        <li class="" aria-current="page">
                            <a href="/boundary-groups" style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                                Группы рубежей
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-3">
                    <div id="top-slider" class="row w-100 mx-auto d-flex align-items-center justify-content-center">
                        <p style="color:#9d9ea5" class="switch-label">
                            Все рубежи
                        </p>
                        <label class="switch mr-2 ml-2">
                            <input type="checkbox" v-model="groups" :disabled="!groups" v-on:change="toDevices($event.target.checked)" />
                            <span class="slider round"></span>
                        </label>
                        <p class="switch-label">Группы рубежей</p>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <user-menu :user="user"></user-menu>
                </div>
                <div class="col-12" style="border-bottom: 1px solid #e3e3e5"></div>
            </div>
        </template>
        <template v-slot:header>
            <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                <div class="col-12 col-md-6 p-0">
                    <div class="row w-100 mx-auto my-2 align-items-center justify-content-end input-icons">
                        <div class="col-12 pl-0 pr-2 ">
                            <input v-model="title" class="form-control" placeholder="Поиск по названию" style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee;" /> 
                        </div>
                        <i class="fas fa-search icon"></i>
                    </div>
                </div>
                <div class="col-12 col-md-2 p-0">
                    <div class="form-check form-check-inline d-flex justify-content-center">
                        <input id="checkbox-2" class="checkbox-custom" name="checkbox-2" type="checkbox" v-model="deleted" />
                        <label for="checkbox-2" class="checkbox-custom-label">
                            Удаленные
                        </label>
                    </div>
                </div>

                <div class="col-12 col-md-2 col-sm-6 pl-0 pr-0 pr-sm-1">
                    <button v-on:click="addGroup" type="button" class="btn w-100 btn-dark my-1 mr-1 py-2" style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;">
                        Добавить группу
                    </button>
                </div>
                <div class="col-12 col-md-2 col-sm-6 px-0">

                    <input type="file" id="file" style="display:none" ref="file" v-on:change="handleFileUpload()" />

                    <label for="file" class="btn w-100 btn-dark my-1 mr-1 py-2" style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;">Загрузить из файла</label>
                    <a class="sub-text" target="_blank" href="/templates/boundary_groups">Скачать шаблон</a>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <boundary-groups :title="title" :deleted="deleted"></boundary-groups>
        </template>
    </layout>
</div>
</template>

<script>
import Layout from "../../components/Layout";
import BoundaryGroups from "../../components/boundaryGroups/BoundaryGroups";

export default {
    name: "BoundaryGroupsPage",
    props: ["user"],
    components: {
        BoundaryGroups,
        Layout
    },
    data: () => ({
        format_table: true,
        // filters
        title: "",
        // переключатель на группы
        groups: true,
        deleted: false
    }),
    methods: {
        handleFileUpload() {
            this.sendNotify('Отправляем файл на сервер');

            this.file = this.$refs.file.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post('/send-boundary-groups-file',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(resp => {
                    this.sendNotify('Файл успешно загружен', 'success');

                    window.location.href = '/boundary-groups'
                })
                .catch(() => {
                    this.sendNotify('Ошибка загрузки файла', 'error');
                });
        },
        addGroup: function () {
            window.location.href = "/boundary-groups/add";
        },
        toDevices: function (event) {
            window.location.href = `/boundaries`;
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
.input-icons i {
    position: absolute;
    color: #8b00ff
}

.input-icons {
    width: 100%;
    margin-bottom: 10px;
}

.icon {
    padding: 10px;
    min-width: 40px;
}

.input-field {
    width: 100%;
    padding: 10px;
    text-align: center;
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

.checkbox-custom+.checkbox-custom-label:before {
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

#checkbox-1+.checkbox-custom-label:before {
    border: 1px solid #d62627;
}

#checkbox-2+.checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox-3+.checkbox-custom-label:before {
    border: 1px solid #458d3c;
}

#checkbox-1:checked+.checkbox-custom-label:before {
    background: #d62627;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-2:checked+.checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-3:checked+.checkbox-custom-label:before {
    background: #458d3c;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

.checkbox-custom:focus+.checkbox-custom-label {
    outline: none;
}
</style>
