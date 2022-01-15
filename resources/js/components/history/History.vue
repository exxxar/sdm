<template>
    <div>
        <div class="row w-100 m-auto">
            <div class="col-12">
                <div
                    style="padding-bottom: 10px"
                    class="row w-100 mx-auto mt-3 align-items-center justify-content-center"
                >
                    <div
                        class="sdm-filter col-3 pl-0"
                        @click="sort('created_at')"
                    >
                        Дата и время
                        <i
                            v-bind:class="{
                                'sort-icon-rotation': currentSortDir == 'asc'
                            }"
                            v-if="currentSort == 'created_at'"
                            class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-2" @click="sort('action')">
                        Тип операции
                        <i
                            v-bind:class="{
                                'sort-icon-rotation': currentSortDir == 'asc'
                            }"
                            v-if="currentSort == 'action'"
                            class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-2" @click="sort('object_type')">
                        Тип объекта
                        <i
                            v-bind:class="{
                                'sort-icon-rotation': currentSortDir == 'asc'
                            }"
                            v-if="currentSort == 'object_type'"
                            class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-3" @click="sort('object')">
                        Объект
                        <i
                            v-bind:class="{
                                'sort-icon-rotation': currentSortDir == 'asc'
                            }"
                            v-if="currentSort == 'object'"
                            class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                    <div class="sdm-filter col-2" @click="sort('user')">
                        Пользователь
                        <i
                            v-bind:class="{
                                'sort-icon-rotation': currentSortDir == 'asc'
                            }"
                            v-if="currentSort == 'user'"
                            class="fas fa-angle-down sdm-filter-icon"
                        >
                        </i>
                    </div>
                </div>
                <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center">
                    <div style="color:#7c34f2" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div
                    v-if="!loading"
                    class="row w-100 mx-auto align-items-center justify-content-center sdm-primary-text"
                >
                    <div
                        class="col-12 p-0"
                        :key="index"
                        v-for="(item, index) in sortedList"
                    >
                        <div
                            class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                            style="background: #ffffff; border-radius: 5px; max-width: 1420px"
                        >
                            <div class="col-12 col-md-3">
                                <span style="color: #7224f2">{{
                                    item.created_at | moment("DD.MM.YYYY")
                                }}</span>
                                {{ item.created_at | moment("HH:mm:ss") }}
                            </div>
                            <div class="col-12 col-md-2">
                                {{ item.action }}
                            </div>
                            <div class="col-12 col-md-2">
                                {{ item.object.typeTitle }}
                            </div>
                            <div class="col-12 col-md-3">
                                <div
                                    class="row w-100 mx-auto my-1 align-items-center"
                                >
                                    <div>
                                        <a
                                            v-if="item.object.objectLink"
                                            :href="item.object.objectLink"
                                            class="sdm-primary-text"
                                            style="color: black; text-decoration: none"
                                        >
                                            {{ item.object.objectTitle }}

                                            <svg
                                                v-if="item.object"
                                                version="1.1"
                                                id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                x="0px"
                                                y="0px"
                                                width="16px"
                                                height="15px"
                                                viewBox="0 0 612 612"
                                                style="
                        enable-background: new 0 0 612 612;
                        overflow: unset;
                      "
                                                xml:space="preserve"
                                            >
                                                <path
                                                    fill="#7224f2"
                                                    d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                />
                                            </svg>
                                        </a>

                                        <p v-else>
                                            {{ item.object.objectTitle }}
                                        </p>
                                        <a
                                            href="#"
                                            class="sdm-primary-text"
                                            @click="openDescribe(item)"
                                            title="Содержание объекта"
                                            >(пояснение)</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div
                                    class="row w-100 mx-auto my-1 align-items-center"
                                >
                                    <div>
                                        {{ item.user.name }}
                                    </div>
                                    <button
                                        class="btn p-0 mr-2"
                                        style="
                      height: 30px;
                      width: 30px;
                      min-width: 30px;
                      background: transparent;
                      color: #7224f2;
                    "
                                        @click="toUserPage(item.user_id)"
                                    >
                                        <svg
                                            version="1.1"
                                            id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            x="0px"
                                            y="0px"
                                            width="16px"
                                            height="15px"
                                            viewBox="0 0 612 612"
                                            style="
                        enable-background: new 0 0 612 612;
                        overflow: unset;
                      "
                                            xml:space="preserve"
                                        >
                                            <path
                                                fill="#7224f2"
                                                d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
                </div>
            </div>
        </div>

        <modal id="object-data">
            <template v-slot:header>
                Содержание объекта
            </template>
            <template v-slot:main>
                <div class="row" v-if="selected">
                    <div class="col-12">
                        <h5>Состояние объекта до модификации</h5>
                        <json-viewer
                            :value="selected.object_before"
                            :expand-depth="5"
                            copyable
                            boxed
                            sort
                        ></json-viewer>
                    </div>
                    <div class="col-12">
                        <h5 class="mt-2">
                            Состояние объекта после модификации
                        </h5>
                        <json-viewer
                            :value="selected.object_after"
                            :expand-depth="5"
                            copyable
                            boxed
                            sort
                        ></json-viewer>
                    </div>

                    <div class="col-12">
                        <h5 class="mt-2">Сравнение объектов</h5>
                        <vue-json-compare
                            :oldData="selected.object_before"
                            :newData="selected.object_after"
                        ></vue-json-compare>
                    </div>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from "../../components/Modal";
