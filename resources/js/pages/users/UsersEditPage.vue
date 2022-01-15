<template>
    <div>
        <layout :title="!edit ? selected_user.name : 'Редактировать пользователя'" :info="false">
            <template v-slot:menu>
                <div class="row w-100 m-auto justify-content-end align-items-center">
                    <div style="z-index: 9" class="col-12 col-md-9">
                        <ol class="breadcrumb m-0 align-items-center"
                            style="background-color: transparent; padding-left: 0">
                            <li class="">
                                <a href="/home" style="color: #9d9ea5; text-decoration: none">
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
                                    href="/users"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Пользователи
                                </a>
                            </li>
                            <li class="">
                                <div
                                    class="mx-3 mdi mdi-dots-horizontal"
                                    style="color: rgb(157, 158, 165);font-size: 17px;"
                                >

                                </div>
                            </li>
                            <li class="" aria-current="page">
                                <a href="#"
                                   style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                                    {{selected_user.name}}
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-12 col-md-3 col-sm-6 pr-0 pl-0" v-if="edit">
                        <button v-if="selected_user.deleted_at == null" v-on:click="deleteUser"
                                class="btn w-100 my-1 mr-1 py-1 border-copy-button pr-0 mr-0">
                            <span style="font-size: 10px; border-bottom: 2px solid #d93030">
                                Удалить пользователя
                            </span>
                        </button>
                        <span v-else style="font-size: 10px; color: #d93030">
                                Удален
                        </span>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <users-edit
                    :user="selected_user"
                    :device_groups="device_groups"
                    :edit="selected_user.deleted_at ? false : edit"
                >
                    <!--                    :roles="roles"-->
                </users-edit>
            </template>
        </layout>
    </div>
</template>

<script>
    import Layout from "../../components/Layout";
    import UsersEdit from "../../components/users/UsersEdit";

    export default {
        name: "UsersEditPage",
        props: ['user', 'device_groups', "selected_user", "edit"
            // 'roles'
        ],
        components: {
            Layout, UsersEdit
        },
        data: () => ({}),
        methods: {
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Отчеты',
                    text: notification,
                    type: type
                });
            },
            deleteUser() {

                axios
                    .delete(`/user/${this.selected_user.id}`)
                    .then(resp => {
                        console.log(resp);
                        this.sendNotify('Вы успешно удалили пользователя', 'success');

                        window.location.href = `/users`;
                    })
                    .catch(function (resp) {
                        this.sendNotify("Ошибка удаления", "error")
                    });


            }
        }
    }
</script>

<style scoped>

</style>
