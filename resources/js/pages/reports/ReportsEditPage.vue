<template>
    <layout title="Редактирование отчета" :info="false">
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
                            <div
                                class="mx-3 mdi mdi-dots-horizontal"
                                style="color: rgb(157, 158, 165);font-size: 17px;"
                            ></div>
                        </li>
                        <li class="" aria-current="page">
                            <a
                                href="/reports"
                                style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                            >
                                Отчеты
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
        <template v-slot:main>
            <reports-edit
                :objects="objects"
                :users="users"
                :report_templates="report_templates"
                :roles="roles"
                :report="report"
            >
            </reports-edit>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import ReportsEdit from "../../components/reports/ReportsEdit";
    export default {
        name: "ReportsEditPage",
        props:['user', 'objects', 'users', 'roles', 'report_templates', 'report'],
        components:{Layout, ReportsEdit},
    }
</script>

<style scoped>

</style>