import moment from "moment";
import vueJsonCompare from "vue-json-compare";

export default {
    name: "History",
    components: {
        Modal,
        vueJsonCompare
    },
    props: [
        "operation_type",
        "object_type",
        "object",
        "selected_user",
        "dateRange"
    ],
    data() {
        return {
            // lodaing
            loading: false,
            //sort
            currentSort: "date",
            currentSortDir: "asc",
            selected: null,
            history: [],
            laravelData: {}
        };
    },
    watch: {
        history: {
            handler: function () {
            },
            deep: true
        }
    },
    computed: {
        sortedList: function() {
            return this.history.sort((a, b) => {
                let modifier = 1;
                if (this.currentSortDir === "desc") modifier = -1;
                if (this.currentSort == "user") {
                    if (a.user.name < b.user.name) return -1 * modifier;
                    if (a.user.name > b.user.name) return 1 * modifier;
                } else if (this.currentSort == "object_type1") {
                    if (a.object.typeTitle < b.object.typeTitle)
                        return -1 * modifier;
                    if (a.object.typeTitle > b.object.typeTitle)
                        return 1 * modifier;
                } else if (this.currentSort == "object") {
                    console.log(
                        "sort",
                        a.object.objectTitle,
                        b.object.objectTitle
                    );
                    if (a.object.objectTitle < b.object.objectTitle)
                        return -1 * modifier;
                    if (a.object.objectTitle > b.object.objectTitle)
                        return 1 * modifier;
                } else {
                    if (a[this.currentSort] < b[this.currentSort])
                        return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort])
                        return 1 * modifier;
                }

                return 0;
            });
        },
        filteredList() {
            return this.history.filter(item => {
                let operation_type = true,
                    object_type = true,
                    object = true,
                    selected_user = true,
                    date = false;

                //console.log(item);

                if (this.operation_type !== "") {
                    operation_type = item.action === this.operation_type;
                }

                if (this.object_type !== "") {
                    object_type = item.type === this.object_type;
                }

                if (this.object !== "") {
                    if (item.type === 1) {
                        object = item.object.serial === this.object;
                    }
                    if (item.type === 2) {
                        object = item.object.title === this.object;
                    }
                    if (item.type === 3) {
                        object = item.object.id === this.object;
                    }
                }
                if (this.selected_user !== "") {
                    selected_user = item.user_id === this.selected_user;
                }

                if (
                    moment(item.created_at).isBetween(
                        this.dateRange.startDate,
                        this.dateRange.endDate
                    )
                ) {
                    date = true;
                }

                return (
                    operation_type &&
                    object_type &&
                    object &&
                    selected_user &&
                    date
                );
            });
        }
    },
    methods: {
        getData(page = 1) {
            this.loading = true;
            //console.log(this.object);
            axios
                .get("/history?page=" + page, {
                    params: {
                        operation_type: this.operation_type,
                        object_id: this.object,
                        object_type_id: this.object_type,
                        selected_user: this.selected_user,
                        start_date: this.dateRange.startDate,
                        end_date: this.dateRange.endDate
                    }
                })
                .then(resp => {
                    //console.log(resp.data.data);
                    this.loading = false;
                    this.history = resp.data.data;
                    this.laravelData = resp.data;
                })
                .catch((resp) => {
                    this.loading = false;
                    console.log(resp);
                });
        },
        openDescribe(item) {
            this.selected = item;

            $("#object-data").modal("show");
        },
        sort: function(s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        toUserPage(id) {
            window.location.href = "/users/" + id;
        }
    },
    mounted() {
        this.getData()
        //console.log("=>");
    }
};
</script>

<style scoped>
.sdm-primary-text {
    font-family: Montserrat;
    font-size: 12px;
    font-weight: 500;
}

.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}

.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}

.sdm-popover {
    left: -96px !important;
    top: -108px !important;
    height: 120px !important;
    width: 155px !important;
    font-size: 12px;
    padding-top: 15px;
    padding-left: 15px;
    padding-bottom: 15px;
    padding-right: 0px;
}

.sdm-popover.dropdown-position-top::before {
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #fff;
    bottom: -6px;
    left: calc(84% - 6px);
    filter: drop-shadow(0px 2px 2px rgba(52, 73, 94, 0.1));
}
</style>
<style>
.sdm-popover .ps {
    width: 100%;
    height: 90px;
}

.sdm-popover .ps .ps__rail-y {
    background: #fff !important;
    opacity: 1 !important;
    width: 3px !important;
}

.sdm-popover .ps .ps__thumb-y {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}

.sdm-popover .ps .ps__thumb-y:hover {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}

.sdm-popover .ps .ps__rail-y:hover > .ps__thumb-y,
.ps__rail-y:focus > .ps__thumb-y,
.ps__rail-y.ps--clicking .ps__thumb-y {
    background-color: #7224f2 !important;
    width: 3px !important;
    right: 0px;
}
</style>
