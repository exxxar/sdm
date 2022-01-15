<template>
    <div>
        <div
            class="row mx-auto mt-2 align-items-center"
            v-if="selected.length > 0"
            style="padding: 15px; border-top: 1px solid #dfe1ee; border-left: 1px solid #dfe1ee; border-right: 1px solid #dfe1ee; border-radius: 5px"
        >
            <div class="col-8">
                <div class="row w-100 mx-auto align-items-center">
                    <div
                        style="display: flex"
                        class="mr-2 mt-1"
                        :key="device.id"
                        v-for="device in selected"
                    >
                        <div class="mr-1">{{ device.title }}</div>
                        <div
                            v-on:click="uncheck(device)"
                            style="cursor: pointer; width: 23px; height: 23px; background-color: rgb(218,48,48); display: flex; align-items: center; justify-content: center; border-radius: 50px"
                        >
                            <svg
                                style="width: 7px; height: 7px"
                                version="1.1"
                                id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512.001 512.001"
                                xml:space="preserve"
                            >
                                <g>
                                    <g>
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-4 custom-filter"
                style="display: flex; align-items: center; justify-content: flex-end"
            >
                (всего {{ selected.length }})
                <button
                    class="btn border-copy-button pt-0 pb-0"
                    v-on:click="checkAll()"
                >
                    <span
                        style="font-size: 10px; border-bottom: 2px solid #7c34f2"
                    >Выбрать все</span
                    >
                </button>
                <button
                    class="btn mdi mdi-close"
                    v-on:click="uncheckAll()"
                    style="height:36px; width: 36px; min-width: 36px; background: transparent; color: red; font-size: 15px"
                ></button>
            </div>
        </div>

        <div
            style="padding-bottom: 10px"
            class="row w-100 mx-auto mt-3 align-items-center justify-content-center"
        >
            <div
                @click="sort('title')"
                style="cursor: pointer;"
                class="custom-filter col-6 pl-0"
            >
                Название группы<i
                v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                v-if="currentSort == 'title'"
                class="fas fa-angle-down filter-icon"
            ></i>
            </div>
            <div
                @click="sort('boundaries_count')"
                style="cursor: pointer;"
                class="custom-filter col-2"
            >
                Кол-во рубежей<i
                v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                v-if="currentSort == 'boundaries_count'"
                class="fas fa-angle-down filter-icon"
            ></i>
            </div>
            <div
                @click="sort('devices_count')"
                style="cursor: pointer;"
                class="custom-filter col-2"
            >
                Кол-во устройств<i
                v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                v-if="currentSort == 'devices_count'"
                class="fas fa-angle-down filter-icon"
            ></i>
            </div>
            <div class="custom-filter col-2"></div>
        </div>
        <div
            class="row w-100 mx-auto align-items-center justify-content-center"
        >
            <div
                class="col-12 p-0"
                :key="item.id"
                v-for="(item, index) in sortedList"
            >
                <div
                    v-bind:class="{ 'checked-border': isSelected(item.id) }"
                    class="row w-100 mx-auto mb-1 py-3 px-3 px-sm-0 align-items-center justify-content-center"
                    style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; "
                >
                    <div class="col-12 col-md-6">
                        <div
                            class="row w-100 my-1 align-items-center justify-content-start"
                        >
                            <div
                                class="form-check form-check-inline custom-menu-checkbox"
                                style="padding-left: 28px"
                            >
                                <input
                                    :id="'checkbox-' + index + 2"
                                    :name="'checkbox-' + index + 2"
                                    class="checkbox-custom"
                                    @change="check(item, item.selected)"
                                    type="checkbox"
                                    v-model="item.selected"
                                />
                                <label
                                    :id="'checkbox-' + index + 2"
                                    :for="'checkbox-' + index + 2"
                                    style="font-size:14px;"
                                    class="checkbox-custom-label"
                                ></label>
                            </div>
                            <div
                                v-on:click="editDevice(item.id)"
                                class="serial-number"
                            >
                                {{ item.title }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div
                            class="d-flex table-text"
                            style="font-size: 12px;font-weight: 500"
                        >
                            {{ item.boundaries_count }}
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div
                            class="d-flex table-text"
                            style="font-size: 12px;font-weight: 500"
                        >
                            {{ item.devices_count }}
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div
                            style="display: flex;
                                            align-items: center;
                                            width: 116px;
                                            justify-content: center; flex-wrap:wrap"
                            v-if="item.deleted_at"
                        >
                            <p
                                style="font-size: 14px; color: red; margin-bottom: 0"
                            >
                                Удалена
                            </p>
                            <a :disabled="!can('Восстановление группы рубежей')" href="#resotre" style="color:green;" @click="restore(item)">Восстановить</a>
                        </div>
                        <div
                            v-if="!item.deleted_at"
                            class="row w-100 mx-auto my-1 align-items-center"
                            style="justify-content: flex-end;"
                        >
                            <button
                                :disabled="!can('Изменение группы рубежей')"
                                v-if="!item.deleted_at"
                                class="btn"
                                v-on:click="editDevice(item.id)"
                                style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;"
                            >
                                <svg
                                    id="Capa_1"
                                    style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px"
                                    enable-background="new 0 0 488.471 488.471"
                                    height="512"
                                    viewBox="0 0 488.471 488.471"
                                    width="512"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="m166.093 240.214h88.205v194.288h-88.205z"
                                        transform="matrix(.707 -.707 .707 .707 1.415 9.959)"
                                    />
                                    <path
                                        d="m245.547 105.541-245.547 245.547v137.382h137.382l245.548-245.547z"
                                    />
                                </svg>
                            </button>

                            <button
                                v-if="!item.deleted_at"
                                class="btn"
                                :disabled="!can('Удаление группы рубежей')"
                                v-on:click="askForDelete(item)"
                                style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;"
                            >
                                <svg
                                    style="width: 14px; height: 14px; min-width: 14px; min-height: 14px"
                                    version="1.1"
                                    id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px"
                                    y="0px"
                                    viewBox="0 0 512.001 512.001"
                                    xml:space="preserve"
                                >
                                    <g>
                                        <g>
                                            <path
                                                fill="red"
                                                d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                            />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <modal id="accept-remove">
            <template v-slot:header>
                Единичное удаление пользователя
            </template>
            <template v-slot:main>

                <h4 class="w-100 text-center" v-if="removedItem">Вы хотите удалить?</h4>
                <div class="row d-flex justify-content-center">
                    <div class="col-4">
                        <button :disabled="!can('Удаление группы рубежей')" class="btn w-100 btn-dark my-1 mr-1 py-2"
                                @click="deleteBondaryGroup( removedItem.id)"
                                style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;">
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
        name: "BoundaryGroups",
        props: ["title", "deleted"],
        data: () => ({
            // sort
            currentSort: "title",
            currentSortDir: "asc",
            data: [],
            selected: [],
            removedItem: null,
        }),
        created() {
            this.getData();
        },
        computed: {
            sortedList: function () {
                return this.filteredList.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === "desc") modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort])
                        return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort])
                        return 1 * modifier;
                    return 0;
                });
            },
            filteredList() {
                return this.data.filter(item => {
                    const title = item.title
                        .toLowerCase()
                        .includes(this.title.toLowerCase());

                    let deleted = true;

                    if (!this.deleted) {
                        if (item.deleted_at) {
                            deleted = false;
                        }
                    }

                    return title && deleted;
                });
            }
        },
        methods: {
            can(permission){
              return window.can(permission)
            },
            askForDelete(item) {
                this.removedItem = item

                $('#accept-remove').modal('show')
            },
            restore(item) {

                axios
                    .get(`/boundary-groups/restore/${item.id}`)
                    .then(resp => {
                        this.sendNotify('Вы успешно восстановили группы рубежей', 'success');
                        window.location.href = `/boundary-groups`;
                    })
                    .catch(() => {

                        this.sendNotify('Ошибка восстановления группы рубежей', 'error');
                    });

            },
            sort: function (s) {
                //if s == current sort, reverse
                if (s === this.currentSort) {
                    this.currentSortDir =
                        this.currentSortDir === "asc" ? "desc" : "asc";
                }
                this.currentSort = s;
            },
            uncheck: function (device) {
                const index = this.selected
                    .map(select => select.id)
                    .indexOf(device.id);
                if (index !== -1) {
                    this.selected.splice(index, 1);
                }
                const indexData = this.data
                    .map(select => select.id)
                    .indexOf(device.id);
                if (indexData !== -1) {
                    this.data[indexData].selected = false;
                }
            },
            checkAll: function () {
                this.filteredList.forEach(device => {
                    device.selected = true;
                });
                this.selected = this.filteredList;
            },
            uncheckAll: function () {
                this.selected.forEach(device => {
                    const indexData = this.data
                        .map(select => select.id)
                        .indexOf(device.id);
                    if (indexData !== -1) {
                        this.data[indexData].selected = false;
                    }
                });
                this.selected = [];
            },
            isSelected: function (id) {
                const index = this.selected.map(item => item.id).indexOf(id);
                return index !== -1;
            },
            check: function (item, selected) {
                if (selected) {
                    this.selected.push(item);
                } else {
                    const index = this.selected
                        .map(select => select.id)
                        .indexOf(item.id);
                    if (index !== -1) {
                        this.selected.splice(index, 1);
                    }
                }
                //const index = this.data.map(item => item.id).indexOf(id);
                //this.data[index].selected = selected;
            },
            getData() {
                axios
                    .get("/boundary-group")
                    .then(resp => {
                        this.data = resp.data.data;
                        this.data.forEach(item => {
                            item.selected = false;
                        });
                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });
            },
            editDevice(id) {
                window.location.href = `/boundary-groups/edit/${id}`;
            },
            deleteBondaryGroup(id) {
                const removeIndex = this.data.map(item => item.id).indexOf(id);
                this.data.splice(removeIndex, 1);
                axios
                    .delete(`/boundary-group/${id}`)
                    .then(resp => {
                        this.sendNotify('Вы успешно удалили группу рубежей', 'success');
                        $('#accept-remove').modal('hide')
                    })
                    .catch( ()=> {
                        this.sendNotify('Ошибка удаления группы рубежей', 'error');
                        $('#accept-remove').modal('hide')
                    });
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Группы рубежей',
                    text: notification,
                    type: type
                });
            }
        }
    };
</script>

<style scoped>
    .sort-icon-rotation {
        transform: rotate(180deg);
    }

    .serial-number {
        cursor: pointer;
        font-size: 14px;
        word-break: break-all;
        min-width: 70px;
    }

    .serial-number:hover {
        color: #7c34f2 !important;
    }

    .custom-filter {
        color: #9d9ea5;
        font-size: 12px;
    }

    .filter-icon {
        color: #7c34f2;
        margin-left: 5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 30px;
        height: 20px;
        margin-bottom: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        border: 1px solid red;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 11px;
        width: 11px;
        left: 4px;
        bottom: 4px;
        background-color: red;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    input:checked + .slider {
        background-color: white;
    }

    /*input:focus + .slider {*/
    /*    box-shadow: 0 0 1px #2196F3;*/
    /*}*/

    input:checked + .slider:before {
        -webkit-transform: translateX(10px);
        -ms-transform: translateX(10px);
        transform: translateX(10px);
        background-color: green;
    }

    input:checked + .slider {
        border: 1px solid green;
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .switch-label {
        margin-bottom: 0;
        font-size: 10px;
    }
</style>
