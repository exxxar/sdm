<template>
    <div>
        <layout
            :title="'История операций'"
            :info="true"
            :info_text="'Это история обращений.'"
        >
            <template v-slot:menu>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center"
                >
                    <div style="z-index: 9" class="col-12 col-md-6 col-lg-9">
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
                                    href="#"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    История операций
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <user-menu :user="user"></user-menu>
                    </div>
                    <div
                        class="col-12"
                        style="border-bottom: 1px solid #e3e3e5"
                    ></div>
                </div>
            </template>
            <template v-slot:filters>
                <div
                    class="row w-100 m-auto align-items-center justify-content-center"
                >
                    <div class="col-2 pr-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Период операций
                        </p>
                        <daterange-picker
                            ref="picker"
                            :opens="'right'"
                            :locale-data="local_data"
                            :timePicker="true"
                            :timePickerIncrement="1"
                            :timePicker24Hour="true"
                            :timePickerSeconds="true"
                            :showWeekNumbers="false"
                            :showDropdowns="true"
                            :ranges="false"
                            v-model="dateRange"
                            :linkedCalendars="true"
                            class="w-100"
                        >
                            <div slot="header" slot-scope="header" class="slot">
                                <div class="row w-100 m-auto">
                                    <div class="col-12">
                                        <div
                                            class="row m-auto w-100 justify-content-end"
                                        >
                                            <button
                                                @click="header.clickCancel"
                                                class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                            >
                                                <span
                                                    style="font-size: 10px; border-bottom: 2px solid #d93030"
                                                >
                                                    Сбросить
                                                </span>
                                            </button>
                                            <button
                                                @click="header.clickApply"
                                                class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                            >
                                                <span
                                                    style="font-size: 10px; border-bottom: 2px solid #7224f2"
                                                >
                                                    Подтвердить
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12"
                                        style="border-top: 1px solid #ced4da"
                                    >
                                        <div class="sdm-primary-text py-3 px-2">
                                            Выбранный период:
                                            <span style="color:#7224f2">{{
                                                rangeText(header.rangeText)
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template
                                v-slot:input="picker"
                                style="min-width: 350px;"
                            >
                                <div
                                    class="row w-100 h-100 m-auto align-items-center justify-content-center"
                                >
                                    <div
                                        class="col-10 p-0 text-truncate"
                                        style="font-size: 11px"
                                    >
                                        <span style="color: #7224f2">{{
                                            picker.startDate
                                                | moment("DD.MM.YYYY")
                                        }}</span>
                                        {{
                                            picker.startDate
                                                | moment("HH:mm:ss")
                                        }}
                                        -
                                        <span style="color: #7224f2">{{
                                            picker.endDate
                                                | moment("DD.MM.YYYY")
                                        }}</span>
                                        {{
                                            picker.endDate | moment("HH:mm:ss")
                                        }}
                                    </div>
                                    <div class="col-2 pr-0">
                                        <svg
                                            class="float-right"
                                            height="15px"
                                            viewBox="0 0 512 512"
                                            width="15px"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill="#7224f2"
                                                d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </template>
                            <div
                                slot="footer"
                                slot-scope="data"
                                class="slot"
                            ></div>
                        </daterange-picker>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип операции
                        </p>
                        <select class="sdm-select" v-model="operation_type">
                            <option value="" selected>
                                Все
                            </option>
                            <option
                                :key="type"
                                :value="type"
                                v-for="type in filteredOperationType"
                            >
                                {{ type }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип объекта
                        </p>
                        <select
                            class="sdm-select"
                            v-model="object_type"
                            @change="selectObjectType"
                        >
                            <option value="" selected>
                                Все
                            </option>
                            <option v-for="(object, index) in objects" :key="index+object.title" :value="object.type_id">
                                {{ object.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Объект
                        </p>
                        <select v-bind:disabled="object_type === ''" class="sdm-select" v-model="object">
                            <option value="" selected>
                                Все
                            </option>
                            <option :value="item.id" v-for="(item, index) in selectedTypeObjects" :key="index+'r'">
                                {{ item.title ? item.title : "" }}
                                {{ item.serial ? item.serial : "" }}
                                {{ item.name ? item.name : "" }}
                                {{ object_type == 16 ? `Обращение №${item.id}` : "" }}
                                {{ object_type != 16 && !item.title && !item.serial && !item.name ? item.id : "" }}
                            </option>
                            <!-- <option
                                v-for="(item, index) in filteredObjects"
                                :key="index"
                                :value="item"
                            >
                                <span v-if="item.type === 3">Обращение №</span
                                >{{ item.title }}
                            </option> -->
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Пользователь
                        </p>
                        <select class="sdm-select" v-model="selected_user">
                            <option value="" selected>
                                Все
                            </option>
                            <option
                                v-for="item in users"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2 pl-1 pr-2 h-100">
                        <div
                            class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-around"
                        >
                            <button
                                class="btn w-45 mb-0 mt-auto float-right"
                                style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                                @click="applyFilters"
                            >
                                Применить
                            </button>
                            <button
                                class="btn w-45 mb-0 mt-auto float-right"
                                style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                                @click="resetFilters"
                            >
                                Сбросить
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <history
                    ref="History"
                    :operation_type="operation_type"
                    :object_type="object_type"
                    :object="object"
                    :selected_user="selected_user"
                    :dateRange="dateRange"
                >
                </history>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import History from "../../components/history/History";
import moment from "moment";
export default {
    name: "HistoryPage",
    components: {
        Layout,
        History
    },
    props: ["user", "users", "objects", "actions"],
    data() {
        let startDate = new Date();
        let endDate = new Date();
        startDate.setDate(startDate.getDate() - 6);
        endDate.setDate(endDate.getDate() + 6);
        return {
            dateRange: { startDate, endDate },
            local_data: {
                format: "mm/dd/yyyy HH:MM",
                separator: " - ",
                applyLabel: "Подтвердить",
                cancelLabel: "Сбросить",
                daysOfWeek: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
                monthNames: [
                    "Янв",
                    "Февр",
                    "Март",
                    "Апр",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Авг",
                    "Сент",
                    "Окт",
                    "Нояб",
                    "Дек"
                ],
                firstDay: 1
            },
            operation_type: "",
            object_type: "",
            object: "",
            selected_user: "",
        };
    },
    created() {
        /*this.history.forEach(item =>{
             console.log(item)
        })*/
    },

    computed: {
        selectedTypeObjects: function() {
            this.object = "";

            if (this.object_type == "") {
                return [];
            }

            let object = {
                items: []
            };

            for (const [key, value] of Object.entries(this.objects)) {
                if(value.type_id == this.object_type) {
                    object = value;
                }
            }

            return object.items;
        },
        filteredOperationType(){
            //return [...new Set(this.history.map(item => item.action))]
            return [...new Set(this.actions)]
        },
        filteredObjects() {
            return this.objects.filter(item => {
                let object_type = true;
                if (this.object_type !== "") {
                    object_type = item.type === this.object_type;
                }
                return object_type;
            });
        }
    },
    methods: {
        rangeText(range) {
            let text = range.split(" - ");
            text =
                moment(text[0]).format("DD MMMM YYYY HH:mm") +
                " - " +
                moment(text[1]).format("DD MMMM YYYY HH:mm");
            return text;
        },
        applyFilters() {
            this.$refs.History.getData();
        },
        resetFilters() {
            this.operation_type = "";
            this.object_type = "";
            this.object = "";
            this.user = "";
            let startDate = new Date();
            let endDate = new Date();
            endDate.setDate(endDate.getDate() + 6);
            this.dateRange = { startDate, endDate };
        },
        selectObjectType() {
            // if (this.object != "") {
            //     if (
            //         this.filteredObjects.findIndex(
            //             item => item.title === this.object
            //         ) === -1
            //     ) {
            //         this.object = "";
            //     }
            // }
        }
    }
};
</script>

<style scoped>
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
.form-select {
    display: block;
    width: 100%;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    font-size: 12px;
    font-family: Montserrat;
    font-weight: 400;
    line-height: 1.5;
    color: black;
    vertical-align: middle;
    background-color: transparent;
    background-image: url("/chevron-down.svg");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #dfe1ee;
    border-radius: 0.25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}
.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}
.custom-select {
    color: black;
    font-weight: 500;
    font-size: 12px;
    border-color: #dfe1ee;
}
</style>
