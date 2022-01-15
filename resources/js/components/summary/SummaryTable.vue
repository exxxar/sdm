<script src="../../app.js"></script>
<template>
    <div>
        <p v-if="recNames().length > 0">
            Найдено {{ records.length }} записей
        </p>
        <p>
            Проездов в выбранных устройствах <strong>{{ sum_passages }}</strong>
        </p>
        <p>
            Нарушений в выбранных устройствах
            <strong>{{ sum_violations }}</strong>
        </p>

        <div class="summary-table mt-3" v-if="!updating">
            <div class="table100 ver1" v-if="records || records.length > 0">
                <div class="table100-firstcol shadow-table100-firstcol">
                    <table>
                        <thead>
                            <tr class="row100 head">
                                <th class="column1">Дата</th>
                            </tr>
                        </thead>
                        <!--                        <tbody>-->
                        <!--                            <tr class="row100 body" v-for="date in dates">-->
                        <!--                                <td class="column1">{{date}}</td>-->
                        <!--                            </tr>-->
                        <!--                        </tbody>-->
                        <tbody>
                            <tr
                                class="row100 body"
                                v-for="(item, index) in recData()"
                            >
                                <td class="column1 pt-3 pb-3">
                                    {{ item.date }}
                                    <button
                                        class="btn btn-link  p-0"
                                        @click="syncByDate(item.date)"
                                        v-if="recData().length - 1 === index"
                                    >
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <perfect-scrollbar>
                    <div class="wrap-table100-nextcols">
                        <div class="table100-nextcols">
                            <table>
                                <thead>
                                    <!--                                    <tr class="row100 head">-->
                                    <!--                                        <th class="cell100" v-for="title in device_titles">{{title}}</th>-->
                                    <!--                                    </tr>-->
                                    <th
                                        class="cell100 cell-clip"
                                        :key="'serial' + index"
                                        v-for="(name, index) in recNames()"
                                        v-if="
                                            name !== 'date' &&
                                                name !== 'total' &&
                                                name !== 'average'
                                        "
                                    >
                                        <a
                                            href="#device"
                                            @click="openDevice(name)"
                                        >
                                            {{ name }}</a
                                        >
                                        <p>
                                            Проезды
                                            <strong>{{
                                                getPassagesSum(name)
                                            }}</strong>
                                        </p>
                                        <p>
                                            Нарушения
                                            <strong>{{
                                                getViolationsSum(name)
                                            }}</strong>
                                        </p>
                                    </th>
                                </thead>
                                <tbody>
                                    <!--                                    <tr class="row100 body" v-for="(d , key) in device_titles.length">-->
                                    <!--                                        <td class="cell100"-->
                                    <!--                                            v-bind:class="{ 'error-cell-border': getCell(dates[key], device_titles[index]).passages<=getCell(dates[index], device_titles[index]).violations }"-->
                                    <!--                                            v-if="not_efficiency_mode" v-for="(n , index) in dates.length"-->
                                    <!--                                        >-->
                                    <!--                                            <span v-if="has_passages">{{getCell(dates[key], device_titles[index]).passages}}</span>-->
                                    <!--                                            <span v-if="has_passages && has_violations"> / </span>-->
                                    <!--                                            <span v-if="has_violations" style="color:red">{{getCell(dates[key], device_titles[index]).violations}}</span>-->
                                    <!--                                        </td>-->
                                    <!--                                        <td class="cell100" v-if="!not_efficiency_mode" v-for="(n , index) in dates.length">{{getCell(dates[key], device_titles[index]).voltage}}</td>-->
                                    <!--                                    </tr>-->
                                    <tr
                                        class="row100 body"
                                        v-for="(record, index) in recData()"
                                    >
                                        <td
                                            class="cell100"
                                            :key="'data' + key"
                                            v-for="(value,
                                            propertyName,
                                            key) in record"
                                            v-if="
                                                not_efficiency_mode &&
                                                    propertyName !== 'date' &&
                                                    propertyName !== 'total' &&
                                                    propertyName !== 'average'
                                            "
                                            v-bind:class="{
                                                'error-cell-border':
                                                    record[
                                                        propertyName.toString()
                                                    ].passages <=
                                                    record[
                                                        propertyName.toString()
                                                    ].violations
                                            }"
                                        >
                                            <span v-if="has_passages">{{
                                                value.passages || 0
                                            }}</span>
                                            <span
                                                v-if="
                                                    has_passages &&
                                                        has_violations
                                                "
                                            >
                                                /
                                            </span>
                                            <span
                                                v-if="has_violations"
                                                style="color:red"
                                                >{{
                                                    value.violations || 0
                                                }}</span
                                            >
                                            <span
                                                @click="
                                                    syncByDateAndDevice(
                                                        propertyName,
                                                        record.date
                                                    )
                                                "
                                                v-if="
                                                    recData().length - 1 === index
                                                "
                                            >
                                                <i class="fas fa-sync"></i>
                                            </span>
                                        </td>
                                        <td
                                            class="cell100 "
                                            :key="'data-2-' + key"
                                            v-for="(value,
                                            propertyName,
                                            key) in record"
                                            v-bind:class="{
                                                'error-cell-border':
                                                    record[
                                                        propertyName.toString()
                                                    ].voltage <= 50
                                            }"
                                            v-if="
                                                !not_efficiency_mode &&
                                                    propertyName !== 'date' &&
                                                    propertyName !== 'total' &&
                                                    propertyName !== 'average'
                                            "
                                        >
                                            <span
                                                v-if="
                                                    value.voltage ||
                                                        value.voltage >= 0
                                                "
                                                >{{ value.voltage }} %</span
                                            >
                                            <span v-else>Нет данных</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </perfect-scrollbar>
                <div class="table100-lastcol shadow-table100-lastcol">
                    <table>
                        <thead>
                            <tr class="row100 head">
                                <th class="column1">Среднее</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="row100 body"
                                :key="'record' + index"
                                v-for="(record, index) in recData"
                            >
                                <td class="column1 " v-if="not_efficiency_mode">
                                    <span v-if="has_passages">{{
                                        record.average.passages
                                    }}</span>
                                    <span v-if="has_passages && has_violations">
                                        /
                                    </span>
                                    <span v-if="has_violations">{{
                                        record.average.violations
                                    }}</span>
                                </td>
                                <td
                                    class="column1 pt-3 pb-3"
                                    v-bind:class="{
                                        'error-cell-background':
                                            record.average.voltage <= 50
                                    }"
                                    v-if="!not_efficiency_mode"
                                >
                                    <span
                                        v-if="
                                            record.average.voltage ||
                                                record.average.voltage >= 0
                                        "
                                        >{{ record.average.voltage }} %</span
                                    >
                                    <span v-else>Нет данных</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div
                class="row w-100 mx-auto my-3 align-items-center justify-content-center"
                v-if="!recData() || recData().length == 0"
            >
                <div class="col-12">
                    <div
                        class="d-flex justify-content-center align-items-center"
                    >
                        <h3
                            class="sdm-primary-label sdm-primary-text"
                            style="font-size:1.375rem"
                        >
                            Нет записей
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="summary-table mt-3" v-else>
            <h3 class="text-center">
                Обновляем данные по всем устройствам за {{ updatingDate }}.
                После обновления страница перезагрузится. Примерное время от 10
                до 20 минут
            </h3>

            <div
                class="row w-100 mx-auto my-3 align-items-center justify-content-center"
            >
                <div class="col-12">
                    <div
                        class="d-flex justify-content-center align-items-center"
                    >
                        <div
                            class="spinner-border"
                            style="color: #7c34f2;"
                            role="status"
                        ></div>
                        <span class="ml-2" style="color: #7c34f2"
                            >Обновление...</span
                        >
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <p>{{ updateTime }} секунд</p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "SummaryTable",
    props: ["not_efficiency_mode", "has_violations", "has_passages", "records"],

    data() {
        return {
            updateTime: 600,
            updating: false,
            updatingDate: "",
            sum_passages: 0,
            sum_violations: 0
        };
    },
    created() {
        this.getAllData();

        console.log("records: ", this.records);
        console.log("records[0]", this.records[0]);
    },
    methods: {
        recData() {
            if (!this.records)
                return [];

            let data = [];
            for (let i = 0; i<this.records.length;i++) {
                let tmp = Object.keys(this.records[i]).sort(function (a, b) {
                    if (a > b) {
                        return 1;
                    }
                    if (a < b) {
                        return -1;
                    }
                    // a должно быть равным b
                    return 0;
                });

                let names_2 = [],
                    names_3 = [],
                    names_5 = [],
                    other = [];

                tmp.forEach(item => {
                    if (item !== "date" && item !== "average" && item !== "total") {
                        if (this.records[i][item].device_type_id === 2)
                            Object.assign(names_2, {item: this.records[i][item]});

                        if (this.records[i][item].device_type_id === 3)
                            Object.assign(names_3, {item: this.records[i][item]});

                        if (this.records[i][item].device_type_id === 5)
                            Object.assign(names_5, {item: this.records[i][item]});
                    }
                    else
                        Object.assign(other, {item: this.records[i][item]});
                });
                console.log("data step[",i,"]=>", [...names_2, ...names_5, ...names_3, ...other]);
                data[i].push( {...names_2, ...names_5, ...names_3, ...other});
                console.log("data=>", data[i]);
            }


            return data;
        },
        recNames() {
            let tmp = Object.keys(this.records[0]).sort(function(a, b) {
                if (a > b) {
                    return 1;
                }
                if (a < b) {
                    return -1;
                }
                // a должно быть равным b
                return 0;
            });

            let names_2 = [],
                names_3 = [],
                names_5 = [];

            tmp.forEach(item => {
                if (item !== "date" && item !== "average" && item !== "total") {
                    if (this.records[0][item].device_type_id === 2)
                        names_2.push(item);

                    if (this.records[0][item].device_type_id === 3)
                        names_3.push(item);

                    if (this.records[0][item].device_type_id === 5)
                        names_5.push(item);
                }
            });

            return [...names_2, ...names_5, ...names_3];
        },
        sendNotify(notification, type = "primary", duration = 5000) {
            this.$notify({
                title: "Устройства",
                text: notification,
                type: type,
                duration: duration
            });
        },

        openDevice(serial) {
            axios
                .post("/devices/open", {
                    serial: serial
                })
                .then(resp => {
                    window.location.href = "/devices/edit/" + resp.data.id;
                });
        },
        syncByDateAndDevice(device, date) {
            console.log(date, device);

            this.sendNotify(
                "Началось обновление данных по устройству, дождитесь окончания"
            );

            axios
                .post("/api/devices/info-device-correct", {
                    date: date,
                    serial: device
                })
                .then(resp => {
                    this.sendNotify(
                        `Статистика успешна обновлена! Устройство ${device} (${date})\nПроезды:
                    ${resp.data.passages || 0}\nНарушения: ${resp.data
                            .violations || 0}\nПинг: ${resp.data.ping || 0}`,
                        "success",
                        -1
                    );

                    this.records.forEach((item, index) => {
                        if (item.date === date) {
                            this.records[index][device].passages =
                                resp.data.passages || 0;
                            this.records[index][device].violations =
                                resp.data.violations || 0;
                            this.records[index][device].ping =
                                resp.data.ping || 0;
                        }
                    });
                })
                .catch(error => {
                    this.sendNotify("Произошла ошибка", "error");
                });
        },
        syncByDate(date) {
            this.sendNotify(
                "Началось дневное обновление данных за выбранную дату! Это может занять некоторое время! Не закрывайте страницу до окончания!"
            );
            this.updating = true;
            this.updatingDate = date;

            this.updateTime = 600;

            axios
                .post("/api/devices/info-date-correct", {
                    date: date
                })
                .then(resp => {
                    this.sendNotify(
                        "Статистика успешна обновлена! Страница будет перезагружена.",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                })
                .catch(error => {
                    this.sendNotify("Произошла ошибка", "error");
                    this.updating = false;
                });

            setInterval(() => {
                this.updateTime--;
            }, 1000);
        },
        getAllData() {
            let sum_v = 0;
            let sum_p = 0;

            for (let i = 0; i < this.records.length; i++) {
                let keys = Object.keys(this.records[i]);

                for (let key in keys) {
                    if (
                        keys[key] !== "date" &&
                        keys[key] !== "total" &&
                        keys[key] !== "average"
                    ) {
                        if (this.records[i][keys[key]]) {
                            sum_v += this.records[i][keys[key]].violations || 0;
                            sum_p += this.records[i][keys[key]].passages || 0;
                        }
                    }
                }
            }

            this.sum_passages = sum_p;
            this.sum_violations = sum_v;
        },

        getViolationsSum(serial) {
            let sum = 0;

            for (let i = 0; i < this.records.length; i++) {
                if (this.records[i][serial])
                    sum += this.records[i][serial].violations || 0;
            }

            return sum;
        },
        getPassagesSum(serial) {
            let sum = 0;

            for (let i = 0; i < this.records.length; i++) {
                if (this.records[i][serial])
                    sum += this.records[i][serial].passages || 0;
            }

            return sum;
        }
        // getCell(date, name) {
        //     if (this.summary && this.summary.length > 0 )
        //     {
        //         let index = this.summary.findIndex(item => item.name === name)
        //         if (index > -1) {
        //             let index1 = this.summary[index].dates.findIndex(item => item.date_title === date);
        //             if (index1 > -1) {
        //                 console.log(date, name, this.summary[index].dates[index1])
        //                 return this.summary[index].dates[index1]
        //             }
        //         }
        //         // let tmp = this.summary.filter(item => item.name === name);
        //         // let tmp_data = tmp[0].dates.filter(item => item.date_title === date)
        //         // console.log(tmp_data[0])
        //         // return tmp_data[0]
        //     }
        //     return {passages:0, violations:0, voltage:0}
        // },
    }
};
</script>

