<template>
    <div class="row w-100 m-auto  align-items-center justify-content-start">
        <form v-on:submit.prevent="editDictionary" class="col-md-4  px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12 px-0">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Название пункта
                    </p>
                    <input
                        v-model="edited_dictionary.title"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
                </div>

                <div class="col-12 px-0" v-if="dictionary.title==='Роли'">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Роли и привелегии
                    </p>
                    <slot name="roles"></slot>
                </div>

                <div class="col-12 px-0" v-if="dictionary.title==='Типы устройств'">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Список типов устройств
                    </p>
                    <slot name="device_types"></slot>
                </div>


                <div class="col-12 px-0" v-if="dictionary.title==='Районы'">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Список районов
                    </p>
                    <slot name="regions"></slot>
                </div>

                <div class="col-12 px-0" v-if="dictionary.title==='Адреса'">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Список адресов
                    </p>
                    <slot name="locations"></slot>
                </div>


                <div class="col-12 px-0">
                    <p class="mb-1 mt-3 d-flex sdm-secondary-text">
                        Примечание
                    </p>
                    <input
                        v-model="edited_dictionary.description"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                        required
                    />
                </div>
                <div class="col-12 px-0">
                    <button
                        type="submit"
                        class="btn btn-dark py-2 px-3 mt-3 float-right"
                        style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        :disabled="loading"
                    >
                        Сохранить
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

    export default {
        name: "DictionariesEdit",
        props:['dictionary', 'dictionary_type_title','dictionary_type'],
        data: () => ({
            edited_dictionary: {
                title: '',
                description: '',
                dictionary_type_id: null
            },

            loading: false,
        }),
        created() {

        },
        mounted() {
            this.edited_dictionary.title = this.dictionary.title;
            this.edited_dictionary.description = this.dictionary.description;
            this.edited_dictionary.dictionary_type_id = this.dictionary.dictionary_type_id;


        },


        methods:{
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Отчеты',
                    text: notification,
                    type:type
                });
            },
            editDictionary() {
                axios
                    .patch(`/dictionary/${this.dictionary.id}`, this.edited_dictionary)
                    .then((resp)=> {
                            this.sendNotify("Словарь успешно обновлен")
                           window.location.href = "/dictionary-types"

                    })
                    .catch(error => {
                        this.sendNotify("Ошибка обновления словаря", "error")

                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }


                        this.loading = false;
                    });
            },

        }
    }
</script>

<style scoped>

</style>
