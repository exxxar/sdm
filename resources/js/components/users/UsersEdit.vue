<template>
<div>
    <div class="row w-100 mx-auto align-items-center justify-content-center">
        <div class="col-12 p-0">
            <div class="row w-100 mx-auto my-2 align-items-center justify-content-center">
                <div class="col-3 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Фамилия Имя
                    </p>
                    <input v-model="edited_user.name" class="form-control custom-input" :class="{ 'is-invalid' : errors.name }" :readonly="!edit" />
                    <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                        <strong>{{ errors.name }}</strong>
                    </span>
                </div>
                <div class="col-3 px-1">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Email
                    </p>
                    <input v-model="edited_user.email" class="form-control custom-input" :class="{ 'is-invalid' : errors.email }" :readonly="!edit" />
                    <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                        <strong>{{ errors.email }}</strong>
                    </span>
                </div>
                <div class="col-3 px-1" v-if="edit">
                    <p class="mb-1 d-flex sdm-secondary-text" style="font-size: 9px; color: #959597; font-weight: 400">
                        Выберите роли
                    </p>
                    <v-select placeholder="Поиск..." v-model="currentRole" :options="rolesOptions" :disabled="!edit">

                    </v-select>
                </div>
                <div class="col-3 px-1" v-if="edit">
                    <p class="mb-1 d-flex sdm-secondary-text" style="font-size: 9px; color: #959597; font-weight: 400">
                        Выберите группы устройств
                    </p>
                    <v-select placeholder="Поиск..." v-model="currentGroup" :options="groupsOptions" :disabled="!edit"></v-select>
                </div>
                <div class="col-3" v-if="!edit">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Роли
                    </p>
                    <div class="row w-100 mx-auto my-1 align-items-center">
                        <div class="sdm-primary-text">
                            <!--Странные конструкции-->
                            {{edited_user.roles[0].name}}
                        </div>
                    </div>
                </div>
                <div class="col-3" v-if="!edit">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Группы устройств
                    </p>
                    <div class="row w-100 mx-auto my-1 align-items-center">
                        <div class="sdm-primary-text">
                            Название группы
                        </div>
                        <button class="btn p-0 mr-2" style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;" @click="toGroupPage(1)">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="15px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-3 px-1" v-if="!edit"></div>
            </div>
        </div>
        <div class="col-12 p-0" v-if="selectedGroups.length>0 || selectedRoles>0">
            <div class="row mx-auto align-items-center justify-content-center">
                <div class="col-3 px-1">
                </div>
                <div class="col-3 px-1">
                </div>
                <div class="col-3 px-1">
                    <div class="row w-100 mx-auto mb-3">
                        <div style="display: flex" class="mr-2 mb-1" :key="role.code" v-for="role in selectedRoles">
                            <div class="mr-1">{{ role.label}}</div>
                            <div @click="removeRole(role)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                                <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                    <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 px-1">
                    <div class="row w-100 mx-auto mb-3">
                        <div class="d-flex mr-2 mb-1" :key="group.code" v-for="group in selectedGroups">
                            <div class="mr-1 sdm-primary-text">{{ group.label}}</div>
                            <div @click="removeGroup(group)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
                                <svg style="width: 7px; height: 7px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                    <path fill="white" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-0">
            <div class="row w-100 mx-auto my-2 align-items-start justify-content-start">
                <div class="col-3 px-1" v-if="edit">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Пароль
                    </p>
                    <input v-model="edited_user.password" class="form-control custom-input" :class="{ 'is-invalid' : errors.password }" :readonly="!edit" />
                    <span style="font-size: 10px;" class="invalid-feedback" role="alert">
                        <strong>{{ errors.password }}</strong>
                    </span>
                </div>
                <div class="col-3 px-1" v-if="edit"></div>
                <div class="col-3 px-1"></div>
            </div>
        </div>
    </div>
    <div class="row w-100 mx-auto align-items-center justify-content-center" v-if="edit">
        <div class="col-12 p-0">
            <div class="row w-100 mx-auto my-2 align-items-center justify-content-start">
                <div class="form-check form-check-inline">
                    <input id="checkbox" class="checkbox-custom" name="checkbox" type="checkbox" v-model="blocking" />
                    <label for="checkbox" class="checkbox-custom-label">
                        Временная блокировка
                    </label>
                </div>
            </div>
        </div>
        <div class="col-3 px-1">
            <p class="mb-1 d-flex sdm-secondary-text">
                Дата начала блокировки
            </p>
            <daterange-picker ref="picker" :singleDatePicker="true" :opens="'center'"
                              :locale-data="local_data" :timePicker="false"
                              :showWeekNumbers="false" :showDropdowns="true"
                              :ranges="false" v-model="blocking_start_date"
                              :linkedCalendars="true" class="w-100" :readonly="!blocking" :disabled="!blocking">
                <div slot="header" slot-scope="header" class="slot">
                    <div class="row w-100 m-auto" v-if="edit">
                        <div class="col-12">
                            <div class="row m-auto w-100 justify-content-end sdm-primary-text">
                                <button @click="header.clickCancel" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                    <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                        Сбросить
                                    </span>
                                </button>
                                <button @click="header.clickApply" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                    <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                        Подтвердить
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12" style="border-top: 1px solid #ced4da">
                            <div class="sdm-primary-text py-3 px-2">Выбранная дата:
                                <span style="color:#7224f2" v-if="blocking_start_date != null">
                                    {{ header.rangeText | moment('DD MMMM YYYY')}}
                                </span>
                                <span style="color:#7224f2" v-if="blocking_start_date == null">
                                    Не выбрана
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-slot:input="picker" style="min-width: 350px;">

                    <div v-if="blocking_start_date !== null" class="row w-100 h-100 m-auto align-items-center justify-content-center">
                        <div class="col-10 p-0 text-truncate sdm-primary-text">
                            <span v-if="blocking_start_date !== null || blocking_start_date.startDate !== null || blocking_start_date.startDate !== undefined" v-bind:class="{'readonly': !blocking}" style="color: #7224f2">
                                {{ picker.startDate | moment('DD.MM.YYYY')}}
                            </span>
                            <span v-bind:class="{'readonly': !blocking}" style="color:#7224f2" v-if="blocking_start_date == null || blocking_start_date.startDate == null || blocking_start_date.startDate == undefined">
                                Не выбрана
                            </span>
                        </div>
                        <div class="col-1 pr-0">
                            <svg class="float-right" height="15px" viewBox="0 0 512 512" width="15px" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#7224f2" v-bind:class="{'readonly': !blocking}" d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0" />
                            </svg>
                        </div>
                    </div>
                </template>
                <div slot="footer" slot-scope="data" class="slot">
                </div>
            </daterange-picker>
        </div>
        <div class="col-3 px-1">
            <p class="mb-1 d-flex sdm-secondary-text">
                Дата окончания блокировки
            </p>
            <daterange-picker ref="picker2" :singleDatePicker="true" :opens="'center'"
                              :locale-data="local_data" :timePicker="false"
                              :showWeekNumbers="false" :showDropdowns="true"
                              :ranges="false" v-model="blocking_end_date"
                              :linkedCalendars="true" class="w-100" :readonly="!blocking" :disabled="!blocking">
                <div slot="header" slot-scope="header" class="slot">
                    <div class="row w-100 m-auto" v-if="edit">
                        <div class="col-12">
                            <div class="row m-auto w-100 justify-content-end sdm-primary-text">
                                <button @click="header.clickCancel" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                    <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                        Сбросить
                                    </span>
                                </button>
                                <button @click="header.clickApply" class="btn my-1 mr-1 py-1 border-copy-button float-right">
                                    <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                        Подтвердить
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12" style="border-top: 1px solid #ced4da">
                            <div class="sdm-primary-text py-3 px-2">Выбранная дата:
                                <span style="color:#7224f2" v-if="blocking_end_date != null">
                                    {{ header.rangeText | moment('DD MMMM YYYY')}}
                                </span>
                                <span style="color:#7224f2" v-if="blocking_end_date == null">
                                    Не выбрана
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-slot:input="picker2" style="min-width: 350px;">

                    <div v-if="blocking_end_date !== null" class="row w-100 h-100 m-auto align-items-center justify-content-center">
                        <div class="col-10 p-0 text-truncate sdm-primary-text">
                            <span v-if="blocking_end_date !== null || blocking_end_date.startDate !== null || blocking_end_date.startDate !== undefined" v-bind:class="{'readonly': !blocking}" style="color: #7224f2">
                                {{ picker2.startDate | moment('DD.MM.YYYY')}}
                            </span>
                            <span v-bind:class="{'readonly': !blocking}" style="color:#7224f2" v-if="blocking_end_date == null || blocking_end_date.startDate == null || blocking_end_date.startDate == undefined">
                                Не выбрана
                            </span>
                        </div>
                        <div class="col-1 pr-0">
                            <svg class="float-right" height="15px" viewBox="0 0 512 512" width="15px" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#7224f2" v-bind:class="{'readonly': !blocking}" d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0" />
                            </svg>
                        </div>
                    </div>
                </template>
                <div slot="footer" slot-scope="data" class="slot">
                </div>
            </daterange-picker>
        </div>
        <div class="col-3"></div>
        <div class="col-3 pr-1">
            <div class="row w-100 mx-auto my-2 align-items-center justify-content-end">
                <div class="form-check form-check-inline float-right">
                    <input id="checkbox-2" class="checkbox-custom" name="checkbox-2" type="checkbox" v-model="notify_by_mail" />
                    <label for="checkbox-2" class="checkbox-custom-label">
                        Оповестить на e-mail
                    </label>
                </div>
                <button v-on:click="submit" type="button" class="btn my-1 btn-dark py-2 add-button" style="" :class="{'add-button-disabled': loading || !edit}" :disabled="loading || !edit">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
    <users-history :selected_user="user" :edit="edit"></users-history>
