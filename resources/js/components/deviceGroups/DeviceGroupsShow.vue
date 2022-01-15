<template>
    <div>
        <div
            class="row mx-auto mt-2 align-items-center"
            v-if="selected.length > 0"
            style="padding: 15px; border-top: 1px solid #dfe1ee; border-left: 1px solid #dfe1ee; border-right: 1px solid #dfe1ee; border-radius: 5px"
        >
            <div class="col-8">
                <div class="row w-100 mx-auto align-items-center">
                    <div
                        style="display: flex"
                        class="mr-2 mt-1"
                        :key="boundary.id"
                        v-for="boundary in selected"
                    >
                        <div class="mr-1">{{ boundary.serial }}</div>
                        <div
                            v-on:click="uncheck(boundary)"
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
                                <g>
                                    <g>
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </g>
                                </g>
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
                        >Выбрать все</span
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
            class="row w-100 mx-auto mt-2 align-items-center justify-content-center"
        >
            <div
                @click="sort('serial')"
                style="cursor: pointer;"
                class="custom-filter col-4 pl-0"
            >
                Серийный номер<i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'serial'"
                    class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div
                @click="sort('device_type_id')"
                style="cursor: pointer; padding-left: 30px"
                class="custom-filter col-2"
            >
                Тип<i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'device_type_id'"
                    class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div
                style="cursor: pointer; padding-left: 0;"
                @click="sort('device_boundary_id')"
                class="custom-filter col-2"
            >
                Рубеж<i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'device_boundary_id'"
                    class="fas fa-angle-down filter-icon"
                ></i>
            </div>
            <div
                style="padding-left: 34px; cursor: pointer;"
                @click="sort('is_active')"
                class="custom-filter col-4"
            >
                Статус<i
                    v-bind:class="{
                        'sort-icon-rotation': currentSortDir == 'asc'
                    }"
                    v-if="currentSort == 'is_active'"
                    class="fas fa-angle-down filter-icon"
                ></i>
            </div>
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
                    <div class="col-md-4">
                        <div
                            class="row w-100 my-1 align-items-center justify-content-start"
                        >
                            <div
                                class="form-check form-check-inline custom-menu-checkbox"
                                style="padding-left: 50px"
                            >
                                <input
                                    :id="'checkbox-' + index + 2"
                                    :name="'checkbox-' + index + 2"
                                    class="checkbox-custom"
                                    @change="check(item, item.selected)"
                                    type="checkbox"
                                    v-model="item.selected"
                                />
                                <label
                                    :id="'checkbox-' + index + 2"
                                    :for="'checkbox-' + index + 2"
                                    style="font-size:14px;"
                                    class="checkbox-custom-label"
                                ></label>
                                <div
                                    v-on:click="editDevice(item.id)"
                                    class="serial-number"
                                >
                                    {{ item.serial }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-12 col-sm-6 col-md-2"
                        style="display: flex; align-items: center"
                    >
                        <div
                            v-if="item.mobile == false"
                            class="icon-grey-border"
                        >
                            <svg
                                class="custom-icon"
                                version="1.1"
                                id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 512 512"
                                xml:space="preserve"
                            >
                                <g>
                                    <g>
                                        <path
                                            fill="black"
                                            d="M256,0C156.011,0,74.667,81.344,74.667,181.333c0,96.725,165.781,317.099,172.843,326.443
                                                c1.984,2.667,5.163,4.224,8.491,4.224c3.328,0,6.507-1.557,8.491-4.224c7.061-9.344,172.843-229.717,172.843-326.443
                                                C437.333,81.344,355.989,0,256,0z M256,277.333c-52.928,0-96-43.072-96-96c0-52.928,43.072-96,96-96s96,43.072,96,96
                                                C352,234.261,308.928,277.333,256,277.333z"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div
                            v-if="item.mobile == true && item.movable == false"
                            class="icon-grey-border"
                        >
                            <svg
                                version="1.0"
                                xmlns="http://www.w3.org/2000/svg"
                                width="12px"
                                height="12px"
                                viewBox="0 0 1627.000000 1571.000000"
                                preserveAspectRatio="xMidYMid meet"
                            >
                                <g
                                    transform="translate(0.000000,1571.000000) scale(0.100000,-0.100000)"
                                    fill="#000000"
                                    stroke="none"
                                >
                                    <path
                                        d="M13570 14765 l-1915 -945 -3 -2058 -2 -2059 1921 -946 1920 -947 390
                                    0 389 0 0 3950 0 3950 -392 0 -393 -1 -1915 -944z"
                                    />
                                    <path
                                        d="M0 11760 l0 -3470 2390 0 2390 0 0 -1350 0 -1350 -1157 0 -1158 0
                                    -907 -2557 c-499 -1407 -905 -2559 -904 -2560 4 -5 1154 -412 1171 -415 14 -2
                                    158 395 774 2132 l758 2135 711 3 712 2 0 -2165 0 -2165 630 0 630 0 0 2165 0
                                    2165 714 0 714 0 10 -28 c5 -15 346 -974 757 -2132 410 -1158 750 -2108 753
                                    -2111 11 -11 1177 407 1179 422 2 8 -404 1159 -901 2559 l-903 2545 -1161 3
                                    -1162 2 0 1350 0 1350 2185 0 2185 0 0 3470 0 3470 -5205 0 -5205 0 0 -3470z
                                    m5410 550 l0 -620 -1660 0 -1660 0 0 620 0 620 1660 0 1660 0 0 -620z"
                                    />
                                </g>
                            </svg>
                        </div>
                        <div
                            v-if="item.mobile == true && item.movable == true"
                            class="icon-grey-border"
                        >
                            <svg
                                class="custom-icon"
                                viewBox="0 0 16 16"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m14.794 5.1662-1.12213-3.74042c-.255859-.853027-1.02588-1.42578-1.91602-1.42578h-7.51172c-.890137 0-1.66016.572754-1.91602 1.42578l-1.12213 3.74042c-.708557.307922-1.20599 1.01306-1.20599 1.8338v4c0 .552246.447754 1 1 1h.000061l-.000061.999939c0 .552307.447693 1.00006 1 1.00006h1.00006c.552246 0 1-.447754 1-1l-.0004272-1h8.00037l-.000061.999939c0 .552307.447693 1.00006 1 1.00006h1.00006c.552307 0 1-.447754 1-1v-.999939l-.0003662-.000061h.0003662c.552246 0 1-.447754 1-1v-4c0-.82074-.497436-1.52588-1.20599-1.8338zm-10.5499-3.1662h7.51172l.900024 3h-9.31177l.900024-3zm-.244141 7.5c-.552307 0-1-.447754-1-1 0-.552307.447693-1 1-1s1 .447693 1 1c0 .552246-.447693 1-1 1zm8 0c-.552307 0-1-.447754-1-1 0-.552307.447693-1 1-1s1 .447693 1 1c0 .552246-.447693 1-1 1z"
                                    transform="translate(0 1)"
                                />
                            </svg>
                        </div>
                        <div
                            class="d-flex table-text"
                            style="font-size: 12px;font-weight: 500"
                        >
                            {{ item.type.title }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div
                            v-if="item.boundary"
                            class="d-flex table-text"
                            style="font-size: 12px;font-weight: 500"
                        >
                            <div
                                style="
                                display: flex;
                                align-items: center;
                            "
                            >
                            <a
                                class="additional-link"
                                :href="`/boundaries/edit/${item.boundary.id}`"
                            >
                                {{ item.boundary.title
                                }}<i
                                    style="padding:3px 3px 3px 4px; border: 1px solid #7c34f2; border-radius: 50px;width: 17px;height: 17px;"
                                    class="fas fa-arrow-right filter-icon fa-xs"
                                ></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <button
                        v-if="item.device_type_id == 1 || item.deleted_at"
                        class="btn mr-2"
                        style="visibility:hidden; display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent; color: black"
                    ></button>
                    <button
                        v-if="item.device_type_id != 1 && !item.deleted_at"
                        class="btn mr-2"
                        style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent; color: black"
                    >
                        <svg
                            version="1.1"
                            id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0px"
                            y="0px"
                            viewBox="0 0 488.85 488.85"
                            style="fill: black; width: 18px; height:18px; min-width: 18px; min-height:18px"
                            xml:space="preserve"
                        >
                            <g>
                                <path
                                    d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2
                                    s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025
                                    c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3
                                    C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7
                                    c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"
                                />
                            </g>
                        </svg>
                    </button>
                    <div class="col-12 col-sm-12 col-md-4">
                        <div
                            style="flex-wrap: nowrap; justify-content: space-between"
                            class="row w-100 mx-auto my-1 align-items-center"
                        >
                            <div
                                style="width: 100px;
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;"
                            >
                                <p class="switch-label">ВЫКЛ</p>
                                <label class="switch">
                                    <input
                                        type="checkbox"
                                        v-model="item.is_active"
                                        v-on:change="
                                            checkDevice(
                                                $event.target.checked,
                                                item.id
                                            )
                                        "
                                    />
                                    <span class="slider round"></span>
                                </label>
                                <p class="switch-label">ВКЛ</p>
                            </div>

                            <div style="display: flex" class="mr-2">
                                <button
                                    class="btn mr-2"
                                    v-on:click="editDevice(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: #6633ff; color: #FFFFFF"
                                >
                                    <svg
                                        version="1.1"
                                        id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 492 492"
                                        style="transform: rotate(180deg); fill: white; width: 10px; height:10px; min-width: 10px; min-height:10px"
                                        xml:space="preserve"
                                    >
                                        <g>
                                            <g>
                                                <path
                                                    d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12
                                                C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084
                                                c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864
                                                l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"
                                                />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <div
                                    style="display: flex;
                                            align-items: center;
                                            width: 116px;
                                            justify-content: center;"
                                    v-if="item.deleted_at"
                                >
                                    <p
                                        style="font-size: 14px; color: red; margin-bottom: 0"
                                    >
                                        Удалено
                                    </p>
                                </div>
                                <button
                                    v-if="!item.deleted_at"
                                    class="btn mr-2"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent; color: black"
                                    v-on:click="refreshDevice(item)"
                                >
                                    <svg
                                        version="1.1"
                                        id="Capa_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 492.883 492.883"
                                        style="fill: black; width: 12px; height:12px; min-width: 12px; min-height:12px"
                                        xml:space="preserve"
                                    >
                                        <g>
                                            <g>
                                                <path
                                                    d="M122.941,374.241c-20.1-18.1-34.6-39.8-44.1-63.1c-25.2-61.8-13.4-135.3,35.8-186l45.4,45.4c2.5,2.5,7,0.7,7.6-3
                                                l24.8-162.3c0.4-2.7-1.9-5-4.6-4.6l-162.4,24.8c-3.7,0.6-5.5,5.1-3,7.6l45.5,45.5c-75.1,76.8-87.9,192-38.6,282
                                                c14.8,27.1,35.3,51.9,61.4,72.7c44.4,35.3,99,52.2,153.2,51.1l10.2-66.7C207.441,421.641,159.441,407.241,122.941,374.241z"
                                                />
                                                <path
                                                    d="M424.941,414.341c75.1-76.8,87.9-192,38.6-282c-14.8-27.1-35.3-51.9-61.4-72.7c-44.4-35.3-99-52.2-153.2-51.1l-10.2,66.7
                                                c46.6-4,94.7,10.4,131.2,43.4c20.1,18.1,34.6,39.8,44.1,63.1c25.2,61.8,13.4,135.3-35.8,186l-45.4-45.4c-2.5-2.5-7-0.7-7.6,3
                                                l-24.8,162.3c-0.4,2.7,1.9,5,4.6,4.6l162.4-24.8c3.7-0.6,5.4-5.1,3-7.6L424.941,414.341z"
                                                />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <button
                                    v-if="!item.deleted_at"
                                    class="btn"
                                    v-on:click="editDevice(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; border: 1px solid #dfe1ee; font-size: 15px; width: 36px; min-width: 36px; background: transparent;"
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
                                    v-if="!item.deleted_at"
                                    class="btn"
                                    v-on:click="deleteDevice(item.id)"
                                    style="display: flex; align-items: center; justify-content: center; height:36px; width: 36px; min-width: 36px; background: transparent;"
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
                                        <g>
                                            <g>
                                                <path
                                                    fill="red"
                                                    d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                            L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                            c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                            c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                                />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Appeals",
    props: [
        "format_table",
        "serial",
        "boundary",
        "typeId",
        "deleted",
        "deviceClass",
        "device_group"
    ],
    data: () => ({
        // sort
        currentSort: "serial",
        currentSortDir: "asc",
        // checkbox
        actual: true,
        inWork: true,
        ready: true,
        //checkbox
        data: [],
        selected: []
    }),
    created() {
        this.getData();
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
            return this.data.filter(item => {
                const serial = item.serial
                    .toLowerCase()
                    .includes(this.serial.toLowerCase());
                let boundary = true,
                    type = true,
                    deleted = true,
                    deviceClass = true;

                if (this.deviceClass !== "") {
                    if (this.deviceClass === 0) {
                        deviceClass = item.mobile == false;
                    }

                    if (this.deviceClass === 1) {
                        deviceClass =
                            item.mobile == true && item.movable == false;
                    }

                    if (this.deviceClass === 2) {
                        deviceClass =
                            item.mobile == true && item.movable == true;
                    }
                }

                if (this.boundary !== "") {
                    if (item.boundary) {
                        boundary = item.boundary.title
                            .toLowerCase()
                            .includes(this.boundary.toLowerCase());
                    } else {
                        boundary = false;
                    }
                }

                if (this.typeId !== "") {
                    if (item.device_type_id) {
                        type = item.device_type_id === this.typeId;
                    } else {
                        type = false;
                    }
                }
                console.log(item)
                if (!this.deleted) {
                    if (item.deleted_at) {
                        deleted = false;
                    }
                }

                return serial && boundary && type && deleted && deviceClass;
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
        sort: function(s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir =
                    this.currentSortDir === "asc" ? "desc" : "asc";
            }
            this.currentSort = s;
        },
        turnOffAll: function() {
            this.filteredList.forEach(device => {
                device.is_active = false;
            });
            axios
                .post(`/device/toggle-all`, {
                    is_active: false
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        turnOnAll: function() {
            this.filteredList.forEach(device => {
                device.is_active = true;
            });
            axios
                .post(`/device/toggle-all`, {
                    is_active: true
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        uncheck: function(device) {
            const index = this.selected
                .map(select => select.id)
                .indexOf(device.id);
            if (index !== -1) {
                this.selected.splice(index, 1);
            }
            const indexData = this.data
                .map(select => select.id)
                .indexOf(device.id);
            if (indexData !== -1) {
                this.data[indexData].selected = false;
            }
        },
        checkAll: function() {
            this.filteredList.forEach(device => {
                device.selected = true;
            });
            this.selected = this.filteredList;
        },
        uncheckAll: function() {
            this.selected.forEach(device => {
                const indexData = this.data
                    .map(select => select.id)
                    .indexOf(device.id);
                if (indexData !== -1) {
                    this.data[indexData].selected = false;
                }
            });
            this.selected = [];
        },
        check: function(item, selected) {
            if (selected) {
                this.selected.push(item);
            } else {
                const index = this.selected
                    .map(select => select.id)
                    .indexOf(item.id);
                if (index !== -1) {
                    this.selected.splice(index, 1);
                }
            }
            //const index = this.data.map(item => item.id).indexOf(id);
            //this.data[index].selected = selected;
        },
        isSelected: function(id) {
            const index = this.selected.map(item => item.id).indexOf(id);
            return index !== -1;
        },
        checkDevice: function(checked, id) {
            axios
                .post(`/device/toggle/${id}`, {
                    is_active: checked
                })
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        getData() {
            axios
                .get(`/device-group/${this.device_group.id}`)
                .then(resp => {
                    this.data = resp.data.data.devices.data;
                    this.data.forEach(item => {
                        item.selected = false;
                    });
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        editDevice(id) {
            window.location.href = `/devices/edit/${id}`;
        },
        deleteDevice(id) {
            const removeIndex = this.data.map(item => item.id).indexOf(id);
            this.data.splice(removeIndex, 1);
            axios
                .delete(`/device/${id}`)
                .then(resp => {
                    console.log(resp);
                    //this.data = resp.data.data;
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        refreshDevice(device) {
            const index = this.data.map(item => item.id).indexOf(device.id);
            axios
                .post(`/devices/info/${device.id}`, {
                    ip: device.ip,
                    password: device.password,
                    login: device.login,
                    device_type: device.device_type_id,
                    port: device.port
                })
                .then(resp => {
                    console.log(resp);
                    const status = resp.data.status;

                    if (status === "active") {
                        this.data[index].is_active = true;
                        this.checkDevice(true, device.id);
                        console.log("active");
                    }

                    if (status === "not active") {
                        this.data[index].is_active = false;
                        this.checkDevice(false, device.id);
                        console.log("not active");
                    }
                })
                .catch(function(resp) {
                    this.data[index].is_active = false;
                    this.checkDevice(false, device.id);
                    console.log(resp);
                });
        }
    }
};
</script>

<style scoped>
.serial-number {
    cursor: pointer;
    font-size: 14px;
    word-break: break-all;
    min-width: 70px;
}

.serial-number:hover {
    color: #7c34f2 !important;
}

.eye-visibility {
    visibility: hidden !important;
}

.sort-icon-rotation {
    transform: rotate(180deg);
}

.icon-grey-border {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: solid 1px #dfe1ee;
    border-radius: 50px;
    min-width: 28px;
    margin-right: 8px;
}

.custom-icon {
    width: 12px;
    height: 12px;
}

.custom-filter {
    color: #9d9ea5;
    font-size: 12px;
}

.filter-icon {
    color: #7c34f2;
    margin-left: 5px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 20px;
    margin-bottom: 0;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border: 1px solid #9d9ea5;
}

.slider:before {
    position: absolute;
    content: "";
    height: 11px;
    width: 11px;
    left: 4px;
    bottom: 4px;
    background-color: #9d9ea5;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: white;
}

/*input:focus + .slider {*/
/*    box-shadow: 0 0 1px #2196F3;*/
/*}*/

input:checked + .slider:before {
    -webkit-transform: translateX(10px);
    -ms-transform: translateX(10px);
    transform: translateX(10px);
    background-color: green;
}

input:checked + .slider {
    border: 1px solid green;
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.switch-label {
    margin-bottom: 0;
    font-size: 10px;
}
</style>
