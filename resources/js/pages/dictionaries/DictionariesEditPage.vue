<template>
    <layout :title="''+dictionary_type_title" :info="false">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
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
                            <div class="mx-3 mdi mdi-dots-horizontal"
                                 style="color: rgb(157, 158, 165);font-size: 17px;">
                            </div>
                        </li>
                        <li class="" aria-current="page">
                            <a
                                href="/dictionary-types"
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Справочники
                            </a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal"
                                 style="color: rgb(157, 158, 165);font-size: 17px;">
                            </div>
                        </li>
                        <li class="" aria-current="page">
                            <a href="#"
                               style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                                {{dictionary_type_title}}
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-12 col-md-3">
                    <user-menu :user="user"></user-menu>
                </div>
                <div class="col-12" style="border-bottom: 1px solid #e3e3e5"
                ></div>
            </div>
        </template>
        <template v-slot:main>
            <dictionaries-edit
                :dictionary="dictionary"
                :dictionary_type_title="dictionary_type_title"
            >

                <template v-slot:roles>
                    <roles-and-permissions/>
                </template>

                <template v-slot:device_types>
                    <device-type/>
                </template>

                <template v-slot:regions>
                    <regions/>
                </template>

                <template v-slot:locations>
                    <locations/>
                </template>
            </dictionaries-edit>


        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import DictionariesEdit from "../../components/dictionaries/DictionariesEdit";
    import RolesAndPermissions from "../../components/roles/RolesAndPermissions";
    import DeviceType from "../../components/deviceTypes/DeviceTypes";
    import Regions from "../../components/regions/Regions";
    import Locations from "../../components/locations/Location";


    export default {
        name: "DictionariesEditPage",
        props: ['user', 'dictionary_type_title', 'dictionary'],
        components: {Layout, DictionariesEdit, RolesAndPermissions, DeviceType, Regions, Locations}
    }
</script>

<style scoped>

</style>
