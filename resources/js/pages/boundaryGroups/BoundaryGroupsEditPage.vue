<template>
    <div>
        <layout title="Редактировать группу" :info="false">
            <template v-slot:menu>
                <div
                    class="row w-100 m-auto justify-content-end align-items-center"
                >
                    <div style="z-index: 9" class="col-12 col-md-6">
                        <ol
                            class="breadcrumb m-0 align-items-center"
                            style="background-color: transparent; padding-left: 0"
                        >
                            <li class="">
                                <a
                                    href="/home"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Панель управления
                                </a>
                            </li>
                            <li class="">
                                <div
                                    class="mx-3 mdi mdi-dots-horizontal"
                                    style="color: rgb(157, 158, 165);font-size: 17px;"
                                ></div>
                            </li>
                            <li class="">
                                <a
                                    href="/boundary-groups"
                                    style="color: #9d9ea5; text-decoration: none"
                                >
                                    Группы рубежей
                                </a>
                            </li>
                            <li class="">
                                <div
                                    class="mx-3 mdi mdi-dots-horizontal"
                                    style="color: rgb(157, 158, 165);font-size: 17px;"
                                ></div>
                            </li>
                            <li class="" aria-current="page">
                                <a
                                    href="#"
                                    style="border-bottom: 3px solid #7224f2; color: black; text-decoration: none; font-weight: 500; padding: 15px 0px"
                                >
                                    Редактировать группу
                                </a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div
                            id="top-slider"
                            class="row w-100 mx-auto d-flex align-items-center justify-content-center"
                        >
                            <p style="color:#9d9ea5" class="switch-label">Все рубежи</p>
                            <label class="switch mr-2 ml-2">
                                <input type="checkbox"
                                       v-model="groups"
                                       :disabled="!groups"
                                       v-on:change="toDevices($event.target.checked)"
                                >
                                <span class="slider round"></span>
                            </label>
                            <p class="switch-label">Группы рубежей</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <user-menu :user="user"></user-menu>
                    </div>
                    <div
                        class="col-12"
                        style="border-bottom: 1px solid #e3e3e5"
                    ></div>
                </div>
            </template>
            <template v-slot:main>
                <boundary-groups-edit
                    :boundaries="boundaries"
                    :group="group"
                    :connectedboundaries="connectedboundaries"
                ></boundary-groups-edit>
            </template>
        </layout>
    </div>
</template>

<script>
import Layout from "../../components/Layout";
import BoundaryGroupsEdit from "../../components/boundaryGroups/BoundaryGroupsEdit";

export default {
    name: "DeviceGroupsAddPage",
    props: ['user', 'boundaries', 'group', 'connectedboundaries'],
    components: {
        Layout, BoundaryGroupsEdit
    },
    data: () => ({
        groups: true,
    }),
    methods: {
        toDevices: function (event) {
            window.location.href = `/boundaries`;
        }
    }
};
</script>

<style scoped>
#dropdownMenuButton::after {
    display: none;
}

.active-toggler {
    color: #6633ff;
}

.form-select {
    display: block;
    width: 100%;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    vertical-align: middle;
    background-color: transparent;
    background-image: url("/chevron-down.svg");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.checkbox-custom {
    opacity: 0;
    position: absolute;
}

.checkbox-custom,
.checkbox-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px;
    cursor: pointer;
    font-weight: 500;
    font-size: 10px;
}

.checkbox-custom-label {
    position: relative;
}

.checkbox-custom + .checkbox-custom-label:before {
    content: "";
    /*background: #fff;*/
    border: 1px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    width: 17px;
    height: 17px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
    border-radius: 3px;
}

#checkbox-1 + .checkbox-custom-label:before {
    border: 1px solid #d62627;
}

#checkbox-2 + .checkbox-custom-label:before {
    border: 1px solid #6917f1;
}

#checkbox-3 + .checkbox-custom-label:before {
    border: 1px solid #458d3c;
}

#checkbox-1:checked + .checkbox-custom-label:before {
    background: #d62627;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-2:checked + .checkbox-custom-label:before {
    background: #6917f1;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

#checkbox-3:checked + .checkbox-custom-label:before {
    background: #458d3c;
    box-shadow: inset 0px 0px 0px 4px #fff;
}

.checkbox-custom:focus + .checkbox-custom-label {
    outline: none;
}
</style>
