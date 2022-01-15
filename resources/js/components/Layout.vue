<template>
    <div>
        <slot name="menu"></slot>
        <div class="row w-100 mt-4 mb-2 mx-auto justify-content-center">
            <div class="col-12 col-md-5">
                <div class="row w-100 mx-auto justify-content-start align-items-center" style="position: relative;">
                    <h3 class="simple-title" style=" font-weight: 700; font-size: 26px; font-family: Montserrat;"
                        v-tooltip="{
                              content: title ,
                              placement: 'bottom-center',
                              classes: ['info'],
                              targetClasses: ['it-has-a-tooltip'],
                              offset: 0,
                              delay: {
                                show: 500,
                                hide: 300,
                              },
                            }"
                    >{{title}}</h3>
                    <slot name="info" v-if="info">
                        <span v-popover.right="{ name: 'info' }" class="ml-1 mb-1 mdi mdi-information" style="color: #7224f2; font-size:18px; cursor: pointer"></span>
                        <popover
                            class="sdm-popover info"
                            :name="'info'"
                        >
                            <perfect-scrollbar>
                                <div class="row w-100 m-auto align-items-center justify-content-center sdm-primary-text">
                                   {{info_text}}
                                </div>
                            </perfect-scrollbar>
                        </popover>
                    </slot>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <slot name="header"></slot>
            </div>
        </div>
        <div class="row w-100 m-auto justify-content-center">
            <div class="col-12">
                <slot name="filters"></slot>
            </div>
        </div>
        <div class="row w-100 m-auto align-items-center justify-content-center">
            <div class="col-12">
                <slot name="main"></slot>
            </div>
        </div>
        <div class="row w-100 m-auto align-items-center justify-content-center">
            <div class="col-12">
                <slot name="pagination"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Layout",
        props: {
            title: {
               type: String,
               required: true
            },
            info: {
                type: Boolean,
                required:false,
                default: false
            },
            info_text: {
                type: String,
                required: false,
                default: ''
            },
        }
            // ['title', 'info', 'info_text']
    }
</script>

<style scoped>
    .info.sdm-popover {
        left: 238px !important;
        top: 0px !important;
        max-height: 100px !important;
        height: 90px !important;
        width: 220px !important;
        font-size: 12px;
    }
    .info.sdm-popover .ps{
        height: 100%;
    }
    .info.sdm-popover.dropdown-position-right::before {
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-right: 6px solid #fff;
        left: -6px;
        top: calc(20% - 6px);
        filter: drop-shadow(-2px 0px 2px rgba(52,73,94,0.1));
    }
</style>
