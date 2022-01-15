<template>
    <div class="row w-100 m-auto align-items-start justify-content-center">
        <div class="col-8">
            <div class="row w-100 my-auto mb-2 align-items-start justify-content-center">
                <div class="col-12 pl-0 pr-1 text-wrap">
                    <p class="mb-1 d-flex sdm-secondary-text mt-3">
                        Отчет по
                    </p>
                    <span v-if="report_template.report_of == 1">Устройству</span>
                    <span v-if="report_template.report_of == 2">Группе устройств</span>
                    <span v-if="report_template.report_of == 3">Рубежу</span>
                </div>
                <div class="col-12 pl-0 pr-1 text-wrap">
                    <p class="mb-1 d-flex sdm-secondary-text mt-2">
                        Устройство/рубеж/группа
                    </p>
                    {{report_template.object.title}}
                </div>
                <div class="col-12 pl-0 pr-1">
                    <p class="mb-1 d-flex sdm-secondary-text mt-2">
                        Параметр
                    </p>
                    <span v-if="report_template.parameter == 'passages'">
                        Проезды
                    </span>
                    <span v-if="report_template.parameter == 'violations'">
                        Нарушения
                    </span>
                    <span v-if="report_template.parameter== 'voltage'">
                        Работоспособность
                    </span>
                </div>
            </div>
        </div>
        <div class="col-4 px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12 recipients">
                    <p class="mb-1 mr-3 d-inline-flex sdm-secondary-text">
                        Адресаты:
                    </p>
                </div>
                <div class="col-12">
                    <div class="row w-100 mx-auto mt-2 align-items-center justify-content-start" v-if="report_template.mailing">
                        <div style="display: flex" class="mr-2 mb-1" :key="index" v-for="(mail, index) in report_template.recipients_emails">
                            <div class="mr-1">{{mail}}</div><span v-if="index != report_template.recipients_emails.length-1">, </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReportTemplatesShow",
        props:['report_template'],
    }
</script>

<style scoped>

</style>
