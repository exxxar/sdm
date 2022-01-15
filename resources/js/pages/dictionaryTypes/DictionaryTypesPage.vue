<template>
    <layout title="Справочники" :info="true" :info_text="'Это справочники.'">
        <template v-slot:menu>
            <div class="row w-100 m-auto justify-content-end align-items-center">
                <div style="z-index: 9" class="col-12 col-md-9">
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
                            <div class="mx-3 mdi mdi-dots-horizontal"
                                 style="color: rgb(157, 158, 165);font-size: 17px;">
                            </div>
                        </li>
                        <li class="" aria-current="page">
                            <a
                                href="/dictionary-types"
                                style="color: #9d9ea5; text-decoration: none"
                            >
                                Справочники
                            </a>
                        </li>
                        <li class="">
                            <div class="mx-3 mdi mdi-dots-horizontal"
                                 style="color: rgb(157, 158, 165);font-size: 17px;">
                            </div>
                        </li>
                        <li class="" aria-current="page">
                            <a href="#" v-if="dictionary_type !==''"
                               style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                                {{dictionary_type_title}}
                            </a>
                            <a href="#" v-else
                               style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px">
                                Все
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-12 col-md-3">
                    <user-menu :user="user"></user-menu>
                </div>
                <div class="col-12" style="border-bottom: 1px solid #e3e3e5"
                ></div>
            </div>
        </template>
        <template v-slot:header>
            <div class="row w-100 m-auto justify-content-end align-items-center pb-2 mb-3">
                <div class="col-12 col-md-3 col-sm-6 pr-0 pl-0">
                    <button v-on:click="addDictionaryType" class="btn w-100 my-1 py-2 border-copy-button px-3 ">
                        <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                            Добавить справочник
                        </span>
                    </button>
                </div>
                <div class="col-12 col-md-3 col-sm-6 pl-0 pr-0 pr-sm-1">

                    <input type="file" id="file" style="display:none" ref="file" v-on:change="handleFileUpload()"/>


                    <label for="file"
                           class="btn w-100 btn-dark my-1 mr-1 py-2"
                           style="background: transparent;border: 1px solid #7224f2;color: black;font-size: 11px;font-weight: 500;"
                    >Загрузить из файла</label>
                    <a class="sub-text" target="_blank" href="/templates/dict">Скачать шаблон</a>
                </div>
            </div>
        </template>
        <template v-slot:filters>
            <div class="row w-100 m-auto justify-content-center align-items-center">
                <div class="col-md-3 pl-0 pr-1 ">
                    <p class="mb-1 d-flex sdm-secondary-text">
                        Выберите справочник
                    </p>
                    <select
                        class="sdm-select"
                        style="color: black; font-weight: 500; font-size: 12px; border-color: #dfe1ee"
                        v-model="dictionary_type"
                        @change="selectDictionaryType"
                    >
                        <option value="" selected>Все</option>
                        <option v-for="item in dictionary_types" :key="item.id" :value="item.id">{{item.title}}</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 px-1 ">
                    <p class="mb-1 d-flex" style="font-size: 9px; color: #959597; font-weight: 400; visibility: hidden">
                        удаленные
                    </p>
                    <div class="form-check form-check-inline float-left">
                        <input
                            id="checkbox-2"
                            class="checkbox-custom"
                            name="checkbox-2"
                            type="checkbox"
                            v-model="deleted"
                        />
                        <label for="checkbox-2" class="checkbox-custom-label">
                            Удаленные
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-7 px-0">
                    <div class="row w-100 m-auto justify-content-end align-items-center">
                        <div class="col-4 px-0">
                            <p
                                class="mb-1 d-flex sdm-secondary-text"
                                style="visibility: hidden"
                            >
                                Редактировать справочник
                            </p>
                            <button v-on:click="editDictionaryType"
                                    :hidden="dictionary_type==''|| dictionary_type=='Роли'"
                                    class="btn w-100 my-1 py-2 border-copy-button px-3 ">
                                <span style="font-size: 10px; border-bottom: 2px solid #7224f2">
                                    Редактировать справочник
                                </span>
                            </button>
                        </div>
                        <div class="col-4 px-0">
                            <p
                                class="mb-1 d-flex sdm-secondary-text"
                                style="visibility: hidden"
                            >
                                Добавить пункт
                            </p>
                            <button
                                v-on:click="addDictionary"
                                :hidden="dictionary_type==''"
                                type="button"
                                class="btn w-100 float-right btn-dark my-1 mr-1 py-2 px-3"
                                style="background: #7224f2;border:none;color: white;font-size: 11px;font-weight: 500;"
                            >
                                Добавить пункт
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:main>
            <dictionary-types
                :dictionaries="dictionaries"
                :dictionary_type="dictionary_type"
                :deleted="deleted"
            ></dictionary-types>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/Layout";
    import DictionaryTypes from "../../components/dictionaryTypes/DictionaryTypes";

    export default {
        name: "DictionaryTypesPage",
        props: ['user', 'dictionary_types', 'dictionaries'],
        components: {Layout, DictionaryTypes},
        data: () => ({
            // filters
            deleted: false,
            dictionary_type: '',
            dictionary_type_title: '',
            file: ''
        }),
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];

                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('/send-dictionary-file',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(resp => {
                    this.sendNotify('Файл успешно загружен', 'success');

                    window.location.href = '/dictionary-types'
                })
                    .catch(() => {
                        this.sendNotify('Ошибка загрузки файла', 'error');
                    });
            },
            addDictionaryType() {
                window.location.href = "/dictionary-types/add";
            },
            editDictionaryType() {
                window.location.href = "/dictionary-types/edit/" + this.dictionary_type;
            },
            addDictionary() {
                window.location.href = "/dictionaries/add/" + this.dictionary_type;
            },
            getFromFile() {
                this.sendNotify("Данная возможность в разработке")
            },
            selectDictionaryType() {
                let index = this.dictionary_types.findIndex(item => item.id == this.dictionary_type);
                if (index > -1) {
                    this.dictionary_type_title = this.dictionary_types[index].title
                }
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Справочники',
                    text: notification,
                    type: type
                });
            }
        }
    }
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
</style>
