<template>
<div>
    <div class="row w-100 mx-auto mt-3 align-items-center justify-content-center" v-if="format_table===true && !loading">
        <div class="col-12 p-0" v-for="item in data">
            <div class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center" style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; ">
                <div class="col-12 col-md-3 col-sm-12">
                    <div class="row w-100 my-1 align-items-center justify-content-start flex-nowrap">
                        <div class="col-2">
                            <div v-if="item.status === 'Актуальные'" class="p-1 mdi mdi-bookmark" style="color: #d93030; border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                            <div v-if="item.status === 'В работе'" class="p-1 mdi mdi-bookmark" style="color: #6633ff; border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                            <div v-if="item.status === 'Готово'" class="p-1 mdi mdi-bookmark" style="color: #458e3c;border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                        </div>
                        <div class="col-10">
                            <h6 class="ml-2 mb-0" style="font-size: 12px;font-weight: 300" v-if="item.boundary">
                                {{item.boundary.title}}</h6>
                            <h6 class="ml-2 mb-0" style="font-size: 12px;font-weight: 300" v-else>не выбрано</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-2 p-sm-0">
                    <div class="row m-auto my-1 align-items-center justify-content-center " style="padding-left:10px;padding-right:10px;border: 1px solid #e3e3e5">
                        <div class="col-2 p-0 mr-1">
                            <div :class="'p-1 mr-1 mdi '+getIcon(item.malfunction.title)" :style="'color:'+getIconColor(item.malfunction.title)+';font-size: 18px'"></div>
                        </div>
                        <div class="col-9 p-0">
                            <h6 class="ml-1 mb-0" style="font-size: 10px;font-weight: 600; word-break: normal;word-wrap: normal;">
                                {{item.malfunction.title}}</h6>
                        </div>
                    </div>
                </div>
                <div style="padding-left: 20px;padding-right: 0;" class="col-12 col-sm-6 col-md-2">
                    <div class="my-1">
                        <div v-if="item.status === 'Актуальные'">
                            <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время обращения</p>
                            <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">
                                {{item.updated_at}}
                            </div>
                        </div>
                        <div v-if="item.status === 'В работе'">
                            <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время начала
                                работ</p>
                            <div class="mb-0 d-flex table-text" style="font-size: 10px;font-weight: 500">
                                {{item.updated_at}}
                            </div>
                        </div>
                        <div v-if="item.status === 'Готово'">
                            <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время окончания
                                работ</p>
                            <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">
                                {{item.updated_at}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="my-1" v-if="item.device">
                        <p class="mb-0 d-flex sdm-secondary-text">серийный номер устройства</p>
                        <div class="d-flex" style="font-size: 10px;font-weight: 500">{{item.device.serial}}</div>
                    </div>
                    <div class="my-1" v-else>
                        <p class="mb-0 d-flex sdm-secondary-text">не выбрано</p>

                    </div>

                </div>
                <div class="col-12 col-sm-12 col-md-3" v-if="!item.deleted_at">
                    <div style="flex-wrap: nowrap" class="row w-100 mx-auto my-1 align-items-center justify-content-end">
                        <button :disabled="!can('Добавление отчетов')" class="btn mr-6 mt-1 border-copy-button" v-if="item.status === 'Готово'" @click="goToReports(item)">
                            <span style="font-size: 10px; border-bottom: 1px solid #9b65f2">Отчет</span>
                        </button>
                        <button title="Редактировать"  :disabled="!can('Изменение обращений')" class="btn mr-1" v-on:click="editItem(item.id)" style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;">
                            <svg id="Capa_1" style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px" enable-background="new 0 0 488.471 488.471" height="512" viewBox="0 0 488.471 488.471" width="512" xmlns="http://www.w3.org/2000/svg">
                                <path d="m166.093 240.214h88.205v194.288h-88.205z" transform="matrix(.707 -.707 .707 .707 1.415 9.959)" />
                                <path d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z" />
                            </svg>
                        </button>
                        <button title="Показать" :disabled="!can('Просмотр обращений')" class="btn p-1 mr-1 mdi mdi-chevron-right" @click="showItem(item.id)" style="height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF">
                        </button>
                        <button title="Удалить"  :disabled="!can('Удаление обращений')" v-if="item.status === 'Готово'" class="btn p-1 mr-1 mdi mdi-close" style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem" @click="deleteItem(item)">
                        </button>
                        <button title="Удалить" :disabled="!can('Удаление обращений')" v-else class="btn p-1 mr-2 mdi mdi-close" style="height:36px; width: 36px; min-width: 36px; background: #dfe1ee; color: #FFFFFF; font-size: 24px; line-height: 1rem" disabled>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3 d-flex justify-content-end" v-if="item.deleted_at">
                    <div style="display: flex;
                                            align-items: center;
                                            width: 116px;
                                            justify-content: center; flex-wrap:wrap;" >
                        <p style="font-size: 14px; color: red; margin-bottom: 0">
                            Удалено
                        </p>
                        <a href="#restore" style="color:green;" :disabled="!can('Восстановление обращений')" @click="restore(item)">Восстановить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="format_table!==true && !loading" class="row w-100 m-auto row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 align-items-start">
        <div class="col-12 col-lg-3 col-md-6 px-2" v-for="item in data">
            <div class="card h-100 p-2 my-2" style="max-width: 340px; border-radius:5px; border:0;">
                <div class="card-body">
                    <div class="row w-100  mx-auto mb-2  justify-content-start">
                        <div class="col-12 p-0" style="display: flex;flex-wrap: nowrap;align-items: center;justify-content: space-between;">
                            <h6 class="mb-0 card-title" style="font-size: 12px;font-weight: 300;" v-if="item.boundary">
                                {{item.boundary.title}}</h6>
                            <h6 class="mb-0 card-title" style="font-size: 12px;font-weight: 300;" v-else>
                                Не выбрано</h6>
                            <div v-if="item.status === 'Актуальные'" class="mdi mdi-bookmark" style="color: #d93030; font-size: 18px; padding-right: 0"></div>
                            <div v-if="item.status === 'В работе'" class="mdi mdi-bookmark" style="color: #6633ff; font-size: 18px; padding-right: 0"></div>
                            <div v-if="item.status === 'Готово'" class="mdi mdi-bookmark" style="color: #458e3c; font-size: 18px; padding-right: 0"></div>
                        </div>
                    </div>
                    <div class="row mx-auto mb-2 align-items-center justify-content-center" style="border: 1px solid #e3e3e5; padding-left: 10px">
                        <div class="col-2 p-0 mr-1">
                            <div :class="'p-1 mr-1 mdi '+getIcon(item.malfunction.title)" :style="'color:'+getIconColor(item.malfunction.title)+';font-size: 18px'"></div>
                        </div>
                        <div class="col-9 p-0">
                            <h6 class="mb-0" style="font-size: 10px;font-weight: 600">
                                {{item.malfunction.title}}</h6>
                        </div>
                    </div>
                    <div class="row w-100 mx-auto mb-2" style="
                            display: flex;
                            align-items: baseline;
                        ">
                        <div :class="item.status === 'Готово' ? 'col-8 ' : 'col-12'" class="p-0">
                            <div v-if="item.status === 'Актуальные'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время
                                    обращения</p>
                                <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">
                                    {{item.updated_at}}
                                </div>
                            </div>
                            <div v-if="item.status === 'В работе'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время начала
                                    работ</p>
                                <div class="mb-0 d-flex table-text" style="font-size: 10px;font-weight: 500">
                                    {{item.updated_at}}
                                </div>
                            </div>
                            <div v-if="item.status === 'Готово'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время окончания
                                    работ</p>
                                <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">
                                    {{item.updated_at}}
                                </div>
                            </div>
                        </div>
                        <div class="col-4 p-0" v-if="item.status === 'Готово'">
                            <div class="row w-100 m-auto justify-content-end">
                                <button title="Сформировать отчет" class="btn p-0 border-copy-button" @click="goToReports">
                                    <span style="font-size: 10px; border-bottom: 1px solid #9b65f2">Отчет</span>
                                </button>
                                <button class="btn p-0 disable-button" v-if="item.status !== 'Готово'" disabled>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100 mx-auto">
                        <div class="col-6 p-0">
                            <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">серийный номер
                                устройств</p>
                            <div class="d-flex" style="font-size: 10px;font-weight: 500">{{item.serialNumber}}</div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="row w-100 m-auto justify-content-end">
                                <div>
                                    <button class="btn mr-1 p-1 mdi mdi-chevron-right" @click="showItem(item.id)" style="height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF">
                                    </button>
                                </div>
                                <div v-if="item.status === 'Готово'">
                                    <button v-if="item.status === 'Готово'" class="btn p-1 mdi mdi-close" style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem" @click="deleteItem(item.id)">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div v-if="!loading" class="row w-100 justify-content-center">
        <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
    </div>

    <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center">
        <div style="color:#7c34f2" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <modal id="accept-remove">
        <template v-slot:header>
            Единичное удаление задачи
        </template>
        <template v-slot:main>

            <h4 class="w-100 text-center" v-if="removedAppeals">Вы хотите удалить
                ?</h4>

            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <button :disabled="!can('Удаление обращений')" class="btn w-100 btn-dark my-1 mr-1 py-2" @click="deleteAppeals()" style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
                        Удалить
                    </button>
                </div>
            </div>

        </template>
    </modal>
</div>
</template>

<script>
import Modal from "../../components/Modal";

export default {
    components: {
        Modal
    },
    name: "Appeals",
    props: [
        "format_table", "actual", "inWork", "ready", "boundary", "malfunction", "show_first", "deleted"
    ],
    data: () => ({
        // lodaing
        loading: false,
        removedAppeals: null,
        laravelData: {},
        data: []
    }),
    created() {
        this.getData();
    },
    computed: {

        sortedList() {

            let actual = [],
                inWork = [],
                ready = [];
            this.data.forEach(item => {
                switch (item.status) {
                    case "Актуальные":
                        actual.push(item);
                        break;
                    case "В работе":
                        inWork.push(item);
                        break;
                    case "Готово":
                        ready.push(item);
                        break;
                }
            });

            switch (this.show_first) {
                case "Актуальные":
                    return actual.concat(inWork, ready);
                case "В работе":
                    return inWork.concat(actual, ready);
                case "Готово":
                    return ready.concat(actual, inWork);
            }
        },
        filteredList() {
            /*

                            let tmp = this.sortedList.sort(function(a, b) {
                                return  new Date(a.created_at).getTime() - new Date(b.created_at).getTime();
                            })*/
            console.log(this.sortedList)
            return this.sortedList.filter(item => {
                let boundary = true,
                    malfunction = true,
                    deleted = true;

                if (this.boundary !== "") {
                    if (item.boundary) {
                        boundary = item.boundary.title.toLowerCase().includes(this.boundary.toLowerCase())
                    } else {
                        boundary = false
                    }
                }

                if (this.malfunction !== "") {
                    malfunction = item.malfunction.id === this.malfunction
                }
                if (!this.deleted) {
                    if (item.deleted_at) {
                        deleted = false;
                    }
                }
                return boundary && malfunction && deleted;
            })
        },
    },
    watch: {
        deleted: {
            handler: function () {
                this.getData()
            }
        },
        actual: {
            handler: function () {
                this.getData()
            }
        },
        ready: {
            handler: function () {
                this.getData()
            }
        },
        boundary: {
            handler: function () {
                this.getData()
            }
        },
        malfunction: {
            handler: function () {
                this.getData()
            }
        },
        show_first: {
            handler: function () {
                this.getData()
            }
        },
    },
    methods: {
        can(permission){
          return window.can(permission)
        },
        restore(item) {
            axios
                .get(`/tasks/restore/${item.id}`)
                .then(resp => {
                    this.sendNotify('Вы успешно восстановили обращение', 'success');
                    window.location.href = `/home`;
                })
                .catch(() => {
                    this.sendNotify('Ошибка восстановления обращения', 'error');
                });

        },
        goToReports(item) {

            if (item.boundary != null)
                localStorage.setItem("report", JSON.stringify({
                    type: 3,
                    boundary: item.boundary,
                }));

            if (item.device != null)
                localStorage.setItem("report", JSON.stringify({
                    type: 1,
                    device: item.device,
                    user: null
                }));
            window.location.href = "/reports/add"

        },
        editItem(id) {
            window.location.href = `/tasks/edit/${id}`;
        },
        showItem(id) {
            window.location.href = `/tasks/${id}`;
        },

        deleteItem(item) {
            this.removedAppeals = item;

            $('#accept-remove').modal('show')
        },
        deleteAppeals() {
            let id = this.removedAppeals.id
            const removeIndex = this.data.map(item => item.id).indexOf(id);
            this.data.splice(removeIndex, 1);

            $('#accept-remove').modal('hide')
            axios
                .delete(`/task/${id}`)
                .then((resp) => {
                    this.sendNotify('Вы успешно удалили обращение', 'success');
                    //this.data = resp.data.data;
                })
                .catch((resp) => {
                    this.sendNotify('Ошибка удаления задачи', 'error');
                });
        },
        getData(page = 1) {
            this.loading = true;
            axios
                .get("/task?page=" + page, {
                    params: {
                        deleted: this.deleted ? 1 : 0,
                        actual: this.actual ? 1 : 0,
                        ready: this.ready ? 1 : 0,
                        boundary: this.boundary,
                        malfunction: this.malfunction,
                        direction: this.show_first == "Актуальные" ? "asc" : "desc"
                    }
                })
                .then((resp) => {
                    this.loading = false;
                    this.data = resp.data.data;
                    this.laravelData = resp.data;
                })
                .catch((resp) => {
                    this.loading = false;
                    console.log(resp);
                });
        },
        getIcon(error) {
            switch (error) {
                case "Нет ответа от камеры":
                    return "mdi-block-helper";
                case "Низкий заряд аккумулятора":
                    return "mdi-battery-10";
                case "Камера загрязнена":
                    return "mdi-broom";
                case "Сертификат":
                    return "mdi-certificate";
                default:
                    return "mdi-block-helper";
            }
        },
        getIconColor(error) {
            switch (error) {
                case "Сертификат":
                    return "#6917f1";
                default:
                    return "#d93030";
            }
        },
        sendNotify(notification, type = 'primary') {
            this.$notify({
                title: 'Обращения',
                text: notification,
                type: type
            });
        }
    },
}
</script>

<style scoped>

</style>
