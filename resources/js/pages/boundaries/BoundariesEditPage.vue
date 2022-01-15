<template>
<div>
    <layout :title="boundary.title" :info="false">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <div style="z-index: 9" class="col-12 col-md-6">
                    <ol class="breadcrumb m-0 align-items-center" style="background-color: transparent; padding-left: 0">
                        <li class="">
                            <a href="/home" style="color: #9d9ea5; text-decoration: none">Панель управления</a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal" style="color: rgb(157, 158, 165);font-size: 17px;"></div>
                        </li>
                        <li class="">
                            <a href="/boundaries" style="color: #9d9ea5; text-decoration: none">Рубежи</a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal" style="color: rgb(157, 158, 165);font-size: 17px;"></div>
                        </li>
                        <li class="simple-title" aria-current="page">
                            <a href="#" style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px" v-tooltip="{
                              content: boundary.title ,
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }">{{ boundary.title }}</a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-3">
                    <div id="top-slider" class="row w-100 mx-auto d-flex align-items-center justify-content-center">
                        <p class="switch-label">Все рубежи</p>
                        <label class="switch mr-2 ml-2">
                            <input type="checkbox" v-model="groups" :disabled="groups" v-on:change="toGroups($event.target.checked)">
                            <span class="slider round"></span>
                        </label>
                        <p style="color:#9d9ea5" class="switch-label">Группы рубежей</p>
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
                <div class="col-md-2" style="display: flex;justify-content: flex-end;padding-right: 4px;">
                    <button class="btn" style="display: flex; align-items: center; justify-content: center; height:35px; border: 1px solid #dfe1ee; font-size: 15px; width: 35px; min-width: 35px; background: transparent; color: black" @click="refresh" title="Обновить">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 492.883 492.883" style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M122.941,374.241c-20.1-18.1-34.6-39.8-44.1-63.1c-25.2-61.8-13.4-135.3,35.8-186l45.4,45.4c2.5,2.5,7,0.7,7.6-3
                                                l24.8-162.3c0.4-2.7-1.9-5-4.6-4.6l-162.4,24.8c-3.7,0.6-5.5,5.1-3,7.6l45.5,45.5c-75.1,76.8-87.9,192-38.6,282
                                                c14.8,27.1,35.3,51.9,61.4,72.7c44.4,35.3,99,52.2,153.2,51.1l10.2-66.7C207.441,421.641,159.441,407.241,122.941,374.241z" />
                                    <path d="M424.941,414.341c75.1-76.8,87.9-192,38.6-282c-14.8-27.1-35.3-51.9-61.4-72.7c-44.4-35.3-99-52.2-153.2-51.1l-10.2,66.7
                                                c46.6-4,94.7,10.4,131.2,43.4c20.1,18.1,34.6,39.8,44.1,63.1c25.2,61.8,13.4,135.3-35.8,186l-45.4-45.4c-2.5-2.5-7-0.7-7.6,3
                                                l-24.8,162.3c-0.4,2.7,1.9,5,4.6,4.6l162.4-24.8c3.7-0.6,5.4-5.1,3-7.6L424.941,414.341z" />
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="col-12 col-md-2 col-sm-6 px-0 mr-1" v-if="!boundary.deleted_at">
                    <button @click="report" type="button" class="btn w-100 my-1 btn-dark py-2" style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;">
                        Создать отчет
                    </button>
                </div>
                <div class="col-12 col-md-2 col-sm-6 pl-0 pr-0 pr-sm-1" v-if="!boundary.deleted_at">
                    <button @click="summary" type="button" class="btn w-100 btn-dark my-1 py-2" style="background: transparent;border: 1px solid #7224f2; color:black; font-size: 11px;font-weight: 500;">
                        Сводка
                    </button>
                </div>
                <div class="col-md-1 px-0" style="display: contents;" v-if="!boundary.deleted_at">
                    <button title="Удалить" class="btn my-1" @click="checkForRemove" style="border: 1px solid red; display: flex; align-items: center; justify-content: center; height:35px; width: 35px; min-width: 35px; background: transparent;">
                        <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px; fill:red" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="col-md-1 px-0" style="display: contents;" v-else>
                    <button class="btn btn-link" style="color:green;" @click="restoreBoundary">Восстановить</button>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <div class="row">
                <div class="col-3">
                    <div style="color: #9d9ea5; font-size: 10px">Группа рубежей</div>
                    <div style="font-size: 14px;display: flex;align-items: center;" v-if="boundary.boundary_group">
                        {{boundary.boundary_group.title }}
                        <a :href="`/boundary-groups/edit/${boundary.boundary_group.id}`" class="ml-1" style='width:16px;height:16px;background-image: url("/icons/right-arrow-circular-button-outline.svg");background-repeat: no-repeat;background-size: cover'></a>
                    </div>
                    <p v-else>Не состоит в группе рубежей</p>
                </div>
                <div class="col-2">
                    <div style="color: #9d9ea5; font-size: 10px">Кол-во проездов</div>
                    <div style="color: #7224f2; font-size: 14px;">
                        <p>{{boundary.passages_day}}<sub class="ml-1 mr-1">день</sub></p>
                        <p>{{ boundary.passages }}<sub class="ml-1">всего</sub></p>

                    </div>
                </div>
                <div class="col-2">
                    <div style="color: #9d9ea5; font-size: 10px">Кол-во нарушений</div>
                    <div style="color: #d93030; font-size: 14px;">
                        <p> {{boundary.violations_day}}<sub class="ml-1 mr-1">день</sub></p>

                        <p>{{ boundary.violations }}<sub class="ml-1">всего</sub></p>

                    </div>
                </div>
                <div style="display: flex;
                                justify-content: flex-end;
                                align-items: center;" class="col-5">
                    <div style="width: 100px;
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;">
                        <p class="switch-label">ВЫКЛ</p>
                        <label class="switch">
                            <input type="checkbox" v-model="boundary.is_active" v-on:change="checkDevice($event.target.checked, boundary.id)">
                            <span class="slider round"></span>
                        </label>
                        <p class="switch-label">ВКЛ</p>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li style="margin-left: 20px" class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Настройки рубежа</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Обращения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">История операций</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <boundaries-edit :boundary_groups="boundary_groups" :regions="regions" :devices="devices" :violations="violations" :boundary="boundary" :current_devices="current_devices" :current_violations="current_violations" :edit="boundary.deleted_at ? false : edit"></boundaries-edit>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <boundaries-appeals :boundary="boundary"></boundaries-appeals>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <boundaries-history :boundary="boundary"></boundaries-history>
                </div>
            </div>
        </template>
    </layout>

    <modal id="accept-remove">
        <template v-slot:header>
            Единичное удаление
        </template>
        <template v-slot:main>

            <h4 class="w-100 text-center">Вы хотите удалить {{boundary.title}}?</h4>

            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <button class="btn w-100 btn-dark my-1 mr-1 py-2" @click="deleteBoundary()" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                        Удалить
                    </button>
                </div>
            </div>

        </template>
    </modal>
