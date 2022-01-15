<template>
    <layout title="Редактирование шаблона" :info="false">
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
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Отчеты
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
                                href="/report-templates"
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Шаблоны отчетов
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
                                href="/report-templates"
                                style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                            >
                                Название шаблона
<!--                                {{report_template}}-->
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
            <report-templates-edit
                :objects="objects"
                :users="users"
                :report_template="report_template"
                :roles="roles"
            >
            </report-templates-edit>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import ReportTemplatesEdit from "../../components/reportTemplates/ReportTemplatesEdit";

    export default {
        name: "ReportTemplatesEditPage",
        props:['user', 'objects', 'users', 'report_template', 'roles'],
        components:{Layout, ReportTemplatesEdit},
    }
</script>

<style scoped>

</style>
