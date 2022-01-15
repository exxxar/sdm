<template>

    <div>


        <p class="mb-1 mt-2 d-flex sdm-secondary-text">
            Типы устройств
        </p>


        <multiselect
            placeholder="Выберите тип устройства"
            :taggable="true"
            @tag="addDeviceType"
            @remove="removeDeviceType"
            selectedLabel="Выбрано"
            tagPlaceholder="Создать тип устройства"
            selectLabel="Выберите тип устройства"
            deselectLabel="Enter для удаления типа устройства"
            v-model="currentDeviceType"
            :options="deviceTypeOptions">
        </multiselect>




    </div>

</template>
<script>


    export default {
        data() {
            return {
                deviceTypes: [],
                currentDeviceType: '',
                deviceTypeOptions: [],


            }

        },

        mounted() {
            this.uploadDeviceTypes ()
        },
        methods: {
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Типы устройств',
                    text: notification,
                    type: type
                });
            },
            removeDeviceType(deviceTypeTitle) {
                if (!this.deviceTypes)
                    return;
                let id = this.deviceTypes.filter(item => item.title === deviceTypeTitle)[0].id;

                axios
                    .delete(`/device-type/${id}`).then(() => {
                    this.sendNotify("Тип устройства успешно удален", "success")
                    this.uploadDeviceTypes();
                }).catch(()=>{
                    this.sendNotify("Ошибка удаления типа устройств", "error")
                })
            },

            addDeviceType(item) {
                axios
                    .post('/device-type', {
                        title: item,
                    }).then(() => {
                    this.sendNotify("Тип устройства успешно создан", "success")
                    this.uploadDeviceTypes()
                })
            },
            uploadDeviceTypes () {
                axios.get('/device-type').then(resp => {
                    this.currentDeviceType = ''
                    this.deviceTypeOptions = []

                    this.deviceTypes = resp.data.data

                    this.deviceTypes.forEach(item => {
                        this.deviceTypeOptions.push(item.title)
                    })


                })
            }
        }
    }
</script>

<style>

</style>