<style scoped>
.error-cell-border {
    border-color: red !important;
}

.error-cell-background {
    background: red !important;
    color: white !important;
}

.table100 {
    background-color: #fff;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

th,
td {
    font-weight: unset;
    padding-right: 10px;
}

.column1 {
    width: 100%;
    padding-left: 10px;
    padding-right: 10px;
}

.cell100 {
    width: 140px;
    padding: 15px 10px !important;
}

.table100 th {
    padding-top: 40px;
    padding-bottom: 40px;
}

.table100 td {
    padding-top: 6px;
    padding-bottom: 6px;
}

.table100 {
    width: 100%;
    position: relative;
}

.table100-firstcol {
    background-color: #fff;
    position: absolute;
    z-index: 1;
    width: 140px;
    top: 0;
    left: 0;
    text-align: center;
}

.table100-lastcol {
    background-color: #fff;
    position: absolute;
    z-index: 1000;
    width: 140px;
    top: 0;
    right: 0;
    text-align: center;
}

.table100-firstcol th,
.table100-lastcol th {
    position: sticky;
    top: 0;
    background: #050c42;
    color: white;
    border: 1px solid #050c42;
}

.table100-firstcol td,
.table100-lastcol td {
    position: sticky;
    background: #dfe1ee;
    color: black;
    border: 1px solid white;
}

.table100-firstcol table {
    background-color: #fff;
}

.wrap-table100-nextcols {
    padding-top: 20px;
}

.table100-nextcols table {
    table-layout: fixed;
    text-align: center;
    padding-right: 140px;
}

.shadow-table100-firstcol {
    box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -moz-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -webkit-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -o-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -ms-box-shadow: 7px 0px 14px -8px rgba(0, 0, 0, 0.4);
}

.shadow-table100-lastcol {
    box-shadow: -7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -moz-box-shadow: -7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -webkit-box-shadow: -7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -o-box-shadow: -7px 0px 14px -8px rgba(0, 0, 0, 0.4);
    -ms-box-shadow: -7px 0px 14px -8px rgba(0, 0, 0, 0.4);
}

.table100.ver1 th {
    font-family: Montserrat;
    font-size: 12px;
    color: white;
    line-height: 1.4;
}

.table100-nextcols th {
    font-family: Montserrat;
    font-size: 12px;
    color: black !important;
    background: #dfe1ee;
}

.table100-lastcol table td {
    width: 140px !important;
    padding: 15px 10px !important;
}

.table100.ver1 td {
    font-family: Montserrat;
    font-size: 12px;
}

.table100.ver1 .table100-firstcol td {
    color: #000;
}

.table100.ver1 .table100-nextcols th {
    border: 1px solid white;
}

.table100.ver1 .table100-nextcols td {
    border: 1px solid #dfe1ee;
    color: #000;
    background: white;
}

.table100.ver1 tr {
    border-bottom: 1px solid #dfe1ee;
}
</style>

<style>
.summary-table .ps {
    width: 100%;
    overflow: hidden;
    padding-left: 140px;
    padding-right: 100px;
    background: #7224f2 !important;
}

.summary-table .ps__rail-x {
    width: 100%;
    top: 0px !important;
    height: 20px !important;
    margin-left: 140px !important;
    margin-right: 140px !important;
    background: #7224f2 !important;
    opacity: 1 !important;
}

.summary-table .ps__thumb-x {
    background-color: #fff;
    height: 10px;
    bottom: 5px;
}

.summary-table .ps__thumb-x:hover {
    background-color: #fff;
    height: 10px;
    bottom: 5px;
}

.summary-table .ps__rail-x:hover > .ps__thumb-x,
.ps__rail-x:focus > .ps__thumb-x,
.ps__rail-x.ps--clicking .ps__thumb-x {
    background-color: #fff;
    height: 10px;
}

#page-content-wrapper {
    overflow: hidden;
}

.cell-clip {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
