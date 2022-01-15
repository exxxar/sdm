<template>
    <div>
        <div class="row w-100 m-auto justify-content-center align-items-center">
            <div class="col-12 col-md-4 p-0 mt-3">
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
                <div class="form-check form-check-inline d-none">
                    <input
                        id="checkbox-2"
                        class="checkbox-custom"
                        name="checkbox-2"
                        type="checkbox"
                        v-model="inWork"
                    />
                    <label
                        for="checkbox-2"
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
            <div class="col-4 offset-6 col-md-2 p-0">
                <div
                    class="row w-100 mx-auto align-items-end justify-content-end"
                >
                    <div>
                        <button
                            class="btn p-1 mr-2 mdi mdi-view-sequential"
                            :class="{ 'active-toggler' : format_table }"
                            style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                            v-on:click="format_table = true"
                        ></button>
                    </div>

                    <button
                        class="btn p-1 mdi mdi-apps"
                        :class="{ 'active-toggler' : !format_table }"
                        style="height:36px; width: 36px; min-width: 36px; border-color: #dfe1ee"
                        v-on:click="format_table = false"
                    ></button>
                </div>
            </div>
        </div>
        <div class="row w-100 mx-auto mt-3 align-items-center justify-content-center" v-if="(data || data.length>0)&&!loading&&format_table===true">
            <div v-if="item.device.serial === device.serial && (actual && item.status === 'Актуальные' || inWork && item.status === 'В работе' || ready && item.status === 'Готово')" class="col-12 p-0" v-for="item in data">
                <div class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center"  style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; ">
                    <div class="col-12 col-md-4 col-sm-12">
                        <div class="row w-100 my-1 align-items-center justify-content-start">
                            <div class="col-2">
                                <div v-if="item.status === 'Актуальные'" class="p-1 mdi mdi-bookmark" style="color: #d93030; border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                                <div v-if="item.status === 'В работе'" class="p-1 mdi mdi-bookmark" style="color: #6633ff; border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                                <div v-if="item.status === 'Готово'" class="p-1 mdi mdi-bookmark" style="color: #458e3c;border-right: 1px solid #e3e3e5; font-size: 18px; width: 36px"></div>
                            </div>
                            <div class="col-10">
                                <h6 class="ml-1 mb-0" style="font-size: 12px;font-weight: 300" v-if="item.boundary">{{item.boundary.title}}</h6>
                                <h6 class="ml-1 mb-0" style="font-size: 12px;font-weight: 300" v-else>Не указан</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 p-sm-0">
                        <div class="row m-auto my-1 align-items-center justify-content-center" style="padding-left:10px;border: 1px solid #e3e3e5">
                            <div class="col-2 p-0 mr-1">
                                <div :class="'p-1 mr-1 mdi '+getIcon(item.malfunction.title)" style="color:#d93030;font-size: 18px"></div>
                            </div>
                            <div class="col-9 p-0">
                                <h6 class="ml-1 mb-0" style="font-size: 10px;font-weight: 600">{{item.malfunction.title}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div class="my-1">
                            <div v-if="item.status === 'Актуальные'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время обращения</p>
                                <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.created_at}}</div>
                            </div>
                            <div v-if="item.status === 'В работе'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время начала работ</p>
                                <div class="mb-0 d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.started_at}}</div>
                            </div>
                            <div v-if="item.status === 'Готово'">
                                <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время окончания работ</p>
                                <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.executed_at}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div class="my-1">
                            <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">серийный номер устройства</p>
                            <div class="d-flex" style="font-size: 10px;font-weight: 500">{{item.device.serial}}</div>
                        </div>

                    </div>
                    <div class="col-12 col-sm-12 col-md-2">
                        <div style="flex-wrap: nowrap" class="row w-100 mx-auto my-1 align-items-center justify-content-end">
                            <button class="btn mr-6 mt-1 border-copy-button" v-if="item.status === 'Готово'" @click="goToReports(item)">
                                <span style="font-size: 10px; border-bottom: 1px solid #9b65f2">Отчет</span>
                            </button>
                            <button class="btn p-1 mr-2 mdi mdi-chevron-right" @click="editItem(item.id)" style="height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF">
                            </button>
                            <button
                                v-if="item.status === 'Готово'"
                                class="btn p-1 mr-2 mdi mdi-close"
                                style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                                @click="deleteItem(item.id)"
                            >
                            </button>
                            <button
                                v-else
                                class="btn p-1 mr-2 mdi mdi-close"
                                style="height:36px; width: 36px; min-width: 36px; background: #dfe1ee; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                                disabled
                            >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="(data || data.length>0)&&!loading&&format_table!==true" class="row w-100 m-auto row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 align-items-start">
            <div v-if="item.device.serial === device.serial && (actual && item.status === 'Актуальные' || inWork && item.status === 'В работе' || ready && item.status === 'Готово')" class="col-12 col-lg-3 col-md-6 px-2" v-for="item in data">
                <div class="card h-100 p-2 my-2" style="max-width: 340px; border-radius:5px; border:0;">
                    <div class="card-body">
                        <div class="row w-100  mx-auto mb-2  justify-content-start">
                            <div class="col-12 p-0" style="display: flex;flex-wrap: nowrap;align-items: center;justify-content: space-between;">
                                <h6 class="mb-0 card-title" style="font-size: 12px;font-weight: 300;">{{item.boundary.title}}</h6>
                                <div v-if="item.status === 'Актуальные'" class="mdi mdi-bookmark" style="color: #d93030; font-size: 18px; padding-right: 0"></div>
                                <div v-if="item.status === 'В работе'" class="mdi mdi-bookmark" style="color: #6633ff; font-size: 18px; padding-right: 0"></div>
                                <div v-if="item.status === 'Готово'" class="mdi mdi-bookmark" style="color: #458e3c; font-size: 18px; padding-right: 0"></div>
                            </div>
                        </div>
                        <div class="row mx-auto mb-2 align-items-center justify-content-center" style="border: 1px solid #e3e3e5; padding-left: 10px">
                            <div class="col-2 p-0 mr-1">
                                <div :class="'p-1 mr-1 mdi '+getIcon(item.malfunction.title)" style="color:#d93030;font-size: 18px"></div>
                            </div>
                            <div class="col-9 p-0">
                                <h6 class="mb-0" style="font-size: 10px;font-weight: 600">{{item.malfunction.title}}</h6>
                            </div>
                        </div>
                        <div class="row w-100 mx-auto mb-2" style="
                            display: flex;
                            align-items: baseline;
                        ">
                            <div :class="item.status === 'Готово' ? 'col-8 ' : 'col-12'" class="p-0">
                                <div v-if="item.status === 'Актуальные'">
                                    <p class="mb-0 d-flex" style="font-size: 9px; color: #959597">дата и время обращения</p>
                                    <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.created_at}}</div>
                                </div>
                                <div v-if="item.status === 'В работе'">
                                    <p class="mb-0 d-flex"  style="font-size: 9px; color: #959597">дата и время начала работ</p>
                                    <div class="mb-0 d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.started_at}}</div>
                                </div>
                                <div v-if="item.status === 'Готово'">
                                    <p class="mb-0 d-flex"  style="font-size: 9px; color: #959597">дата и время окончания работ</p>
                                    <div class="d-flex table-text" style="font-size: 10px;font-weight: 500">{{item.executed_at}}</div>
                                </div>
                            </div>
                            <div  class="col-4 p-0" v-if="item.status === 'Готово'">
                                <div class="row w-100 m-auto justify-content-end" >
                                    <button class="btn p-0 border-copy-button" @click="goToReports(item)">
                                        <span style="font-size: 10px; border-bottom: 1px solid #9b65f2">Отчет</span>
                                    </button>
                                    <button class="btn p-0 disable-button" v-if="item.status !== 'Готово'" disabled>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100 mx-auto">
                            <div class="col-6 p-0">
                                <p class="mb-0 d-flex"  style="font-size: 9px; color: #959597">серийный номер устройств</p>
                                <div class="d-flex" style="font-size: 10px;font-weight: 500">{{item.serialNumber}}</div>
                            </div>
                            <div class="col-6 p-0">
                                <div class="row w-100 m-auto justify-content-end">
                                    <div>
                                        <button class="btn mr-1 p-1 mdi mdi-chevron-right" @click="editItem(item.id)" style="height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF">
                                        </button>
                                    </div>
                                    <div v-if="item.status === 'Готово'">
                                        <button
                                            v-if="item.status === 'Готово'"
                                            class="btn p-1 mdi mdi-close"
                                            style="height:36px; width: 36px; min-width: 36px; background: #458e3c; color: #FFFFFF; font-size: 24px; line-height: 1rem"
                                            @click="deleteItem(item.id)"
                                        >
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row w-100 m-auto my-3 align-items-center justify-content-center" v-if="loading">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center">
                    <h3 class="sdm-primary-label sdm-primary-text" style="font-size:1.375rem">Загрузка</h3>
                </div>
            </div>
        </div>
        <div class="row w-100 mx-auto my-3 align-items-center justify-content-center" v-if="(!data || data.length==0)&&!loading">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center">
                    <h3 class="sdm-primary-label sdm-primary-text" style="font-size:1.375rem">Нет записей</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Appeals",
        props: ['device'],
        data: () => ({
            data: [],
            actual: true,
            inWork: true,
            ready: true,
            format_table: true,
            loading:false,
        }),
        created() {
            this.getData();
        },
        methods: {
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
            deleteItem(id) {
                const removeIndex = this.data.map(item => item.id).indexOf(id);
                this.data.splice(removeIndex, 1);
                axios
                    .delete(`/task/${id}`)
                    .then((resp) => {
                        console.log(resp);
                        this.sendNotify('Вы успешно удалили обращение устройства', 'success');
                        //this.data = resp.data.data;
                    })
                    .catch(function(resp) {
                        console.log(resp);
                    });
            },
            getData() {
                this.loading=true;
                axios
                    .post("/task/getByDeviceId",{
                        id: this.device.id
                    })
                    .then((resp) => {
                        this.data = resp.data.data;
                        this.loading=false;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.sendNotify("Произошла ошибка, не удалось загрузить обращения устройства, повторите позже", "error")
                        this.loading=false;
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
                    default:
                        return "mdi-block-helper"
                }
            },
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Устройства',
                    text: notification,
                    type: type
                });
            }
        },
    }
</script>

<style scoped>

</style>
