<template>
    <layout :title="report_template.title" :info="false">
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
        <template v-slot:header>
            <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                <div
                    class="mr-2 d-flex align-items-center justify-content-center sdm-icon-button"
                    v-bind:class="{'active': report_template.important ==true}"
                    style="border: none !important;"
                >
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512.002 512.002;" xml:space="preserve">
                        <path fill="#7c34f2" v-bind:class="{'readonly': report_template.important !=true}" d="M511.267,197.258c-1.764-5.431-6.457-9.389-12.107-10.209l-158.723-23.065L269.452,20.157
                            c-2.526-5.12-7.741-8.361-13.45-8.361c-5.71,0-10.924,3.241-13.451,8.361l-70.988,143.827l-158.72,23.065
                            c-5.649,0.82-10.344,4.778-12.108,10.208c-1.765,5.431-0.293,11.392,3.796,15.377l114.848,111.954L92.271,482.671
                            c-0.966,5.628,1.348,11.314,5.967,14.671c2.613,1.898,5.708,2.864,8.818,2.864c2.388,0,4.784-0.569,6.978-1.723l141.967-74.638
                            l141.961,74.637c5.055,2.657,11.178,2.215,15.797-1.141c4.619-3.356,6.934-9.044,5.969-14.672l-27.117-158.081l114.861-111.955
                            C511.56,208.649,513.033,202.688,511.267,197.258z"/>
                    </svg>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <report-templates-show :report_template="report_template"></report-templates-show>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import ReportTemplatesShow from "../../components/reportTemplates/ReportTemplatesShow";
    export default {
        name: "ReportTemolatesShowPage",
        props:['user', 'report_template'],
        components:{Layout, ReportTemplatesShow},
    }
</script>

<style scoped>

</style>
