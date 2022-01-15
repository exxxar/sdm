<template>
    <div
        class="modal fade"
        :id="id"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        data-bs-backdrop="static"
    >
        <div style="max-width:800px" class="modal-dialog modal-dialog-centered">
            <div
                class="modal-content"
                style="border-top-right-radius: 0px; border:none;"
            >
                <button
                    type="button"
                    class="btn fas fa-times float-right sdm-close-button-modal"
                    data-dismiss="modal"
                    aria-label="Close"
                ></button>
                <div class="modal-header" v-if="header">
                    <slot name="header"> </slot>
                </div>
                <div
                    class="modal-body"
                    style="display:flex;justify-content:center;flex-direction: column;align-items: center;"
                >
                    <slot name="main"> </slot>
                </div>
                <div class="modal-footer" v-if="footer">
                    <slot name="footer"> </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: ["header", "footer", "id"]
};
</script>

<style scoped>
.sdm-close-button-modal {
    background: #dfe0f0;
    color: #7224f2;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    cursor: pointer;
    width: 36px;
    position: absolute;
    top: -28px;
    right: 0;
}
</style>
