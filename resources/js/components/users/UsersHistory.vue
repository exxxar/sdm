<template>
    <div>
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li style="margin-left: 20px" class="nav-item">
                <a
                    class="nav-link active"
                    id="history-tab"
                    data-toggle="tab"
                    href="#history"
                    role="tab"
                    aria-controls="history"
                    aria-selected="true"
                >
                    История пользователя
                </a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="history"
                role="tabpanel"
                aria-labelledby="history-tab"
            >
                <div class="row w-100 m-auto align-items-center justify-content-center">
                    <div class="col-4 pr-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Период операций
                        </p>
                        <daterange-picker
                            ref="picker"
                            :opens="'right'"
                            :locale-data="local_data"
                            :timePicker="true"
                            :timePickerIncrement="1"
                            :timePicker24Hour="true"
                            :timePickerSeconds="true"
                            :showWeekNumbers="false"
                            :showDropdowns="true"
                            :ranges="false"
                            v-model="dateRange"
                            :linkedCalendars="true"
                            class="w-100"
                        >
                            <div slot="header" slot-scope="header" class="slot">
                                <div class="row w-100 m-auto">
                                    <div class="col-12">
                                        <div
                                            class="row m-auto w-100 justify-content-end"
                                        >
                                            <button
                                                @click="header.clickCancel"
                                                class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                            >
                                            <span
                                                style="font-size: 10px; border-bottom: 2px solid #d93030"
                                            >
                                                Сбросить
                                            </span>
                                            </button>
                                            <button
                                                @click="header.clickApply"
                                                class="btn my-1 mr-1 py-1 border-copy-button float-right"
                                            >
                                            <span
                                                style="font-size: 10px; border-bottom: 2px solid #7224f2"
                                            >
                                                Подтвердить
                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12"
                                        style="border-top: 1px solid #ced4da"
                                    >
                                        <div class="sdm-primary-text py-3 px-2">
                                            Выбранный период:
                                            <span style="color:#7224f2">{{rangeText(header.rangeText)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-slot:input="picker" style="min-width: 350px;">
                                <div class="row w-100 h-100 m-auto align-items-center justify-content-center">
                                    <div class="col-10 p-0 text-truncate sdm-primary-text" style="font-size: 12px"
                                    >
                                        <span style="color: #7224f2">{{picker.startDate | moment("DD.MM.YYYY")}}</span>
                                        {{picker.startDate | moment("HH:mm:ss")}} -
                                        <span style="color: #7224f2">{{picker.endDate | moment("DD.MM.YYYY")}}</span>
                                        {{picker.endDate | moment("HH:mm:ss")}}
                                    </div>
                                    <div class="col-2 pr-0">
                                        <svg
                                            class="float-right"
                                            height="15px"
                                            viewBox="0 0 512 512"
                                            width="15px"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill="#7224f2"
                                                d="m448 64h-21.332031v-42.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031h-21.332031c-11.777344 0-21.332031 9.558594-21.332031 21.332031v42.667969h-213.335938v-42.667969c0-11.773437-9.554687-21.332031-21.332031-21.332031h-21.332031c-11.777344 0-21.335938 9.558594-21.335938 21.332031v42.667969h-21.332031c-35.285156 0-64 28.714844-64 64v320c0 35.285156 28.714844 64 64 64h384c35.285156 0 64-28.714844 64-64v-320c0-35.285156-28.714844-64-64-64zm21.332031 384c0 11.753906-9.578125 21.332031-21.332031 21.332031h-384c-11.753906 0-21.332031-9.578125-21.332031-21.332031v-233.8125h426.664062zm0 0"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </template>
                            <div
                                slot="footer"
                                slot-scope="data"
                                class="slot"
                            ></div>
                        </daterange-picker>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип операции
                        </p>
                        <select class="form-select custom-select" v-model="operation_type">
                            <option value="" selected>
                                Все
                            </option>
                            <option value="Редактирование">
                               Редактирование
                            </option>
                            <option value="Создание">
                                Создание
                            </option>
                            <option value="Удаление">
                                Удаление
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Тип объекта
                        </p>
                        <select class="form-select custom-select" v-model="object_type">
                            <option value="" selected>
                                Устройство
                            </option>
                        </select>
                    </div>
                    <div class="col-2 px-1">
                        <p
                            class="mb-1 d-flex"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Объект
                        </p>
                        <select
                            class="form-select custom-select"
                            v-model="object"
                        >
                            <option value="" selected disabled>
                                Выберите устройство
                            </option>
                        </select>
                    </div>
                    <div class="col-2 pl-1 h-100">
                        <div
                            class="row h-100 w-100 mx-auto mt-3 align-items-end justify-content-end"
                        >
                            <button
                                class="btn mb-0 mt-auto float-right"
                                style="background:#dfe0f0; color:#7224f2; font-size: 12px"
                                @click="resetFilters"
                            >
                                Сбросить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row w-100 m-auto">
                    <div class="col-12">
                        <div style="padding-bottom: 10px" class="row w-100 mx-auto mt-3 align-items-center justify-content-center">
                            <div class="custom-filter col-2 pl-0" style="cursor: pointer;" @click="sort('created_at')">
                                Дата и время
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'created_at'"
                                   class="fas fa-angle-down filter-icon"
                                >
                                </i>
                            </div>
                            <div class="custom-filter col-2" style="cursor: pointer;" @click="sort('action')">
                                Тип операции
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'action'"
                                   class="fas fa-angle-down filter-icon"
                                >
                                </i>
                            </div>
                            <div class="custom-filter col-3" style="cursor: pointer;" @click="sort('object_type')">
                                Тип объекта
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'object_type'"
                                   class="fas fa-angle-down filter-icon"
                                >
                                </i>
                            </div>
                            <div class="custom-filter col-5" style="cursor: pointer;" @click="sort('object')">
                                Объект
                                <i v-bind:class="{'sort-icon-rotation': currentSortDir == 'asc'}"
                                   v-if="currentSort == 'object'"
                                   class="fas fa-angle-down filter-icon"
                                >
                                </i>
                            </div>
                        </div>
                        <div v-if="!loading" class="row w-100 mx-auto align-items-center justify-content-center sdm-primary-text">
                            <div
                                class="col-12 p-0"
                                :key="index"
                                v-for="(item, index) in sortedList"
                            >
                                <div
                                    class="row w-100 mx-auto mb-1 py-1 px-3 px-sm-0 align-items-center justify-content-center"
                                    style="background: #FFFFFF; border-radius: 5px; max-width: 1420px; "
                                >
                                    <div class="col-12 col-md-2">
                                        <span style="color:#7224f2">{{item.created_at | moment("DD.MM.YYYY")}}</span>
                                        {{item.created_at | moment("HH:mm:ss")}}
                                    </div>
                                    <div class="col-12 col-md-2">
                                        {{item.action}}
                                    </div>
                                    <div class="col-12 col-md-3">
                                        {{item.object.typeTitle}}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="row w-100 mx-auto my-1 align-items-center">
                                            <div>
                                                <span v-if="item.type == 1">{{item.object.serial}}</span>
                                                <span v-if="item.type == 2">{{item.object.title}}</span>
                                                <span v-if="item.type == 3">Обращение №{{item.object.id}}</span>
                                            </div>
                                            <popover
                                                class="sdm-popover"
                                                :name="'' + item.id"
                                            >
                                                <perfect-scrollbar>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 1 && item.object.device_boundary != null && item.object.device_boundary != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text">
                                                            Рубеж
                                                        </p>
                                                        <a :href="'/boundaries/'+item.object.device_boundary.id" class="sdm-primary-text" style="color:black;text-decoration: none;">
                                                            {{item.object.device_boundary.title}}
                                                            <svg
                                                                version="1.1"
                                                                id="Capa_1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px"
                                                                y="0px"
                                                                width="16px"
                                                                height="15px"
                                                                viewBox="0 0 612 612"
                                                                style="enable-background:new 0 0 612 612; overflow:unset;"
                                                                xml:space="preserve"
                                                            >
                                                                <path
                                                                    fill="#7224f2"
                                                                    d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 1 && item.object.group != null && item.object.group != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text">
                                                            Группа устройств
                                                        </p>
                                                        <a :href="'/device-groups/'+item.object.group.id" class="sdm-primary-text" style="color:black;text-decoration: none;">
                                                            {{item.object.group.title}}
                                                            <svg
                                                                version="1.1"
                                                                id="Capa_1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px"
                                                                y="0px"
                                                                width="16px"
                                                                height="15px"
                                                                viewBox="0 0 612 612"
                                                                style="enable-background:new 0 0 612 612; overflow:unset;"
                                                                xml:space="preserve"
                                                            >
                                                        <path
                                                            fill="#7224f2"
                                                            d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                            H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                            c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                            C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                            S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                            c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                        />
                                                    </svg>
                                                        </a>
                                                    </div>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 1 && item.object.device_type != null && item.object.device_type != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text">
                                                            Тип устройства
                                                        </p>
                                                        <div class="sdm-primary-text">
                                                            {{item.object.device_type.title}}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 2 && item.object.group != null && item.object.group != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text" >
                                                            Группа рубежей
                                                        </p>
                                                        <a :href="'/boundary-groups/'+item.object.group.id" class="sdm-primary-text" style="color:black;text-decoration: none;">
                                                            {{item.object.group.title}}
                                                            <svg
                                                                version="1.1"
                                                                id="Capa_1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px"
                                                                y="0px"
                                                                width="16px"
                                                                height="15px"
                                                                viewBox="0 0 612 612"
                                                                style="enable-background:new 0 0 612 612; overflow:unset;"
                                                                xml:space="preserve"
                                                            >
                                                        <path
                                                            fill="#7224f2"
                                                            d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                            H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                            c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                            C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                            S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                            c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                        />
                                                    </svg>
                                                        </a>
                                                    </div>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 3 && item.object.boundary != null && item.object.boundary != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text">
                                                            Рубеж
                                                        </p>
                                                        <a :href="'/boundaries/'+item.object.boundary.id" class="sdm-primary-text" style="color:black;text-decoration: none;">
                                                            {{item.object.boundary.title}}
                                                            <svg
                                                                version="1.1"
                                                                id="Capa_1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px"
                                                                y="0px"
                                                                width="16px"
                                                                height="15px"
                                                                viewBox="0 0 612 612"
                                                                style="enable-background:new 0 0 612 612; overflow:unset;"
                                                                xml:space="preserve"
                                                            >
                                                        <path
                                                            fill="#7224f2"
                                                            d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                            H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                            c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                            C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                            S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                            c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                        />
                                                    </svg>
                                                        </a>
                                                    </div>
                                                    <div class="mb-1 text-truncate" style="max-width: 135px" v-if="item.type === 3 && item.object.device != null && item.object.device != undefined">
                                                        <p class="mb-1 d-flex sdm-secondary-text">
                                                            Устройство
                                                        </p>
                                                        <a :href="'/devices/'+item.object.device.id" class="sdm-primary-text" style="color:black;text-decoration: none;">
                                                            {{item.object.device.serial}}
                                                            <svg
                                                                version="1.1"
                                                                id="Capa_1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px"
                                                                y="0px"
                                                                width="16px"
                                                                height="15px"
                                                                viewBox="0 0 612 612"
                                                                style="enable-background:new 0 0 612 612; overflow:unset;"
                                                                xml:space="preserve"
                                                            >
                                                                <path
                                                                    fill="#7224f2"
                                                                    d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                                    H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                                    c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                                    C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                                    S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                                    c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                                />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </perfect-scrollbar>
                                            </popover>
                                            <button
                                                v-if="edit"
                                                v-popover.top="{ name: '' + item.id }"
                                                class="btn p-0 mr-2"
                                                style="height:30px; width: 30px; min-width: 30px; background: transparent; color:#7224f2;"
                                            >
                                                <svg
                                                    version="1.1"
                                                    id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    x="0px"
                                                    y="0px"
                                                    width="16px"
                                                    height="15px"
                                                    viewBox="0 0 612 612"
                                                    style="enable-background:new 0 0 612 612; overflow:unset;"
                                                    xml:space="preserve"
                                                >
                                                    <path
                                                        fill="#7224f2"
                                                        d="M431.001,289.189l-108.19-108.19c-7.478-7.478-19.583-7.478-27.042,0c-7.478,7.478-7.478,19.584,0,27.043l78.814,78.833
                                                        H172.125C161.568,286.875,153,295.443,153,306c0,10.557,8.568,19.125,19.125,19.125h202.457l-78.814,78.814
                                                        c-7.478,7.478-7.478,19.584,0,27.042c7.478,7.479,19.584,7.479,27.042,0l108.19-108.189c4.59-4.59,6.005-10.863,4.973-16.811
                                                        C437.006,300.071,435.572,293.779,431.001,289.189z M306,0C136.992,0,0,136.992,0,306s136.992,306,306,306s306-137.012,306-306
                                                        S475.008,0,306,0z M306,573.75C158.125,573.75,38.25,453.875,38.25,306C38.25,158.125,158.125,38.25,306,38.25
                                                        c147.875,0,267.75,119.875,267.75,267.75C573.75,453.875,453.875,573.75,306,573.75z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button
                                            v-if="!edit"
                                            class="btn float-right p-0 mdi mdi-chevron-right"
                                            style="height:36px; width: 36px; min-width: 36px; background: transparent; color: #6633ff; font-size: 18px"
                                        >
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <pagination :limit="3" :data="laravelData" @pagination-change-page="getData"></pagination>
                        </div>
                        <div v-if="loading" class="row w-100 mx-auto align-items-center justify-content-center">
                            <div style="color:#7c34f2" class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "UserHistory",
        props: [
            "edit",
            "selected_user"
        ],
        created: function() {
            this.getData();
        },
        data() {
            let startDate = new Date();
            let endDate = new Date();
            startDate.setDate(startDate.getDate() - 6);
            return {
                // lodaing
                loading: false,
                dateRange: { startDate, endDate },
                history: [],
                laravelData: {},
                local_data: {
                    format: 'mm/dd/yyyy',
                    separator: " - ",
                    applyLabel: "Подтвердить",
                    cancelLabel: "Сбросить",
                    daysOfWeek: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
                    monthNames: [
                        "Янв",
                        "Февр",
                        "Март",
                        "Апр",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Авг",
                        "Сент",
                        "Окт",
                        "Нояб",
                        "Дек"
                    ],
                    firstDay: 1
                },
                operation_type: "",
                object_type: "",
                object: "",
                //sort
                currentSort: "date",
                currentSortDir: "asc",
            }
        },
        watch: {
            operation_type: {
                handler: function () {
                    this.getData()
                }
            },
            dateRange: {
                handler: function () {
                    this.getData()
                },
                deep: true
            },
            object_type: {
                handler: function () {
                    this.getData()
                }
            },
            object: {
                handler: function () {
                    this.getData()
                }
            },
        },
        computed: {
            sortedList: function () {

                return this.history.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === "desc") modifier = -1;
                    if(this.currentSort == 'object_type') {
                        if (a.object.typeTitle < b.object.typeTitle)
                            return -1 * modifier;
                        if (a.object.typeTitle > b.object.typeTitle)
                            return 1 * modifier;
                    }
                    else if(this.currentSort == 'object') {
                        console.log('sort', a.object.objectTitle, b.object.objectTitle)
                        if (a.object.objectTitle < b.object.objectTitle)
                            return -1 * modifier;
                        if (a.object.objectTitle > b.object.objectTitle)
                            return 1 * modifier;
                    }
                    else {
                        if (a[this.currentSort] < b[this.currentSort])
                            return -1 * modifier;
                        if (a[this.currentSort] > b[this.currentSort])
                            return 1 * modifier;
                    }
                    return 0;
                });
            },
            filteredList() {
                return this.history.filter(item => {
                    let operation_type = true,
                        object_type = true,
                        object = true,
                        date = false;

                    console.log(item)
                   /* if (this.operation_type !== "") {
                        operation_type =
                            item.action === this.operation_type;
                    }*/

                   /* if (this.object_type !== "") {
                        object_type = item.type === this.object_type;
                    }

                    if (this.object !== "") {
                        if(item.type === 1){
                            object = item.object.serial === this.object;
                        }
                        if(item.type === 2){
                            object = item.object.title === this.object;
                        }
                        if(item.type === 3){
                            object = item.object.id === this.object;
                        }
                    }

                    if (
                        moment(item.created_at).isBetween(
                            this.dateRange.startDate,
                            this.dateRange.endDate
                        )
                    ) {
                        date = true;
                    }
*/
                   // return operation_type && object_type && object && date;

                    return item
                });
            },
        },
        methods: {
            getData(page = 1) {
                this.loading = true;
                //console.log(this.object);
                axios
                    .get("/history?page=" + page, {
                        params: {
                            operation_type: this.operation_type,
                            object_type: this.object_type,
                            object_type_id: this.object.type,
                            selected_user: this.selected_user.id,
                            start_date: this.dateRange.startDate,
                            end_date: this.dateRange.endDate,
                            //user_id: this.selected_user.id
                        }
                    })
                    .then(resp => {
                        console.log(resp.data.data);
                        this.loading = false;
                        this.history = resp.data.data;
                        this.laravelData = resp.data;
                    })
                    .catch((resp) => {
                        this.loading = false;
                        console.log(resp);
                    });
            },
            rangeText(range) {
                var text = range.split(' - ');
                text = moment(text[0]).format("DD MMMM YYYY HH:mm") + ' - ' + moment(text[1]).format("DD MMMM YYYY HH:mm");
                return text;
            },
            toObjectPage(id) {
                window.location.href = "/devices/" + id;
            },
            toGroupPage(id) {
                window.location.href = "/device-groups/" + id;
            },
            sort: function (s) {
                //if s == current sort, reverse
                if (s === this.currentSort) {
                    this.currentSortDir =
                        this.currentSortDir === "asc" ? "desc" : "asc";
                }
                this.currentSort = s;
            },
            resetFilters() {
                this.operation_type = "";
                this.object_type = "";
                this.object = "";
                let startDate = new Date();
                let endDate = new Date();
                endDate.setDate(endDate.getDate() + 6);
                this.dateRange = { startDate, endDate };
            },
        }
    }
