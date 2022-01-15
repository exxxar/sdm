<template>
    <div class="p-2" style="width:250px" v-if="device !== null || device != undefined">
        <div class="row w-100 m-auto sdm-primary-text">
            {{ device.serial }}
        </div>
        <div class="row w-100 mx-auto my-1 align-items-center">
            <div class="sdm-primary-text" style="color: black">
                <span v-if="device.device_boundary != null">{{ device.device_boundary.title }}</span>
            </div>
            <button
                v-if="device.device_boundary != null"
                id="boundary"
                class="btn p-0"
                style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                @click="showBoundary"
            >
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px"
                     width="16px" height="15px" viewBox="0 0 612 612"
                     style="enable-background:new 0 0 612 612; overflow:unset;" xml:space="preserve">
                    <path fill="#7224f2" d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"/>
                </svg>
            </button>
        </div>
        <div class="row w-100 m-auto">
            <div class="col-12 p-0">
                <div class="sdm-secondary-text">
                    Нарушения за текущий день - <span style="color: green">{{ device.violations_day }}</span><br>
                    Нарушения за месяц - <span style="color: green" :id="'map-violations-'+device.id">-</span>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="sdm-secondary-text">
                    Проездов за текущий день - <span style="color: green">{{ device.passages_day }}</span><br>
                    Проездов за месяц - <span style="color: green" :id="'map-passages-'+device.id">-</span>
                </div>
            </div>
        </div>
        <!--        <div class="row w-100 m-auto">-->
        <!--            <div class="col-12 p-0">-->
        <!--                <div class="sdm-secondary-text">-->
        <!--                    Типы фиксируемых нарушений-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-12 p-0">-->
        <!--                <div class="sdm-secondary-text" style="color: black">-->
        <!--                    - превышение скорости-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-12 p-0">-->
        <!--                <div class="sdm-secondary-text" style="color: black">-->
        <!--                    - проезд на красный-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="row w-100 m-auto">
            <button id="device"
                    class="btn my-1 mr-1 py-1 sdm-primary-underline-button"
                    @click="showDevice"
            >
                <span>
                    К устройству
                </span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Balloon",
    props: ['device'],
    data: () => ({
        passages: null,
        violations: null,
        coords: [
            54.82896654088406,
            39.831893822753904,
        ],
    }),

    methods: {
        loadData() {
            axios.get("/map/historical/" + this.device.id).then(resp => {
                this.passages = resp.data.passages
                this.violations = resp.data.violations

                document.getElementById('map-violations-'+this.device.id).innerHTML = resp.data.violations;
                document.getElementById('map-passages-'+this.device.id).innerHTML = resp.data.passages;
            })
        },
        bindListener: function () {
            document.getElementById('device').addEventListener('click', this.showDevice);
            if (this.device.device_boundary != null) {
                document.getElementById('boundary').addEventListener('click', this.showBoundary);
            }
            this.loadData()
            console.log('bind')
        },
        unbindListener() {
            document.getElementById('device').removeEventListener('click', this.showDevice);
            if (this.device.device_boundary != null) {
                document.getElementById('boundary').removeEventListener('click', this.showBoundary);
            }
            console.log('unbind')
        },
        showDevice() {
            window.location.href = "/devices/" + this.device.id;
        },
        showBoundary() {
            window.location.href = "/boundaries/" + this.device.device_boundary.id;
        },
    },
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
</style>
