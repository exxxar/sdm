<template>
    <div class="row w-100 m-auto  align-items-center justify-content-start">
        <div class="col-md-4  px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12 px-0">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Название справочника
                    </p>
                    <input
                        v-model="edited_dictionary_type.title"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
                </div>
                <div class="col-12 px-0">
                    <p class="mb-1 mt-3 d-flex sdm-secondary-text">
                        Примечание
                    </p>
                    <input
                        v-model="edited_dictionary_type.description"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                    />
                </div>


                <div class="col-12 px-0 d-flex justify-content-end">
                    <button
                        v-on:click="deleteDictionaryType"
                        type="button"
                        class="btn btn-danger py-2 px-3 mt-3 float-right mr-2"
                        style="border: none;color: white;font-size: 11px;font-weight: 500;"
                        :disabled="loading"
                    >
                        Удалить
                    </button>

                    <button
                        v-on:click="editDictionaryType"
                        type="button"
                        class="btn btn-dark py-2 px-3 mt-3 float-right"
                        style="background: #7224f2;border: none;color: white;font-size: 11px;font-weight: 500;"
                        :disabled="loading"
                    >
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DictionaryTypesEdit",
        props:['dictionary_type'],
        data: () => ({
            edited_dictionary_type: {
                title: '',
                description: '',
                permissions: null,
            },
            loading: false,
        }),
        mounted() {
            this.edited_dictionary_type.title = this.dictionary_type.title;
            this.edited_dictionary_type.description = this.dictionary_type.description;

        },
        methods:{
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Отчеты',
                    text: notification,
                    type: type
                });
            },
            deleteDictionaryType(){
                axios
                    .delete(`/dictionary-type/${this.dictionary_type.id}`).then(resp => {
                    this.sendNotify("Словарь успешно удален", "success")
                    window.location.href = "/dictionary-types";

                })
            },
            editDictionaryType() {
                this.loading = true;
                //todo: TRY method for editing dictionary type
                axios
                    .patch(`/dictionary-type/${this.dictionary_type.id}`, this.edited_dictionary_type)
                    .then(()=> {
                        this.sendNotify('Тип словаря успешно обнолвен', 'success');
                        window.location.href = "/dictionary-types";
                    })
                    .catch(error => {
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');

                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }
                        this.loading = false;

                    });
            }
        }
    }
</script>

<style scoped>

</style>
