<template>
<div class="row w-100 my-2 mx-auto justify-content-end">
    <div class="dropdown w-100" style="">
        <button class="btn w-100 dropdown-select" style="padding: .375rem 1.75rem .375rem .75rem; font-size: 11px; font-weight: 500; border: 1px solid rgb(223, 227, 231);" type="button" id="dropdownMenu" data-toggle="dropdown" aria-expanded="false" title="Просмотре меню пользователя">
            <div class="row w-100 m-auto align-items-center">
                <span>{{ user.name }}</span>
                <span class="ml-3 mdi mdi-chevron-down" style="color: rgb(108, 24, 241);font-size: 18px; position: absolute; right: 5px"></span>
            </div>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
            <li>
                <a class="dropdown-item" href="#profile" @click="editUser">
                    Настройки
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="" @click.prevent="logout">
                    Выход
                </a>
            </li>
        </ul>
    </div>
</div>
</template>

<script>
export default {
    name: "UserMenu",
    props: ['user'],
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    methods: {
        submit: function () {
            this.$refs.form.submit();
        },
        editUser() {
            window.location.href = `/users/edit/${this.user.id}`;
        },
        logout() {
            axios
                .post("/logout")
                .then(res => {
                    window.location.href = '/login';
                })
                .catch(err => {
                    console.log(err);
                });
        },
    }
}
</script>

<style scoped>

</style>
