<template>
    <div>
        <modal :id="'edit'" footer="true">
            <template v-slot:main>
                <div class="row w-100 mx-auto my-2 py-2 align-items-center justify-content-center">
                    <div class="col-6">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Широта
                        </p>
                        <input
                            v-mask="'##.####'"
                            v-model="edited_coord.lat"
                            class="form-control custom-input"
                        />
                    </div>
                    <div class="col-6">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Долгота
                        </p>
                        <input
                            v-mask="'##.####'"
                            v-model="edited_coord.lon"
                            class="form-control custom-input"
                        />
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button
                    @click="saveCoords"
                    type="button"
                    class="btn my-1 py-2 sdm-primary-button"
                    :disabled="!edited_coord.lat || !edited_coord.lon"
                >
                    Сохранить
                </button>
            </template>
        </modal>

        <div
            class="row w-100 mx-auto my-2 py-2 align-items-center justify-content-center"
            v-for="(coord, index) in coords"
            style="border: 1px solid #dfe0f0; border-radius: 5px;"
            v-if="coords.length>0"
        >
            <div class="col-2">
                <p class="mb-1 d-flex sdm-secondary-text">
                    Дата создания
                </p>
                <div class="sdm-ptimary-text">
                    {{coord.created_at | moment('DD.MM.YYYY')}}
                </div>
            </div>
            <div class="col-4">
                <p class="mb-1 d-flex sdm-secondary-text">
                    Широта
                </p>
                <div class="sdm-ptimary-text">
                    {{coord.lat}}
                </div>
            </div>
            <div class="col-4">
                <p class="mb-1 d-flex sdm-secondary-text">
                    Долгота
                </p>
                <div class="sdm-ptimary-text">
                    {{coord.lon}}
                </div>
            </div>
            <div class="col-2">
                <p class="mb-1 d-flex sdm-secondary-text justify-content-center" v-if="edit">
                    Действия
                </p>
                <div class="row w-100 mx-auto align-items-center justify-content-center" v-if="edit">
                    <button
                        class="btn mx-1 d-flex align-items-center justify-content-center sdm-icon-button"
                        @click="editCoord(coord)"
                        data-bs-toggle="modal" data-bs-target="#edit"
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
                        v-if="!coord.deleted_at"
                        class="btn mx-1 d-flex align-items-center justify-content-center sdm-icon-button"
                        v-on:click="askForDelete(coord)"
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
                                style="fill: #d62627 !important;"
                                d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="!coords || coords.length<=0"
             class="row w-100 mx-auto my-2 py-2 align-items-center justify-content-center text-center">
            <h3 class="m-auto sdm-primary-text">Список координат устройства пуст</h3>
        </div>


        <modal id="accept-remove-coords">
            <template v-slot:header>
                Единичное удаление
            </template>
            <template v-slot:main>

                <h4 class="w-100 text-center" v-if="removedItem">Вы хотите удалить ?</h4>

                <div class="row d-flex justify-content-center">
                    <div class="col-4">
                        <button class="btn w-100 btn-dark my-1 mr-1 py-2"
                                @click="deleteCoord( removedItem.id, true)"
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
    import Modal from "../Modal";

    export default {
        name: "DevicesCoordsHistory",
        components: {Modal},
        props: [
            'device',
            "edit"
        ],
        data() {
            return {
                removedItem: null,
                edited_coord: {
                    id: '',
                    lat: null,
                    lon: null,
                    device_id: null,
                },
                coords: [],
                loading: false,
            }
        },
        mounted() {

            this.coords = this.device.device_coords_history;

        },
        methods: {
            askForDelete(item) {
                this.removedItem = item

                $('#accept-remove-coords').modal('show')
            },

            addCoords() {
                //todo: TRY     method for creating new coords for device
                this.loading = true;
                let new_coords = {
                    device_id: this.device.id,
                    lat: this.lat,
                    lon: this.lon
                };
                axios.post('/device-coords-history', new_coords)
                    .then(function () {
                        this.coords.push(new_coords);
                        this.loading = false;
                        this.sendNotify('Вы успешно удалили координату', 'success');
                        // window.location.href = "/dictionary-types";
                    })
                    .catch((error) => {
                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }
                        this.loading = false;
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });
            },
            deleteCoord(id) {
                //todo: TRY     method for deleting coords from device
                const removeIndex = this.coords.map(item => item.id).indexOf(id);
                this.coords.splice(removeIndex, 1);
                axios
                    .delete(`/device-coords-history/${id}`)
                    .then(resp => {
                        console.log(resp);
                        this.sendNotify('Вы успешно удалили координату устройства', 'success');
                        window.location.href = `/devices/edit/${this.device.id}`
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });
            },
            editCoord(coord) {
                // this.edited_lat=coord.lat;
                // this.edited_lon=coord.lon;
                this.edited_coord.id = coord.id;
                this.edited_coord.lat = coord.lat;
                this.edited_coord.lon = coord.lon;
                this.edited_coord.device_id = this.device.id
            },
            saveCoords() {
                //todo: TRY     method for editing coords from device
                this.loading = true;
                $('#accept-remove-coords').modal('hide')
                axios
                    .patch(`/device-coords-history/${this.edited_coord.id}`, this.edited_coord)
                    .then(() => {
                        // window.location.href = "/dictionary-types";
                        this.edited_coord = {
                            id: '',
                            lat: '',
                            lon: '',
                            device_id: null
                        };
                        this.sendNotify('Вы успешно отредактировали координату устройства', 'success');
                        this.loading = false;

                        window.location.href = `/devices/edit/${this.device.id}`
                    })
                    .catch(error => {
                        const errors = error.response.data.errors;

                        for (const [key, value] of Object.entries(this.errors)) {
                            if (errors.hasOwnProperty(key)) {
                                this.errors[key] = errors[key][0];
                                console.log(this.errors);
                            }
                        }
                        this.loading = false;
                        this.sendNotify('Произошла ошибка, повторите попытку позже', 'error');
                    });
            },
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'История координат устройств',
                    text: notification,
                    type: type
                });
            }
        }
    }
</script>

<style scoped>

</style>