</div>
</template>

<script>
import moment from 'moment';
import UsersHistory from "./UsersHistory";

export default {
    name: "UsersEdit",
    props: [
        "device_groups", "devices",
        'user',
        "edit",
    ],
    components: {
        UsersHistory
    },
    created: function () {
        this.edited_user.name = this.user.name;
        this.edited_user.email = this.user.email;
        this.edited_user.password = this.user.password;

        // this.edited_user.registration_date = {startDate: this.user.created_at, endDate: null};
        this.registration_date = {
            startDate: this.user.created_at,
            endDate: null
        };
        this.deletion_date = {
            startDate: this.user.deleted_at,
            endDate: null
        };
        // this.edited_user.blocking_start_date = {startDate: this.user.created_at, endDate: null};
        // this.edited_user.blocking_end_date = {startDate: this.user.created_at, endDate: null};
        this.blocking_start_date = {
            startDate: this.user.created_at,
            endDate: null
        };
        this.blocking_end_date = {
            startDate: this.user.created_at,
            endDate: null
        };
        this.edited_user.roles = this.user.roles;
        this.edited_user.groups = this.user.groups;

        this.device_groups.forEach((group) => {
            this.groupsOptions.push({
                label: group.title,
                code: group.id
            })
        })

        this.uploadRoles();

        // this.roles.forEach((role) => {
        //     this.rolesOptions.push({label:role.title, code: role.id})
        // })
    },
    data() {
        return {
            local_data: {
                format: 'mm/dd/yyyy',
                separator: " - ",
                applyLabel: "Подтвердить",
                cancelLabel: "Сбросить",
                daysOfWeek: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
                monthNames: [
                    "Янв",
                    "Февр",
                    "Март",
                    "Апр",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Авг",
                    "Сент",
                    "Окт",
                    "Нояб",
                    "Дек"
                ],
                firstDay: 1
            },
            edited_user: {},
            errors: {
                name: null,
                email: null,
                registration_date: null,
                password: null,
                roles: null,
                groups: null
            },
            notify_by_mail: false,
            blocking: false,
            blocking_start_date: null,
            blocking_end_date: null,
            registration_date: null,
            deletion_date: null,
            // v-select
            groupsOptions: [],
            selectedGroups: [],
            rolesOptions: [],
            currentRole: '',
            selectedRoles: [],
            currentGroup: null,
            //загрузка
            loading: false,
        }
    },

    watch: {
        selectedGroups: {
            handler: function () {},
            deep: true
        },
        groupsOptions: {
            handler: function () {},
            deep: true
        },
        rolesOptions: {
            handler: function () {},
            deep: true
        },
        selectedRoles: {
            handler: function () {},
            deep: true
        },
        currentRole: function (oldVal, newVal) {
            //this.storeRole()
        }
    },
    methods: {
        storeRole() {
            axios.post(`/role/assing/${this.user.id}`, {
                role: this.currentRole
            }).then(() => {
                this.sendNotify("Роль успешно обновлена", "success")
            }).catch(() => {
                this.sendNotify("Ошибка обновления роли", "error")

            })
        },
        uploadRoles() {
            axios.get('/role').then(resp => {
                this.currentRole = ''
                this.rolesOptions = []

                this.roles = resp.data.roles.data

                this.roles.forEach(item => {
                    this.rolesOptions.push(item.name)
                    console.log(item.name);
                })

                this.currentRole = this.user.roles[0].name;

            })

        },
        sendNotify(notification, type = 'primary') {
            this.$notify({
                title: 'Отчеты',
                text: notification,
                type: type
            });
        },
        submit() {
            this.loading = true;
            this.edited_user.registration_date = this.registration_date.startDate;
            this.edited_user.role = this.currentRole;
            this.edited_user.notify = this.notify_by_mail;
            this.edited_user.blocking = this.blocking;


            this.edited_user.blocked_from = this.blocking_start_date.startDate;
            this.edited_user.blocked_to = this.blocking_end_date.startDate;

            //this.edited_user.device_group_id = this.currentGroup.code || null;
            if (this.currentGroup) {
                this.edited_user.device_group_id = this.currentGroup.code;
            }else{
                this.edited_user.device_group_id = null;
            }
            axios
                .patch(`/user/${this.user.id}`, this.edited_user)
                .then(() => {
                    this.sendNotify("Пользовател успешно обновлен", "success")

                    this.storeRole()

                    setTimeout(() => {
                        window.location.href = "/users";
                    }, 2000)

                })
                .catch(error => {

                    this.sendNotify("Ошибка обновления пользователя", "error")
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
        removeGroup(group) {
            let removeIndex = this.selectedGroups.map(item => item.code).indexOf(group.code);
            this.selectedGroups.splice(removeIndex, 1);
            this.groupsOptions.push(group);
        },
        removeRole(role) {
            let removeIndex = this.selectedRoles.map(item => item.code).indexOf(role.code);
            this.selectedRoles.splice(removeIndex, 1);
            this.rolesOptions.push(role);
        },
        toObjectPage(id) {
            window.location.href = "/devices/" + id;
        },
        toGroupPage(id) {
            window.location.href = "/device-groups/" + id;
        },
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

#checkbox-2+.checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox+.checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox-2:checked+.checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox:checked+.checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

.checkbox-custom:focus+.checkbox-custom-label {
    outline: none;
}

.readonly {
    color: #9d9ea5 !important;
    fill: #9d9ea5;
}
</style>