</div>
</template>

<script>
import Layout from "../../components/Layout";
import BoundariesEdit from "../../components/boundaries/BoundariesEdit";
import BoundariesAppeals from "../../components/boundaries/BoundariesAppeals";
import BoundariesHistory from "../../components/boundaries/BoundariesHistory";
import Modal from "../../components/Modal";

export default {
    name: "BoundariesAddPage",
    props: ['user', 'boundary_groups', 'regions', 'devices', 'violations', 'boundary', 'current_devices', 'current_violations', 'edit'],
    components: {
        Layout,
        BoundariesEdit,
        BoundariesAppeals,
        BoundariesHistory,
        Modal
    },
    data: () => ({
        format_table: true,
        groups: false,
    }),
    mounted() {
        console.log(this.boundary)
    },
    methods: {

        checkForRemove() {
            $('#accept-remove').modal('show')
        },
        refresh() {
            window.location.reload();
        },
        summary() {
            localStorage.setItem("summary", JSON.stringify({
                type: 3,
                user: this.user,
                boundary: this.boundary,
            }));
            window.location.href = '/summary'
        },
        report() {

            localStorage.setItem("report", JSON.stringify({
                type: 3,
                user: this.user,
                boundary: this.boundary,
            }));
            window.location.href = "/reports/add"

        },
        toGroups: function (event) {
            window.location.href = `/boundary-groups`;
        },
        deleteBoundary() {
            axios
                .delete(`/boundary/${this.boundary.id}`)
                .then(resp => {
                    this.sendNotify("Рубеж успешно удален!", "success")
                    window.location.reload();
                    //this.data = resp.data.data;
                })
                .catch(() => {
                    this.sendNotify("Ошибка удаления рубежа", "error")
                });
        },
        restoreBoundary() {
            axios
                .get(`/boundaries/restore/${this.boundary.id}`)
                .then(resp => {
                    this.sendNotify("Рубеж успешно восстановлено", "success")
                    window.location.reload();

                })
                .catch(() => {
                    this.sendNotify("Ошибка восстановления рубежа", "error")
                });
        },
        checkDevice: function (checked, id) {
            axios
                .post(`/boundary/toggle/${id}`, {
                    is_active: checked
                })
                .then((resp) => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
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

<style>
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

/* active */
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
    -webkit-transition: .4s;
    transition: .4s;
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
