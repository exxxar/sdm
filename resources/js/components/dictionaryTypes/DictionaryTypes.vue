<template>
    <div>
        <div
            class="row mx-auto my-2 align-items-center"
            v-if="selected.length > 0"
            style="padding: 15px; border: 1px solid #dfe1ee; border-radius: 5px"
        >
            <div class="col-8">
                <div class="row w-100 mx-auto align-items-center">
                    <div
                        style="display: flex"
                        class="mr-2 mt-1"
                        :key="dictionary.id"
                        v-for="dictionary in selected"
                    >
                        <div class="mr-1">{{ dictionary.title }}</div>
                        <div
                            v-on:click="uncheck(dictionary)"
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
                                <path
                                    fill="white"
                                    d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                    L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                    c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                    c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                />
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
                    >
                        Выбрать все</span
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
            class="row w-100 mx-auto mt-2 align-items-center justify-content-center sdm-primary-text"
        >
            <div
                class="custom-filter col-4 pl-0"
                @click="sort('title')"
                style="cursor: pointer;"
            >
                Название
                <i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'title'"
                    class="fas fa-angle-down filter-icon"
                >
                </i>
            </div>
            <div
                class="custom-filter col-5 px-1"
                @click="sort('description')"
                style="cursor: pointer; padding-left: 30px"
            >
                Примечание
                <i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'description'"
                    class="fas fa-angle-down filter-icon"
                >
                </i>
            </div>
            <div class="custom-filter col-3 pr-0"></div>
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
                    style="background: #FFFFFF; border-radius: 5px; flex-wrap: nowrap"
                >
                    <div class="col-md-4 pl-0">
                        <div
                            class="row w-100 my-1 align-items-center justify-content-start"
                        >
                            <div
                                class="form-check form-check-inline custom-menu-checkbox"
                                style="padding-left: 30px"
                            >
                                <input
                                    :id="'checkbox-' + index + 2"
                                    :name="'checkbox-' + index + 2"
                                    class="checkbox-custom"
                                    @change="check(item)"
                                    type="checkbox"
                                    v-model="item.selected"
                                />
                                <label
                                    :id="'checkbox-' + index + 2"
                                    :for="'checkbox-' + index + 2"
                                    style="font-size:14px;"
                                    class="checkbox-custom-label"
                                >
                                </label>
                                {{ item.title }}
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-12 col-md-5 px-1"
                        style="display: flex; align-items: center"
                    >
                        <div
                            class="d-flex table-text sdm-primary-text"
                            style="color:#74747d"
                            v-if="
                                item.description != null &&
                                    item.description.trim() != ''
                            "
                        >
                            {{ item.description }}
                        </div>
                        <div
                            class="d-flex table-text sdm-primary-text"
                            style="color:#74747d"
                            v-else
                        >
                            Примечаний нет
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 pr-0">
                        <div
                            style="flex-wrap: nowrap; justify-content: end"
                            class="row w-100 mx-auto my-1 align-items-center"
                        >
                            <div style="display: flex" class="mr-2">
                                <button
                                    class="btn"
                                    :disabled="!can('Изменение справочника')"
                                    v-on:click="editDictionary(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;"
                                    title="Редактировать справочник"
                                    v-if="!item.deleted_at"
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
                                    v-if="
                                        systemCheck(item) &&
                                            item.deleted_at === null
                                    "
                                    class="btn"
                                    :disabled="!can('Удаление справочника')"
                                    v-on:click="checkForRemove(item)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;"
                                    title="Удалить"
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
                                        <path
                                            fill="red"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </svg>
                                </button>
                                <div
                                    v-if="item.deleted_at != null"
                                    style="display:flex; flex-wrap:wrap; justify-content:center;width:100%;"
                                >
                                    <p
                                        class="w-100"
                                        style="color:red;margin:0;text-align:center;"
                                    >
                                        Удалено
                                    </p>
                                    <a
                                        :disabled="
                                            !can('Восстановление справочника')
                                        "
                                        href="#restore"
                                        @click="restore(item.id)"
                                        style="color:green;margin:0;"
                                    >
                                        Восстановить</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <modal id="accept-remove-dict">
            <template v-slot:header>
                Единичное удаление словаря
            </template>
            <template v-slot:main>
                <h4 class="w-100 text-center" v-if="removedDictionary">
                    Вы хотите удалить
                    <strong>{{ removedDictionary.title }}</strong> ?
                </h4>
                <div class="row d-flex justify-content-center">
                    <div class="col-4">
                        <button
                            :disabled="!can('Удаление справочника')"
                            class="btn w-100 btn-dark my-1 mr-1 py-2"
                            @click="deleteDictionary(removedDictionary.id)"
                            style="background: rgb(114, 36, 242); border: none; color: white; font-size: 11px; font-weight: 500;"
                        >
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
    name: "DictionaryTypes",
    props: ["dictionaries", "dictionary_type", "deleted"],
    data: () => ({
        // sort
        currentSort: "",
        currentSortDir: "asc",
        //checkbox
        data: [],
        selected: [],
        removedDictionary: null
    }),
    created() {
        // this.getData();

        this.dictionaries.forEach(item => {
            item.selected = false;
        });
    },
    computed: {
        sortedList: function() {
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
            return this.dictionaries.filter(item => {
                let dictionary_type = true,
                    deleted = true;

                if (this.dictionary_type !== "") {
                    if (item.dictionary_type_id) {
                        dictionary_type =
                            item.dictionary_type_id === this.dictionary_type;
                    } else {
                        dictionary_type = false;
                    }
                }

                //todo:DONE TRY add field "deleted_at" to table "dictionaries"
                if (!this.deleted) {
                    if (item.deleted_at) {
                        deleted = false;
                    }
                }

                return dictionary_type && deleted;
            });
        }
    },
    watch: {
        data: {
            handler: function() {},
            deep: true
        }
    },
    methods: {
        systemCheck(item) {
            let array = ["Роли"];

            return !array.includes(item.title);
        },
        checkForRemove(dict) {
            this.removedDictionary = dict;

            $("#accept-remove-dict").modal("show");
        },
        sort: function(s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        uncheck: function(dictionary) {
            let index = this.selected.findIndex(el => el.id === dictionary.id);
            if (index !== -1) {
                let dictionary_index = this.filteredList.findIndex(
                    el => el.id === dictionary.id
                );
                this.filteredList[dictionary_index].selected = false;
                this.selected.splice(index, 1);
            }
        },
        checkAll: function() {
            this.selected = [];
            this.dictionaries.forEach(dictionary => {
                dictionary.selected = true;
                this.selected.push(dictionary);
            });
        },
        uncheckAll: function() {
            this.dictionaries.forEach(item => {
                item.selected = false;
            });
            this.selected = [];
        },
        check: function(item, selected) {
            let index = this.selected.findIndex(el => el.id === item.id);
            if (index !== -1) {
                this.selected.splice(index, 1);
            } else {
                this.selected.push(item);
            }
        },
        isSelected: function(id) {
            const index = this.selected.map(item => item.id).indexOf(id);
            return index !== -1;
        },
        getData() {
            axios
                .get("/dictionary")
                .then(resp => {
                    this.data = resp.data.data;
                    this.data.forEach(item => {
                        item.selected = false;
                    });
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        editDictionary(id) {
            window.location.href = `/dictionaries/edit/${id}`;
        },
        restore(id) {
            axios
                .get(`/dictionary/restore/${id}`)
                .then(resp => {
                    this.sendNotify(
                        "Вы успешно восстановили справочник",
                        "success"
                    );
                    window.location.href = `/dictionary-types`;
                })
                .catch(() => {
                    this.sendNotify(
                        "Ошибка восстановления справочника",
                        "error"
                    );
                });
        },
        deleteDictionary(id) {
            const removeIndex = this.data.map(item => item.id).indexOf(id);
            this.data.splice(removeIndex, 1);
            axios
                .delete(`/dictionary/${id}`)
                .then(resp => {
                    this.sendNotify("Вы успешно удалили справочник", "success");
                    window.location.href = `/dictionary-types`;
                })
                .catch(() => {
                    this.sendNotify("Ошибка удаления справочника", "error");
                });
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Справочники",
                text: notification,
                type: type
            });
        },
        can(i) {
            return true;
        }
    }
};
</script>

<style scoped></style>
