/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

window.eventBus = new Vue();

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import JsonViewer from 'vue-json-viewer'

// Import JsonViewer as a Vue.js plugin
Vue.use(JsonViewer)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Пагинация
Vue.component('pagination', require('laravel-vue-pagination'));

// Обращения
Vue.component("appeals-page", require("./pages/appeals/AppealsPage").default);
Vue.component(
    "appeals-add-page",
    require("./pages/appeals/AppealsAddPage").default
);
Vue.component(
    "appeals-edit-page",
    require("./pages/appeals/AppealsEditPage").default
);
Vue.component(
    "appeals-show-page",
    require("./pages/appeals/AppealsShowPage").default
);
Vue.component(
    "appeals-history-page",
    require("./pages/appeals/AppealsHistoryPage").default
);
// Устройства
Vue.component("devices-page", require("./pages/devices/DevicesPage").default);
Vue.component(
    "devices-add-page",
    require("./pages/devices/DevicesAddPage").default
);
Vue.component(
    "devices-edit-page",
    require("./pages/devices/DevicesEditPage").default
);
// Группы устройств
Vue.component(
    "device-groups-page",
    require("./pages/deviceGroups/DeviceGroupsPage").default
);
Vue.component(
    "device-groups-add-page",
    require("./pages/deviceGroups/DeviceGroupsAddPage").default
);
Vue.component(
    "device-groups-edit-page",
    require("./pages/deviceGroups/DeviceGroupsEditPage").default
);
Vue.component(
    "device-groups-show-page",
    require("./pages/deviceGroups/DeviceGroupsShowPage").default
);
// Рубежи
Vue.component(
    "boundaries-page",
    require("./pages/boundaries/BoundariesPage").default
);
Vue.component(
    "boundaries-add-page",
    require("./pages/boundaries/BoundariesAddPage").default
);
Vue.component(
    "boundaries-edit-page",
    require("./pages/boundaries/BoundariesEditPage").default
);
Vue.component(
    "boundaries-schedule-page",
    require("./pages/boundaries/BoundariesSchedulePage").default
);

// Группы рубежей
Vue.component(
    "boundary-groups-page",
    require("./pages/boundaryGroups/BoundaryGroupsPage").default
);
Vue.component(
    "boundary-groups-add-page",
    require("./pages/boundaryGroups/BoundaryGroupsAddPage").default
);
Vue.component(
    "boundary-groups-edit-page",
    require("./pages/boundaryGroups/BoundaryGroupsEditPage").default
);
//Map
Vue.component(
    "map-page",
    require("./pages/map/MapPage").default
);
//Summary
Vue.component(
    "summary-page",
    require("./pages/summary/SummaryPage").default
);
//History
Vue.component(
    "history-page",
    require("./pages/history/HistoryPage").default
);
//Users
Vue.component(
    "users-page",
    require("./pages/users/UsersPage").default
);
Vue.component(
    "users-add-page",
    require("./pages/users/UsersAddPage").default
);
Vue.component(
    "users-edit-page",
    require("./pages/users/UsersEditPage").default
);
Vue.component(
    "user-menu",
    require("./components/UserMenu").default
);
//DictionaryTypes
Vue.component(
    "dictionary-types-page",
    require("./pages/dictionaryTypes/DictionaryTypesPage").default
);
Vue.component(
    "dictionary-types-add-page",
    require("./pages/dictionaryTypes/DictionaryTypesAddPage").default
);
Vue.component(
    "dictionary-types-edit-page",
    require("./pages/dictionaryTypes/DictionaryTypesEditPage").default
);
//Dictionaries
Vue.component(
    "dictionaries-add-page",
    require("./pages/dictionaries/DictionariesAddPage").default
);
Vue.component(
    "dictionaries-edit-page",
    require("./pages/dictionaries/DictionariesEditPage").default
);
//Reports
Vue.component(
    "reports-page",
    require("./pages/reports/ReportsPage").default
);
Vue.component(
    "reports-add-page",
    require("./pages/reports/ReportsAddPage").default
);
Vue.component(
    "reports-edit-page",
    require("./pages/reports/ReportsEditPage").default
);
Vue.component(
    "reports-show-page",
    require("./pages/reports/ReportsShowPage").default
);
Vue.component(
    "reports-automatic-page",
    require("./pages/reports/ReportsAutomaticPage").default
);
//ReportTemplates
Vue.component(
    "report-templates-page",
    require("./pages/reportTemplates/ReportTemplatesPage").default
);
Vue.component(
    "report-templates-add-page",
    require("./pages/reportTemplates/ReportTemplatesAddPage").default
);
Vue.component(
    "report-templates-edit-page",
    require("./pages/reportTemplates/ReportTemplatesEditPage").default
);
Vue.component(
    "report-templates-show-page",
    require("./pages/reportTemplates/ReportTemplatesShowPage").default
);
Vue.component(
    "system-info-page",
    require("./pages/SystemInfoPage").default
);

import YmapPlugin from 'vue-yandex-maps'

Vue.use(YmapPlugin, {
    apiKey: 'c3ddaef1-2a3e-4aea-bd55-698a8735fc7d',
    lang: 'ru_RU',
    coordorder: 'latlong',
    version: '2.1'
})

import Multiselect from 'vue-multiselect'

Vue.component('multiselect', Multiselect)
import vSelect from "vue-select";
Vue.component("v-select", vSelect);

const moment = require("moment");
require("moment/locale/ru");
moment.locale("ru");
Vue.use(require("vue-moment"), {
    moment
});
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
Vue.use(PerfectScrollbar)

import HighchartsVue from 'highcharts-vue'
Vue.use(HighchartsVue);

import Highcharts from 'highcharts'
Highcharts.setOptions({
    lang:{
        months:['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        shortMonths:['Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек']
    }
})
import drilldownInit from 'highcharts/modules/drilldown'
drilldownInit(Highcharts)
import exportingInit from 'highcharts/modules/exporting'
exportingInit(Highcharts)
import exportDataInit from 'highcharts/modules/export-data'
exportDataInit(Highcharts)
import Stock from "highcharts/modules/stock";
Stock(Highcharts);
// import theme from 'highcharts/themes/grid-light'

import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
Vue.component("daterange-picker", DateRangePicker);

import Popover from "vue-js-popover";
Vue.use(Popover);
import Notifications from 'vue-notification'
Vue.use(Notifications);

import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#page-content-wrapper").addClass("content-margin");
    $("#wrapper").toggleClass("toggled");
});

$(".first-list > div.list-group-item").each(function() {
    var location2 =
        window.location.protocol +
        "//" +
        window.location.host +
        window.location.pathname;
    var part = this.children[0];
    var link = part.href;
    if (link === location2) {
        $(this).addClass("active");
    }
});

$('[data-toggle="popover"]').popover();

/*$('.popover-dismiss').popover({
    trigger: 'focus'
})*/
