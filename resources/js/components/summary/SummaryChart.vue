<template>
    <div id="chart" class="w-100 h-100 m-auto px-1">
        <highcharts :options="chartOptions" ref="highchart"></highcharts>
    </div>
</template>

<script>
    import moment from 'moment';



    export default {
        name: "SummaryChart",
        props:['charts', 'not_efficiency_mode', 'has_violations', 'has_passages', 'type'],
        data() {
            return {

                chartOptions: {
                    chart: {
                        type: 'spline',
                        zoomType: 'x',
                        backgroundColor: null,
                        height: 550,
                        renderTo: 'chart',
                        reflow: true
                    },

                    legend: {
                        symbolWidth: 40
                    },

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: ''
                        },
                        accessibility: {
                            description: ''
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },

                    xAxis: {
                        title: {
                            text: ''
                        },
                        accessibility: {
                            description: ''
                        },
                        type: 'datetime',
                        labels: {
                            format: '{value:%d.%m.%Y}',
                        }
                    },

                    tooltip: {
                        enabled: false,
                        backgroundColor: null,
                        borderWidth: 0,
                        shadow: false,
                        useHTML: true,
                        style: {
                            pointerEvents: 'auto'
                        },
                        stickOnContact:true,
                        hideDelay:10000,
                        headerFormat: '',
                        pointFormat: (
                            '<div class="p-2" style="width:250px"> <div class="row w-100 m-auto sdm-primary-text">{point.options.custom.serial}' +
                            '</div>' +
                            '                            <div class="row w-100 mx-auto my-1 align-items-center">' +
                            '                               <a id="boundary" class="p-0  simple-title"  href=\"/boundaries/edit/{point.options.custom.device_boundary.id}'+'\"'+
                            ' style="background: transparent; color:#7224f2; text-decoration: none">' +
                            '  <div class="sdm-primary-text" style="color: black">' +
                            '                                <span>'+
                                '{point.options.custom.device_boundary.title}</span>' +
                                '<i class="mdi mdi-arrow-right-circle-outline" style="color:#7224f2"></i> '+
                            '                            </div>' +
                            '                            </a>' +
                            '                            </div>' +
                            '                            <div class="row w-100 m-auto">' +
                            '                                <div class="col-12 p-0">' +
                            '                                <div class="sdm-secondary-text">' +
                            '                                Нарушения за период - <span style="color: red">{point.options.custom.violations}</span>' +
                            '                                </div>' +
                            '                                </div>' +
                            '                                <div class="col-12 p-0">' +
                            '                                <div class="sdm-secondary-text">' +
                            '                                Проездов за период - <span style="color: green">{point.options.custom.passages}</span>' +
                            '                                </div>' +
                            '                                </div>' +
                            '                                </div>' +
                            '                                <div class="row w-100 m-auto">' +
                            '                                <div class="col-12 p-0">' +
                            '                                <div class="sdm-secondary-text">' +
                            '                                Типы фиксируемых нарушений' +
                            '                            </div>' +
                            '                            </div>' +
                            '                            <div class="col-12 p-0">' +
                            '                                <div class="sdm-secondary-text" style="color: black">' +
                            '                                - превышение скорости' +
                            '                            </div>' +
                            '                            </div>' +
                            '                            <div class="col-12 p-0">' +
                            '                                <div class="sdm-secondary-text" style="color: black">' +
                            '                                - проезд на красный' +
                            '                            </div>' +
                            '                            </div>' +
                            '                            </div>' +
                            '                            <div class="row w-100 m-auto">' +
                            '                                <a id="device" style="color: black; text-decoration: none;" href=\"/{point.options.custom.type}/{point.options.custom.device_id}'+'\"'+
                            '                        class="my-1 mr-1 py-1 border-copy-button">' +
                            '                                <span style="font-size: 10px; border-bottom: 2px solid #7224f2">' +
                            '                                {point.options.custom.text}' +
                            '                            </span>' +
                            '                            </a>' +
                            '                            </div>' +
                            '                            </div>'
                        ),
                    },

                    plotOptions: {
                        series: {
                            point: {
                                events: {
                                    click: function() {
                                        this.series.chart.update({
                                            tooltip: {
                                                enabled: true
                                            }
                                        });
                                    },
                                    mouseOut: function() {
                                        this.series.chart.update({
                                            tooltip: {
                                                enabled: false
                                            }

                                        })
                                    }
                                }
                            },
                            cursor: 'pointer'
                        },
                        spline: {
                            marker: {
                                enable: true
                            }
                        }
                    },

                    rangeSelector: {
                        enabled: true,
                        selected: 1,
                        buttons: [
                            {
                                type: 'month',
                                count: 1,
                                text: '1м',
                                title: 'Посмотреть 1 месяц'
                            }, {
                                type: 'month',
                                count: 3,
                                text: '3м',
                                title: 'Посмотреть 3 месяца'
                            }, {
                                type: 'month',
                                count: 6,
                                text: '6м',
                                title: 'Посмотреть 6 месяцев'
                            },
                            //     {
                            //     type: 'ytd',
                            //     text: 'YTD',
                            //     title: 'View year to date'
                            // },
                                {
                                type: 'year',
                                count: 1,
                                text: '1 год',
                                title: 'Посмотреть 1 год'
                            }, {
                                type: 'all',
                                text: 'Все',
                                title: 'Посмотреть все'
                            }
                        ]
                    },
                    navigator: {
                        enabled: false
                    },
                    scrollbar: {
                        enabled:true,
                        barBackgroundColor: 'white',
                        barBorderRadius: 7,
                        barBorderWidth: 0,
                        buttonBackgroundColor: '#7224f2',
                        buttonBorderWidth: 0,
                        buttonBorderRadius: 7,
                        trackBackgroundColor: '#7224f2',
                        trackBorderWidth: 1,
                        trackBorderRadius: 8,
                        trackBorderColor: '#CCC'
                    },
                    data: {
                        dateFormat: 'mm.dd.YYYY'
                    },
                    series: [],
                },
            }
        },
        methods:{
            updateCharts() {
                this.chartOptions.series=[];
                    this.charts.forEach(item => {

                        if (this.not_efficiency_mode ===true) {
                            if (this.has_passages === true)
                            {
                                let seria = {};
                                seria.name = item.name+` П `;
                                seria.data = [];
                                seria.color = 'green';
                                item.dates.forEach(date => {
                                    let point = {};
                                    point.y = date.passages;
                                    point.x = moment(date.date).utc().toDate();
                                    point.custom = {
                                        id: date.id,
                                        serial: this.type != -1 ? item.name : '',
                                        type: this.type != -1 ? 'devices' : 'boundaries',
                                        text: this.type != -1 ? 'К устройству' : 'К рубежу',
                                        passages:date.passages,
                                        device_id: this.type != -1 ? date.device_id : date.boundary_id,
                                        violations:date.violations,
                                        voltage:date.voltage,
                                        device_boundary: {
                                            id: date.boundary_id,
                                            title: date.boundary_title,
                                        }
                                    };
                                    seria.data.push(point);
                                });
                                this.chartOptions.series.push(seria)
                            }
                            if (this.has_violations === true)
                            {
                                let seria = {};
                                seria.name = item.name +` H`;
                                seria.data = [];
                                seria.color = 'red';
                                item.dates.forEach(date => {
                                    let point = {};
                                    point.y = date.violations;
                                    point.x = moment(date.date).utc().toDate();
                                    point.custom={
                                        id: date.id,
                                        serial: this.type != -1 ? item.name : '',
                                        type: this.type != -1 ? 'devices' : 'boundaries',
                                        text: this.type != -1 ? 'К устройству' : 'К рубежу',
                                        passages:date.passages,
                                        device_id: this.type != -1 ? date.device_id : date.boundary_id,
                                        violations:date.violations,
                                        voltage:date.voltage,
                                        device_boundary: {
                                            id: date.boundary_id,
                                            title: date.boundary_title,
                                        }
                                    };
                                    seria.data.push(point);
                                });
                                this.chartOptions.series.push(seria)
                            }
                        }
                        else {
                            let seria = {};
                            seria.name = item.name+` V`;
                            seria.data = [];
                            item.dates.forEach(date => {
                                let point = {};
                                point.y = date.voltage;
                                point.x = moment(date.date).utc().toDate();
                                point.custom={
                                    id: date.id,
                                    serial: this.type != -1 ? item.name : '',
                                    type: this.type != -1 ? 'devices' : 'boundaries',
                                    text: this.type != -1 ? 'К устройству' : 'К рубежу',
                                    passages:date.passages,
                                    device_id: this.type != -1 ? date.device_id : date.boundary_id,
                                    violations:date.violations,
                                    voltage:date.voltage,
                                    device_boundary: {
                                        id: date.boundary_id,
                                        title: date.boundary_title,
                                    }
                                };
                                seria.data.push(point);
                            });
                            this.chartOptions.series.push(seria)
                        }

                    });
                if (this.$refs.highchart != null || this.$refs.highchart != undefined) {
                    this.$refs.highchart.chart.redraw();
                    this.$refs.highchart.chart.reflow();
                }
            },

            //CANCELED
            /*addChart(device) {
                this.devices.findIndex(item => item.serial === device);
                if (this.not_efficiency_mode) {
                    if (this.has_passages)
                    {
                        //  this.chartOptions.series.push()
                    }
                    if (this.has_violations)
                    {
                        //  this.chartOptions.series.push()
                    }
                }
                else {
                    // this.chartOptions.series.push()
                }

            },
            removeChart(device) {
                this.chartOptions.series = this.chartOptions.series.filter( item => item.name !== device);
            }*/
        }
    }
</script>

<style>
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
    .highcharts-tooltip>span {
        background: white;
        border: 1px solid silver;
        border-radius: 3px;
        box-shadow: 1px 1px 2px #888;
        padding: 8px;
    }
    #chart div {
        overflow:visible !important;
    }
    .highcharts-container {
        width: 100% !important;
    }

    .highcharts-container svg{
        width: 100% !important;
    }
</style>
