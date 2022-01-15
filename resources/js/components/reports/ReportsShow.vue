<template>
    <div class="row w-100 m-auto align-items-start justify-content-center">
        <div class="col-8">
            <div class="row w-100 my-auto mb-2 align-items-start justify-content-center">
                <div class="col-6 px-0">
                    <div class="row w-100 m-auto align-items-center justify-content-center">
                        <div class="col-12 pl-0 pr-1 text-wrap">
                            <p class="mb-1 d-flex sdm-secondary-text mt-3">
                                Отчет по
                            </p>
                            <span v-if="report.report_of == 1">Устройству</span>
                            <span v-if="report.report_of == 2">Группе устройств</span>
                            <span v-if="report.report_of == 3">Рубежу</span>
                            <span v-if="report.report_of == 4">Группа рубежей</span>
                        </div>
                        <div class="col-12 pl-0 pr-1 text-wrap">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                               Устройство/рубеж/группа
                            </p>
                            {{report.object.title}}
                        </div>
                        <div class="col-12 pl-0 pr-1">
                            <p class="mb-1 d-flex sdm-secondary-text mt-2">
                                Параметр
                            </p>
                            <span v-if="report.parameter == 'passages'">
                                Проезды
                            </span>
                            <span v-if="report.parameter == 'violations'">
                                Нарушения
                            </span>
                            <span v-if="report.parameter== 'voltage'">
                                Работоспособность
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 px-0">
                    <div class="col-12 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text mt-3">
                            Период
                        </p>
                        <span v-if="report.period == 'day'">За последние сутки</span>
                        <span v-if="report.period == 'week'">За неделю</span>
                        <span v-if="report.period == 'month'">За месяц</span>
                        <span v-if="report.period == 'year'">За год</span>
                        <span v-if="report.period == 'date-range'">Произвольный: {{report.start_period_date | moment('DD.MM.YYYY')}} - {{report.end_period_date | moment('DD.MM.YYYY')}}</span>
                    </div>
                    <div class="col-12 pl-1 pr-0">
                        <p class="mb-1 d-flex sdm-secondary-text mt-2" v-if="report.automatic">
                            Регулярность
                        </p>
                        <span v-if="report.automatic&&report.regularity == 'day'">Раз в день</span>
                        <span v-if="report.automatic&&report.regularity == 'week'">Раз в неделю</span>
                        <span v-if="report.automatic&&report.regularity == 'month'">Раз в месяц</span>
                        <span v-if="report.automatic&&report.regularity == 'year'">Раз в год</span>
                    </div>
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
                    <div class="row w-100 mx-auto mt-2 align-items-center justify-content-start" v-if="report.mailing">
                        <div style="display: flex" class="mr-2 mb-1" :key="index" v-for="(mail, index) in report.recipients_emails">
                            <div class="mr-1">{{mail}}</div><span v-if="index != report.recipients_emails.length-1">, </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "ReportsShow",
        props:['report'],
    }
</script>

<style scoped>

</style>