</script>

<style scoped>

    .custom-select {
        color: black;
        font-weight: 500;
        font-size: 12px;
        border-color: #dfe1ee;
    }

    .custom-filter {
        color: #9d9ea5;
        font-size: 12px;
    }

    .filter-icon {
        color: #7c34f2;
        margin-left: 5px;
    }
    .sdm-popover {
        left: -96px !important;
        top: -108px !important;
        height: 120px !important;
        width: 155px !important;
        font-size: 12px;
        padding-top: 15px;
        padding-left: 15px;
        padding-bottom: 15px;
        padding-right: 0px;
    }
    .sdm-popover.dropdown-position-top::before {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #fff;
        bottom: -6px;
        left: calc(84% - 6px);
        filter: drop-shadow(0px 2px 2px rgba(52, 73, 94, 0.1));
    }
</style>
<style>
    .sdm-popover .ps {
        width: 100%;
        height: 90px;
    }
    .sdm-popover .ps .ps__rail-y {
        background: #fff !important;
        opacity: 1 !important;
        width: 3px !important;
    }
    .sdm-popover .ps .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
    .sdm-popover .ps .ps__thumb-y:hover {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
    .sdm-popover .ps .ps__rail-y:hover > .ps__thumb-y, .ps__rail-y:focus > .ps__thumb-y, .ps__rail-y.ps--clicking .ps__thumb-y {
        background-color: #7224f2 !important;
        width: 3px !important;
        right: 0px;
    }
</style>
