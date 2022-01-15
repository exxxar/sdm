<template>
    <div>
        <layout
            title="Пользователи"
            :info="true"
            :info_text="'Это пользователи.'"
        >
            <template v-slot:menu>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center"
                >
                    <div style="z-index: 9" class="col-12 col-md-9">
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
                                    href="/users"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Пользователи
                                </a>
                            </li>
                        </ol>
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
                            v-on:click="deleteAll"
                            class="btn w-100 my-1 mr-1 py-1 border-copy-button pr-0 mr-0"
                        >
                            <span
                                style="font-size: 10px; border-bottom: 2px solid #d93030"
                            >
                                Удалить выбранные
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <button
                            v-on:click="addUser"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Добавить пользователя
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div
                    class="row w-100 m-auto justify-content-center align-items-center"
                >
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12 col-md-3 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12 pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Поиск по имени
                                        </p>
                                        <input
                                            v-model="name"
                                            class="form-control"
                                            placeholder="Все"
                                            style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Роль
                                        </p>

                                        <select
                                            class="form-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                            v-model="role"
                                        >
                                            <option value="" selected
                                                >Все</option
                                            >
                                            <option
                                                v-for="item in optionRoles"
                                                :value="item"
                                                >{{ item }}</option
                                            >
                                            <!--                                            todo: uncomment and add list of roles -->
                                            <!--                                            <option v-if="item in roles" :key="item.id" :value="item.id">{{item.name}}</option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Поиск по почте
                                        </p>
                                        <input
                                            v-model="email"
                                            class="form-control"
                                            placeholder="Все"
                                            style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 p-0">
                                <div
                                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                                >
                                    <div class="col-12  pl-0 pr-2">
                                        <p
                                            class="mb-1 d-flex sdm-secondary-text"
                                        >
                                            Группы устройств
                                        </p>
                                        <select
                                            v-model="groupId"
                                            class="form-select"
                                            style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                                        >
                                            <option value="" selected>
                                                Все
                                            </option>
                                            <option
                                                :key="device_group.id"
                                                :value="device_group.id"
                                                v-for="device_group in device_groups_without_deleted"
                                            >
                                                {{ device_group.title }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400; visibility: hidden"
                        >
                            удаленные
                        </p>
                        <div class="form-check form-check-inline float-right">
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
                        class="col-12 col-md-1"
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
                                    name || email || groupId || deleted || role
                            }"
                            :disabled="
                                !name && !email && !groupId && !deleted && !role
                            "
                        >
                            Сбросить
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <users
                    :name="name"
                    :email="email"
                    :groupId="groupId"
                    :deleted="deleted"
                    :role="role"
                    :users="users"
                    :user="user"
                ></users>
                <!--
                <modal id="delete-user">
                    <template v-slot:header>
                        Групповое удаление пользователей
                    </template>
                    <template v-slot:body>
                        Вы выбрали следующие элементы:
                    </template>
                </modal>-->
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import Users from "../../components/users/Users";
import Modal from "../../components/Modal";

export default {
    name: "UsersPage",
    props: ["user", "users", "devices", "device_groups"],
    components: {
        Layout,
        Users,
        Modal
    },
    data: () => ({
        // filters
        deleted: false,
        device_groups_without_deleted: [],
        name: "",
        role: "",
        email: "",
        groupId: "",
        allDelete: false,
        optionRoles: []
    }),
    mounted() {
        this.uploadRolesAndPermissions();
        this.device_groups.forEach(group => {
            if (group.deleted_at === null) 
                this.device_groups_without_deleted.push(group);
        });

        console.log(this.device_groups_without_deleted);
    },
    methods: {
        resetFilters() {
            this.name = "";
            this.email = "";
            this.groupId = "";
            this.role = "";
            this.deleted = false;
        },
        addUser() {
            window.location.href = "/users/add";
        },
        deleteAll() {
            $("#delete-all-users").modal("show");
            this.sendNotify(
                "Не стоит необдуманно удалять всех пользователей! ОСТОРОЖНО!"
            );
        },
        uploadRolesAndPermissions() {
            axios.get("/role").then(resp => {
                this.optionRoles = [];

                this.roles = resp.data.roles.data;

                this.roles.forEach(item => {
                    this.optionRoles.push(item.name);
                });
            });
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Пользователи",
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style scoped>
.sdm-primary-text {
    font-family: Montserrat;
    font-size: 12px;
    font-weight: 500;
}
.sdm-secondary-text {
    font-family: Montserrat;
    font-size: 9px;
    color: #959597;
    font-weight: 400;
}
.form-select {
    display: block;
    width: 100%;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    font-size: 12px;
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
.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}
.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}
.custom-select {
    color: black;
    font-weight: 500;
    font-size: 12px;
    border-color: #dfe1ee;
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
</style>
