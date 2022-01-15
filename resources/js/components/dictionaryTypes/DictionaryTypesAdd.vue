<template>
    <div class="row w-100 m-auto  align-items-center justify-content-start">
        <form v-on:submit.prevent="createDictionaryType" class="col-md-4 px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12 px-0">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Введите название справочника
                    </p>
                    <input
                        v-model="title"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
                        required
                    />
                </div>
                <div class="col-12 p-0">
                    <p class="mb-1 mt-3 d-flex sdm-secondary-text">
                        Примечание
                    </p>
                    <input
                        v-model="description"
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
        name: "DictionaryTypesAdd",
        data: () => ({
            title: '',
            description: '',
            loading: false,
        }),
        methods:{
            sendNotify(notification, type='primary') {
                this.$notify({
                    title: 'Справочники',
                    text: notification,
                    type: type
                });
            },
            createDictionaryType() {
                if(this.title.trim() !== 'Роли'){
                    let new_dictionary_type = {
                        title: this.title,
                        description: this.description
                    };
                    //todo: TRY      method for creating new dictionary type
                    axios.post('/dictionary-type', new_dictionary_type)
                        .then(resp=> {

                            this.sendNotify('Тип словая успешно добавлен');
                            window.location.href = "/dictionary-types";
                            //     this.title = '';
                            //     this.description = '';
                            //     this.loading = false;
                        })
                        .catch((error) => {

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
                } else {
                    this.sendNotify('Данное название зарезервировано системой', 'error');
                }
            }
        }
    }
</script>

<style scoped>

</style>
