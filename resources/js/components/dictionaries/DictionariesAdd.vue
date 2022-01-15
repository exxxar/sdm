<template>
    <div class="row w-100 m-auto  align-items-center justify-content-start">
        <div class="col-md-4 px-0">
            <div class="row w-100 m-auto align-items-center justify-content-center">
                <div class="col-12 px-0">
                    <p class="mb-1 mt-2 d-flex sdm-secondary-text">
                        Название пункта
                    </p>
                    <input
                        v-model="title"
                        class="form-control"
                        placeholder=""
                        style="background: transparent;color: black; font-weight: 500; font-size: 12px;border-color: #dfe1ee"
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
                    />
                </div>
                <div class="col-12 px-0">
                    <button
                        v-on:click="createDictionary"
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
        name: "DictionariesAdd",
        props: ['dictionary_type_id'],

        data: () => ({
            title: '',
            description: '',
            //v-select

            loading: false,
        }),
        mounted() {
            console.log(this.dictionary_type_id)
        },

        methods: {
            createDictionary() {
                this.loading = true;

                axios.post('/dictionary', {
                    title: this.title,
                    description: this.description,
                    dictionary_type_id: this.dictionary_type_id
                })
                    .then((resp) => {
                        this.sendNotify('Словарь успешно создан!', 'success');
                        window.location.href = "/dictionary-types"

                    })

                    .catch(() => {

                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                        this.loading = false;


                    });
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

</style>
