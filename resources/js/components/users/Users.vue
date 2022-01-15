<template>
<div>
    <div class="row mx-auto my-2 align-items-center" v-if="selected.length > 0" style="padding: 15px; border: 1px solid #dfe1ee; border-radius: 5px">
        <div class="col-8">
            <div class="row w-100 mx-auto align-items-center">
                <div style="display: flex" class="mr-2 mt-1" :key="user.id" v-for="user in selected">
                    <div class="mr-1">{{ user.name }}</div>
                    <div v-on:click="uncheck(user)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
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
        <div class="col-4 custom-filter" style="display: flex; align-items: center; justify-content: flex-end">
            (всего {{ selected.length }})
            <button class="btn border-copy-button pt-0 pb-0" v-on:click="checkAll()">
                <span style="font-size: 10px; border-bottom: 2px solid #7c34f2">
                    Выбрать все</span>
            </button>
            <button class="btn mdi mdi-close" v-on:click="uncheckAll()" style="height:36px; width: 36px; min-width: 36px; background: transparent; color: red; font-size: 15px"></button>
        </div>
    </div>

    <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-2 align-items-center justify-content-center sdm-primary-text">
        <div class="custom-filter col-2 pl-0" @click="sort('name')" style="cursor: pointer;">
            Фамилия Имя
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'name'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-2 px-1" @click="sort('roles')" style="cursor: pointer; padding-left: 30px">
            Роль
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'roles'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-2 px-1" @click="sort('email')" style="cursor: pointer; display: flex;flex-wrap: nowrap; align-items: center; padding-left: 0;">
            Почта
            <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'email'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-4 pl-1" style="cursor: pointer; padding-left: 0;" @click="sort('device_groups')">
            Доверенные группы устройств
            <i v-bind:class="{ 'sort-icon-rotation': currentSortDir == 'asc'}" v-if="currentSort == 'device_groups'" class="fas fa-angle-down filter-icon">
            </i>
        </div>
        <div class="custom-filter col-2 pr-0">
        </div>
    </div>
    <div class="row w-100 mx-auto align-items-center justify-content-center">
        <div class="col-12 p-0" :key="item.id" v-for="(item, index) in sortedList">
            <div v-bind:class="{ 'checked-border': isSelected(item.id) }" class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center" style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap">
                <div class="col-md-2 pl-0">
                    <div class="row w-100 my-1 align-items-center justify-content-start">
                        <div class="form-check form-check-inline custom-menu-checkbox" style="padding-left: 30px">
                            <input :id="'checkbox-' + index + 2" :name="'checkbox-' + index + 2" class="checkbox-custom" @change="check(item)" type="checkbox" v-model="item.selected" />
                            <label :id="'checkbox-' + index + 2" :for="'checkbox-' + index + 2" style="font-size:14px;" class="checkbox-custom-label">
                            </label>
                            <a class="main-link" :href="`/users/${item.id}`">
                                {{ item.name }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 px-1" style="display: flex; align-items: center; ">
                    <div class="d-flex table-text sdm-primary-text flex-wrap align-items-center">

                        <p style="    word-break: break-word;" v-for="role in item.roles">{{role.name}}</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 px-1">
                    <div class="d-flex table-text sdm-primary-text" style="word-break: break-word;">
                        {{item.email}}
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 px-1">
                    <div v-if="item.device_groups.length>0" class="d-flex table-text">
                        <a class="additional-link" :href="`/device-groups/${item.device_groups[0].id}`">
                            {{ item.device_groups[0].title }}
                            <i class="fas fa-arrow-right filter-icon fa-xs">
                            </i>
                        </a>
                    </div>
                    <!--     <div class="row w-100 m-auto align-items-center">
                            <div class="col-5 pr-1 sdm-primary-text">
                                Название<br>группы
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                     y="0px"
                                     width="13px" height="13px" viewBox="0 0 612 612"
                                     style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                    <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                </svg>
                            </div>
                            <div class="col-5 px-1 sdm-primary-text">
                                Группа<br>устройств
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                     y="0px"
                                     width="13px" height="13px" viewBox="0 0 612 612"
                                     style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                                    <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                                </svg>
                            </div>
                            <div class="col-2 pl-1">
                                <popover
                                    v-if="item.groups !==null && item.groups !=undefined && item.groups.length>2"
                                    class="sdm-popover"
                                    :name="'' + item.id"
                                >
                                    <perfect-scrollbar>
                                        <div
                                            :key="group.id"
                                            v-for="(group, groupIndex) in item.groups"
                                            v-if="groupIndex > 1"
                                            class="mb-1 text-truncate" style="max-width: 135px"
                                        >
                                            <a :href="'/device-groups/'+group.id" class="sdm-primary-text"
                                               style="color:black;text-decoration: none;">
                                                {{group.name}}
                                                <svg
                                                    version="1.1"
                                                    id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    x="0px"
                                                    y="0px"
                                                    width="16px"
                                                    height="15px"
                                                    viewBox="0 0 612 612"
                                                    style="enable-background:new 0 0 612 612; overflow:unset;"
                                                    xml:space="preserve"
                                                >
                                                    <path
                                                        fill="#7224f2"
                                                        d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    </perfect-scrollbar>
                                </popover>
                                <button
                                    v-if="item.groups !==null && item.groups !=undefined && item.groups.length>2"
                                    v-popover.top="{ name: '' + item.id }"
                                    type="button"
                                    class="mx-2 btn mdi mdi-dots-horizontal"
                                    style="background:transparent; color: #7c34f2;font-size: 17px;"
                                >
                                </button>
                            </div>
                        </div>-->
                </div>
                <div class="col-12 col-sm-12 col-md-2 pr-0">
                    <div style="flex-wrap: nowrap; justify-content: end" class="row w-100 mx-auto my-1 align-items-center">
                        <div style="display: flex" class="mr-2">
                            <button class="btn mr-2" v-if="!item.deleted_at" :disabled="!can('Просмотр пользователей')" v-on:click="showUser(item.id)" style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF" title="Показать пользователя">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 492 492" style="transform: rotate(180deg); fill: white; width: 10px; height:10px; min-width: 10px; min-height:10px" xml:space="preserve">
                                    <path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                            C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                            c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                            l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z" />
                                </svg>
                            </button>
                            <button v-if="!item.deleted_at" class="btn" :disabled="!can('Изменение пользователей')" v-on:click="editUser(item.id)" style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;" title="Редактировать пользователя">
                                <svg id="Capa_1" style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px" enable-background="new 0 0 488.471 488.471" height="512" viewBox="0 0 488.471 488.471" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m166.093 240.214h88.205v194.288h-88.205z" transform="matrix(.707 -.707 .707 .707 1.415 9.959)" />
                                    <path d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z" />
                                </svg>
                            </button>
                            <button v-if="!item.deleted_at" class="btn" :disabled="!can('Удаление пользователей')" v-on:click="checkForRemove(item)" style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;" title="Удалить пользователя">
                                <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" xml:space="preserve">
                                    <path fill="red" d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z" />
                                </svg>
                            </button>
                            <div style="display: flex;
                                            align-items: center;
                                            width: 116px;
                                            flex-direction:column;
                                            justify-content: center;" v-if="item.deleted_at">
                                <p style="font-size: 12px; color: red; margin-bottom: 0">
                                    Удален
                                </p>
                                <a href="#restore" style="font-size: 12px; color: green; margin-bottom: 0;" @click="resotreUser(item.id)" :disabled="!can('Восстановление пользователей')">
                                    Восстановить
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <modal id="delete-all-users">
        <template v-slot:header>
            Групповое удаление пользователей
        </template>
        <template v-slot:main>

            <div v-if="selected.length>0">
                <p>Вы выбрали следующие элементы:</p>

                <div class="row mx-auto my-2 align-items-center" v-if="selected.length > 0">
                    <div class="col-12">
                        <div class="row w-100 mx-auto align-items-center">
                            <div style="display: flex" class="mr-2 mt-1" :key="user.id" v-for="user in selected">
                                <div class="mr-1">{{ user.name }}</div>
                                <div v-on:click="uncheck(user)" style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px">
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
                    <div class="col-12 custom-filter" style="display: flex; align-items: center; justify-content: flex-end">
                        (всего {{ selected.length }})
                        <button class="btn border-copy-button pt-0 pb-0" v-on:click="checkAll()">
                            <span style="font-size: 10px; border-bottom: 2px solid #7c34f2">
                                Выбрать все</span>
                        </button>
                        <button class="btn mdi mdi-close" v-on:click="uncheckAll()" style="height:36px; width: 36px; min-width: 36px; background: transparent; color: red; font-size: 15px"></button>
                    </div>
                </div>

                <div class="row d-flex justify-content-end">
                    <div class="col-4">
                        <button :disabled="!can('Удаление пользователей')" class="btn w-100 btn-dark my-1 mr-1 py-2" @click="removeAll" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
            <h5 v-else>Вы не выбирали ни одного пользователя</h5>

        </template>
    </modal>

    <modal id="accept-remove">
        <template v-slot:header>
            Единичное удаление пользователя
        </template>
        <template v-slot:main>

            <h4 class="w-100 text-center" v-if="removedUser">Вы хотите удалить <strong>{{removedUser.name}}</strong>
                ?</h4>
            <p class="text-center mt-2" v-if="removedUser">{{removedUser.email}}</p>
            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <button :disabled="!can('Удаление пользователей')" class="btn w-100 btn-dark my-1 mr-1 py-2" @click="deleteUser( removedUser.id, true)" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                        Удалить
                    </button>
                </div>
            </div>

        </template>
    </modal>
    <modal id="accept-remove-current-user">
        <template v-slot:header>
            Единичное удаление пользователя
        </template>
        <template v-slot:main>

            <h4 class="w-100 text-center" v-if="removedUser">Вы точно хотите удалить пользователя под которым вы авторизированы <strong>{{removedUser.name}}</strong>
                ?</h4>
            <p class="text-center mt-2" v-if="removedUser">Это может превести к непредсказуемым последствиям!</p>
            <p class="text-center mt-2" v-if="removedUser">{{removedUser.email}}</p>
            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <button :disabled="!can('Удаление пользователей')" class="btn w-100 btn-dark my-1 mr-1 py-2" @click="deleteUser( removedUser.id, true)" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                        Удалить
                    </button>
                </div>
            </div>

        </template>
    </modal>
</div>
</template>

<script>
import Modal from "../../components/Modal";

export default {
    components: {
        Modal
    },
    name: "Users",
    props: [
        "user",
        "users",
        "name",
        "role",
        "email",
        "groupId",
        "deleted",
    ],
    data: () => ({
        // sort
        currentSort: "name",
        currentSortDir: "asc",
        //checkbox
        data: [],
        selected: [],
        removedUser: null,
    }),
    created() {



        // this.getData();
        this.users.forEach(item => {
            item.selected = false;
        });
    },
    computed: {
        sortedList: function () {
        console.log(this.groupId)
            if (this.currentSort === 'device_groups')
                return this.filteredList.sort((a, b) => {

                    if (a.device_groups.length < b.device_groups.length ||
                        this.currentSortDir === "desc")
                        return -1;

                    if (a.device_groups.length > b.device_groups.length ||
                        this.currentSortDir === "asc")
                        return 1;

                    let modifier = 1;
                    if (this.currentSortDir === "desc") modifier = -1;
                    if (a.device_groups[0].title < b.device_groups[0].title)
                        return -1 * modifier;
                    if (a.device_groups[0].title > b.device_groups[0].title)
                        return 1 * modifier;
                    return 0;
                });

            if (this.currentSort === "roles")
                return this.filteredList.sort((a, b) => {

                    let modifier = 1;
                    if (this.currentSortDir === "desc") modifier = -1;
                    if (a.roles[0].name < b.roles[0].name)
                        return -1 * modifier;
                    if (a.roles[0].name > b.roles[0].name)
                        return 1 * modifier;
                    return 0;
                });

            return this.filteredList.sort((a, b) => {

                let modifier = 1;
                if (this.currentSortDir === "desc") modifier = -1;
                if (a[this.currentSort] < b[this.currentSort])
                    return -1 * modifier;
                if (a[this.currentSort] > b[this.currentSort])
                    return 1 * modifier;
                return 0;
            });
        },
        filteredList() {
            return this.users.filter(item => {

                let role = true,
                    name = true,
                    email = true,
                    group = true,
                    deleted = true;

                if (this.name !== "") {
                    if (item.name) {
                        name = item.name
                            .toLowerCase()
                            .includes(this.name.toLowerCase());
                    } else {
                        name = false;
                    }
                }

                if (this.email !== "") {
                    if (item.email) {
                        email = item.email
                            .toLowerCase()
                            .includes(this.email.toLowerCase());
                    } else {
                        email = false;
                    }
                }
                if (this.groupId !== "") {
                    if (item.device_groups.length > 0 ) {
                        group = item.device_groups[0].id === this.groupId;
                    } else {
                        group = false;
                    }
                }

                if (this.role !== "") {
                    if (item.roles.length > 0) {
                        role = item.roles[0].name === this.role;
                    } else {
                        role = false;
                    }
                }

                if (!this.deleted) {
                    if (item.deleted_at) {
                        deleted = false;
                    }
                }

                return (
                    name &&
                    role &&
                    group &&
                    email &&
                    deleted
                );
            });
        },

    },
    watch: {

        data: {
            handler: function () {},
            deep: true
        },

    },
    methods: {
        can(permissions){
          return window.can(permissions)
        },
        removeAll() {
            this.selected.forEach(item => {
                this.deleteUser(item.id, true)
            })
        },
        sort: function (s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        uncheck: function (user) {
            let index = this.selected.findIndex(el => el.id === user.id);
            if (index !== -1) {
                let user_index = this.filteredList.findIndex(el => el.id === user.id);
                this.filteredList[user_index].selected = false;
                this.selected.splice(index, 1);
            }
        },
        checkAll: function () {
            this.selected = [];
            this.users.forEach(user => {
                user.selected = true;
                this.selected.push(user);
            });
        },
        uncheckAll: function () {
            this.users.forEach(item => {
                item.selected = false;
            });
            this.selected = [];
        },
        check: function (item, selected) {
            let index = this.selected.findIndex(el => el.id === item.id);
            if (index !== -1) {
                this.selected.splice(index, 1);
            } else {
                this.selected.push(item);
            }
        },
        isSelected: function (id) {
            const index = this.selected.map(item => item.id).indexOf(id);
            return index !== -1;
        },
        getData() {
            axios
                .get("/user")
                .then(resp => {
                    this.data = resp.data.data;

                    this.data.forEach(item => {
                        item.selected = false;
                    });
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        editUser(id) {
            window.location.href = `/users/edit/${id}`;
        },
        showUser(id) {
            window.location.href = `/users/${id}`;
        },
        resotreUser(id) {

            axios
                .get(`/user/restore/${id}`)
                .then(resp => {
                    this.sendNotify('Вы успешно восстановили пользователя', 'success');
                    window.location.href = `/users`;
                })
                .catch(() => {
                    this.sendNotify('Ошибка восстановления пользователя', 'error');
                });

        },
        checkForRemove(user) {
            this.removedUser = user
            if (this.user.id === user.id) {
                $('#accept-remove-current-user').modal('show')

            } else {
                $('#accept-remove').modal('show')
            }

        },
        deleteUser(id, needRefresh = false) {
            const removeIndex = this.data.map(item => item.id).indexOf(id);
            this.data.splice(removeIndex, 1);
            axios
                .delete(`/user/${id}`)
                .then(resp => {
                    console.log(resp);
                    this.sendNotify('Вы успешно удалили пользователя', 'success');
                    //this.data = resp.data.data;

                    if (needRefresh)
                        window.location.href = `/users`;
                })
                .catch(function (resp) {
                    console.log(resp);
                });
        },
        sendNotify(notification, type = 'primary') {
            this.$notify({
                title: 'Пользователи',
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style scoped>
.sort-icon-rotation {
    transform: rotate(180deg);
}

.icon-grey-border {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: solid 1px #dfe1ee;
    border-radius: 50px;
    min-width: 28px;
    margin-right: 8px;
}

.custom-icon {
    width: 12px;
    height: 12px;
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

.sdm-popover {
    left: -96px !important;
    top: -108px !important;
    height: 120px !important;
    width: 155px !important;
    font-size: 12px;
    padding-top: 15px;
    padding-left: 15px;
    padding-bottom: 15px;
    padding-right: 0px;
}

.sdm-popover.dropdown-position-top::before {
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #fff;
    bottom: -6px;
    left: calc(84% - 6px);
    filter: drop-shadow(0px 2px 2px rgba(52, 73, 94, 0.1));
}
</style><style>
.sdm-popover .ps {
    width: 100%;
    height: 90px;
}

.sdm-popover .ps .ps__rail-y {
    background: #fff !important;
    opacity: 1 !important;
    width: 3px !important;
}

.sdm-popover .ps .ps__thumb-y {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}

.sdm-popover .ps .ps__thumb-y:hover {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}

.sdm-popover .ps .ps__rail-y:hover>.ps__thumb-y,
.ps__rail-y:focus>.ps__thumb-y,
.ps__rail-y.ps--clicking .ps__thumb-y {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}
</style>
