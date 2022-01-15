<template>
    <div>
        <layout title="Обращения" :info="true" :info_text="'Это обращения.'">
            <template v-slot:menu>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center"
                >
                    <div style="z-index: 9" class="col-12 col-md-6 col-lg-9">
                        <ol
                            class="breadcrumb pl-0 m-0 align-items-center"
                            style="background-color: transparent"
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
                                    href="/home"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Обращения
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
            <template v-slot:header>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3"
                >
                    <div class="col-12 col-md-4 col-sm-6 pr-0">
                        <button
                            class="btn w-100 my-1 mr-1 py-1 border-copy-button"
                            @click="toAppealsHistory"
                        >
                            <span
                                style="font-size: 10px; border-bottom: 2px solid #9b65f2"
                            >
                                История обращений
                            </span>
                        </button>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6 pl-0 pr-0 pr-sm-1">
                        <button
                            v-on:click="addAppeal"
                            type="button"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        >
                            Добавить обращение
                        </button>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6 px-0">
                        <button
                            type="button"
                            class="btn w-100 my-1 btn-dark py-2"
                            style="background: #448d3b;border: none;color: white;font-size: 11px;font-weight: 500;"
                            @click="resetAllError"
                        >
                            Убрать все ошибки
                        </button>
                    </div>
                </div>
            </template>
            <template v-slot:info></template>
            <template v-slot:filters>
                <div
                    class="row w-100 m-auto justify-content-center align-items-center"
                >
                    <div class="col-12 col-md-2 p-0 mt-3">
                        <div class="sdm-check form-check-inline">
                            <input
                                id="checkbox-1"
                                class="checkbox-custom"
                                name="checkbox-1"
                                type="checkbox"
                                v-model="actual"
                            />
                            <label
                                for="checkbox-1"
                                class="checkbox-custom-label"
                                >В работе</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                id="checkbox-3"
                                class="checkbox-custom"
                                name="checkbox-3"
                                type="checkbox"
                                v-model="ready"
                            />
                            <label
                                for="checkbox-3"
                                class="checkbox-custom-label"
                                >Готово</label
                            >
                        </div>
                    </div>
                    <div class="col-12 col-md-7 p-0">
                        <div class="row w-80 my-2 align-items-center">
                            <div class="col-4 pl-0 pr-2">
                                <p
                                    class="mb-1 d-flex"
                                    style="font-size: 9px; color: #959597; font-weight: 400"
                                >
                                    поиск по рубежу
                                </p>
                                <input
                                    class="form-control"
                                    placeholder="Все"
                                    style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                                    v-model="boundary"
                                />
                            </div>
                            <div class="col-4  pl-0 pr-2">
                                <p
                                    class="mb-1 d-flex"
                                    style="font-size: 9px; color: #959597; font-weight: 400"
                                >
                                    проблема
                                </p>
                                <select
                                    class="form-select"
                                    style="color: black; font-weight: 500; font-size: 12px;"
                                    v-model="malfunction"
                                >
                                    <option value="" selected>Все </option>
                                    <option
                                        :key="malfunction.id"
                                        :value="malfunction.id"
                                        v-for="malfunction in malfunctions"
                                    >
                                        {{ malfunction.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-1 p-0">
                                <div class="dropdown mt-3">
                                    <button
                                        class="btn dropdown-toggle mdi mdi-dots-horizontal"
                                        style="color: #6633ff; padding: 0.175rem 0.95rem; border-color: #dfe1ee"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    ></button>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton"
                                    >
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Action</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Another action</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Something else here</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-2 p-0">
                                <p
                                    class="mb-1 d-flex sdm-secondary-text"
                                    style="visibility: hidden"
                                >
                                    Тип
                                </p>
                                <div class="form-check form-check-inline d-flex justify-content-center">
                                    <input
                                        id="checkbox-2"
                                        class="checkbox-custom"
                                        name="checkbox-2"
                                        type="checkbox"
                                        v-model="deleted"
                                    />
                                    <label
                                        for="checkbox-2"
                                        class="checkbox-custom-label"
                                    >
                                        Удаленные
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 p-0">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            вначале показать
                        </p>
                        <select
                            class="form-select"
                            style="color: black; font-weight: 500; font-size: 12px;"
                            v-model="show_first"
                        >
                            <option value="Актуальные">В работе</option>
                            <option>Готово</option>
                        </select>
                    </div>
                    <div class="col-4 col-md-1 p-0">
                        <div
                            class="row w-100 mx-auto align-items-end justify-content-end"
                        >
                            <div>
                                <p
                                    class="mb-1 d-flex"
                                    style="font-size: 9px; color: #959597; font-weight: 400"
                                >
                                    вид
                                </p>
                                <button
                                    class="btn p-1 mr-2 mdi mdi-view-sequential"
                                    :class="{ 'active-toggler': format_table }"
                                    style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                                    v-on:click="format_table = true"
                                    title="Табличное отображение"
                                ></button>
                            </div>

                            <button
                                class="btn p-1 mdi mdi-apps"
                                :class="{ 'active-toggler': !format_table }"
                                style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                                v-on:click="format_table = false"
                                title="Плиточное отображение"
                            ></button>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:main>
                <appeals
                    :inWork="inWork"
                    :ready="ready"
                    :actual="actual"
                    :format_table="format_table"
                    :boundary="boundary"
                    :malfunction="malfunction"
                    :show_first="show_first"
                    :deleted="deleted"
                >
                </appeals>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import Appeals from "../../components/appeals/Appeals";

export default {
    name: "AppealsPage",
    props: ["user", "malfunctions"],
    components: {
        Layout,
        Appeals
    },
    data: () => ({
        format_table: true,
        // checkbox
        actual: true,
        inWork: true,
        ready: true,
        // filters
        boundary: "",
        malfunction: "",
        // sort
        show_first: "Актуальные",
        deleted: false,
    }),
    methods: {
        resetAllError() {
            axios.get("/task/reset_all_appeals").then(resp => {
                this.sendNotify("Ошибки успешно сброщены");

                setTimeout(() => {
                    window.location.href = "/";
                }, 2000);
            }).catch(()=>{
                this.sendNotify("Отказано в операции","error");
            })
        },
        addAppeal: function() {
            window.location.href = "/tasks/add";
        },
        toAppealsHistory: function() {
            window.location.href = "/history/tasks";
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Отчеты",
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style scoped>
#dropdownMenuButton::after {
    display: none;
}

.active-toggler {
    color: #6633ff;
}

.form-select {
    display: block;
    width: 100%;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    vertical-align: middle;
    background-color: transparent;
    background-image: url("/chevron-down.svg");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.checkbox-custom {
    opacity: 0;
    position: absolute;
}

.checkbox-custom,
.checkbox-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px;
    cursor: pointer;
    font-weight: 500;
    font-size: 10px;
}

.checkbox-custom-label {
    position: relative;
    margin-left: 0;
}

.checkbox-custom + .checkbox-custom-label:before {
    content: "";
    /*background: #fff;*/
    border: 1px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    width: 17px;
    height: 17px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
    border-radius: 3px;
}

#checkbox-1 + .checkbox-custom-label:before {
    border: 1px solid #d62627;
}

#checkbox-2 + .checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox-3 + .checkbox-custom-label:before {
    border: 1px solid #458d3c;
}

#checkbox-1:checked + .checkbox-custom-label:before {
    background: #d62627;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-2:checked + .checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-3:checked + .checkbox-custom-label:before {
    background: #458d3c;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

.checkbox-custom:focus + .checkbox-custom-label {
    outline: none;
}

input:focus {
    border: 1px solid #7c34f2 !important;
    box-shadow: inset 0px 0px 0px 0px red !important;
    outline: none;
}

select {
    border-color: #dfe1ee;
    outline: none;
}

select:focus {
    border: 1px solid #7c34f2 !important;
    box-shadow: inset 0px 0px 0px 0px red !important;
    outline: none;
}
</style>
