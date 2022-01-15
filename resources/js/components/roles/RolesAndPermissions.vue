<template>

    <div>


        <p class="mb-1 mt-2 d-flex sdm-secondary-text">
            Роли
        </p>


        <multiselect
            placeholder="Выберите роль"
            :taggable="true"
            @tag="addRole"
            @remove="removeRole"
            :limit="3"
            selectedLabel="Выбрано"
            tagPlaceholder="Создать роль"
            selectLabel="Выбери роль"
            deselectLabel="Enter для удаления роли"
            v-model="currentRole"
            :options="rolesOptions">
        </multiselect>


        <p class="mb-1 mt-2 d-flex sdm-secondary-text">
            Привелегии
        </p>

        <multiselect
            placeholder="Выберите привелегии"
            :multiple="true"
            :limit="3"
            selectedLabel="Выбрано"
            selectLabel="Выбери привелегию"
            deselectLabel="Enter для удаления привелегии"
            v-model="currentPermissions"
            :options="permissions">
        </multiselect>


    </div>

</template>
<script>


    export default {
        data() {
            return {
                roles: [],
                permissions: [],

                currentPermissions: [],
                currentRole: '',
                rolesOptions: [],


            }

        },
        watch: {
            currentPermissions: function (oldVal, newVal) {

                this.updatePermissions()
            },
            'currentRole': function (oldVal, newVal) {
                this.currentPermissions = [];

                this.roles.forEach(item => {
                    if (item.name === this.currentRole) {
                        item.permissions.forEach(sub => {
                            this.currentPermissions.push(sub.name)
                        })
                    }

                })
            }
        },
        mounted() {
            this.uploadRolesAndPermissions()
        },
        methods: {
            sendNotify(notification, type = 'primary') {
                this.$notify({
                    title: 'Роли и разрешения',
                    text: notification,
                    type: type
                });
            },
            removeRole(roleName) {
                if (!this.roles)
                    return;
                let id = this.roles.filter(item => item.name === roleName)[0].id;

                axios
                    .delete(`/role/${id}`).then(() => {
                    this.sendNotify("Роль успешно удалена", "success")
                    this.uploadRolesAndPermissions();
                }).catch(()=>{
                    this.sendNotify("Ошибка удаления роли", "error")
                })
            },
            updatePermissions() {
                if (!this.roles&&!this.permissions)
                    return;

                let roles = this.roles.filter(item => item.name === this.currentRole)||[];

                if (roles.length===0)
                    return;

                let id = roles[0].id

                axios.put(`/role/${id}`, {
                    permissions: this.currentPermissions
                }).then(() => {
                    this.sendNotify("Привелегии успешно обновлены", "success")
                })
            },
            addRole(newRole) {
                axios
                    .post('/role', {
                        title: newRole,
                        permissions: []
                    }).then(() => {
                    this.sendNotify("Роль успешно создана", "success")
                    this.uploadRolesAndPermissions();
                })
            },
            uploadRolesAndPermissions() {
                axios.get('/role').then(resp => {
                    this.permissions = [];
                    this.currentPermissions = []
                    this.currentRole = ''
                    this.rolesOptions = []

                    this.roles = resp.data.roles.data

                    this.roles.forEach(item => {
                        this.rolesOptions.push(item.name)
                        console.log(item.name);
                    })


                    resp.data.permissions.data.forEach(item => {
                        this.permissions.push(item.name)
                    })


                })
            }
        }
    }
</script>

<style>

</style>
