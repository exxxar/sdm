<template>

    <div>


        <p class="mb-1 mt-2 d-flex sdm-secondary-text">
           Район
        </p>


        <multiselect
            placeholder="Выберите район"
            :taggable="true"
            @tag="addRegion"
            @remove="removeRegion"
            selectedLabel="Выбрано"
            tagPlaceholder="Создать район"
            selectLabel="Выберите район"
            deselectLabel="Enter для удаления района"
            v-model="currentRegion"
            :options="regionOptions">
        </multiselect>




    </div>

</template>
<script>


    export default {
        data() {
            return {
                regions: [],
                currentRegion: '',
                regionOptions: [],


            }

        },

        mounted() {
            this.uploadRegions ()
        },
        methods: {
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Регионы',
                    text: notification,
                    type: type
                });
            },
            removeRegion(regionTitle) {
                if (!this.regions)
                    return;
                let id = this.regions.filter(item => item.title === regionTitle)[0].id;

                axios
                    .delete(`/region/${id}`).then(() => {
                    this.sendNotify("Регион успешно удален", "success")
                    this.uploadRegions();
                }).catch(()=>{
                    this.sendNotify("Ошибка удаления региона", "error")
                })
            },

            addRegion(item) {
                axios
                    .post('/region', {
                        title: item,
                    }).then(() => {
                    this.sendNotify("Регион успешно создан", "success")
                    this.uploadRegions()
                })
            },
            uploadRegions() {
                axios.get('/region').then(resp => {
                    this.currentRegion = ''
                    this.regionOptions = []

                    this.regions = resp.data.data

                    this.regions.forEach(item => {
                        this.regionOptions.push(item.title)
                    })


                })
            }
        }
    }
</script>

<style>

</style>
