<template>
    <div>
        <div
            class="row w-100 mx-auto align-items-center justify-content-center"
        >
            <div class="col-12">
                <div
                    class="row w-100 mx-auto my-2 align-items-center justify-content-center"
                >
                    <div class="col-3 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Фамилия Имя
                        </p>
                        <input
                            v-model="new_user.name"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.name }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.name }}</strong>
                        </span>
                    </div>
                    <div class="col-3 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Email
                        </p>
                        <input
                            type="email"
                            v-model="new_user.email"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.email }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.email }}</strong>
                        </span>
                    </div>
                    <div class="col-3 px-1">
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Выберите роли
                        </p>
                        <v-select
                            placeholder="Поиск..."
                            v-model="currentRole"
                            :options="rolesOptions"
                        >
                        </v-select>
                    </div>
                    <div class="col-3 px-1">
                        <p
                            class="mb-1 d-flex sdm-secondary-text"
                            style="font-size: 9px; color: #959597; font-weight: 400"
                        >
                            Выберите группы устройств
                        </p>
                        <v-select
                            placeholder="Поиск..."
                            v-model="currentGroup"
                            :options="groupsOptions"
                        ></v-select>
                        <!--                        <select-->
                        <!--                            v-model="new_user.device_group_id"-->
                        <!--                            class="form-select custom-select"-->
                        <!--                            placeholder="Поиск..."-->
                        <!--                        >-->
                        <!--                            <option value="" selected>-->
                        <!--                                Нет-->
                        <!--                            </option>-->
                        <!--                            <option :key="device_group.id" :value="device_group.id" v-for="device_group in device_groups">-->
                        <!--                                {{ device_group.title }}-->
                        <!--                            </option>-->
                        <!--                        </select>-->
                    </div>
                </div>
            </div>
            <div
                class="col-12"
                v-if="selectedGroups.length > 0 || selectedRoles > 0"
            >
                <div
                    class="row mx-auto align-items-center justify-content-center"
                >
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    <div class="col-3 px-1">
                        <div class="row w-100 mx-auto mb-3">
                            <div
                                style="display: flex"
                                class="mr-2 mb-1"
                                :key="role.code"
                                v-for="role in selectedRoles"
                            >
                                <div class="mr-1">{{ role.label }}</div>
                                <div
                                    @click="removeRole(role)"
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
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 px-1">
                        <div class="row w-100 mx-auto mb-3">
                            <div
                                class="d-flex mr-2 mb-1"
                                :key="group.code"
                                v-for="group in selectedGroups"
                            >
                                <div class="mr-1 sdm-primary-text">
                                    {{ group.label }}
                                </div>
                                <div
                                    @click="removeGroup(group)"
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
                                        <path
                                            fill="white"
                                            d="M294.111,256.001L504.109,46.003c10.523-10.524,10.523-27.586,0-38.109c-10.524-10.524-27.587-10.524-38.11,0L256,217.892
                                        L46.002,7.894c-10.524-10.524-27.586-10.524-38.109,0s-10.524,27.586,0,38.109l209.998,209.998L7.893,465.999
                                        c-10.524,10.524-10.524,27.586,0,38.109c10.524,10.524,27.586,10.523,38.109,0L256,294.11l209.997,209.998
                                        c10.524,10.524,27.587,10.523,38.11,0c10.523-10.524,10.523-27.586,0-38.109L294.111,256.001z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pr-0">
                <div
                    class="row w-100 mx-auto my-2 align-items-start justify-content-start"
                >
                    <div class="col-3 px-1">
                        <p class="mb-1 d-flex sdm-secondary-text">
                            Пароль
                        </p>
                        <input
                            v-model="new_user.password"
                            class="form-control custom-input"
                            :class="{ 'is-invalid': errors.password }"
                        />
                        <span
                            style="font-size: 10px;"
                            class="invalid-feedback"
                            role="alert"
                        >
                            <strong>{{ errors.password }}</strong>
                        </span>
                    </div>

                    <div class="col-3 px-1"></div>
                    <div class="col-3 px-1"></div>
                </div>
            </div>
        </div>
        <div
            class="row w-100 mx-auto my-2 align-items-center justify-content-end"
        >
            <div class="form-check form-check-inline float-right">
                <input
                    id="checkbox-2"
                    class="checkbox-custom"
                    name="checkbox-2"
                    type="checkbox"
                    v-model="notify_by_mail"
                />
                <label for="checkbox-2" class="checkbox-custom-label">
                    Оповестить на e-mail
                </label>
            </div>
            <button
                v-on:click="submit"
                type="button"
                class="btn my-1 btn-dark py-2 add-button"
                style=""
                :class="{ 'add-button-disabled': loading }"
                :disabled="loading"
            >
                Добавить пользователя
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "UsersAdd",
    props: [
        "device_groups"
        // 'roles'
    ],
    data() {
        return {
            startDate: new Date(),
            new_user: {
                name: "",
                email: "",
                registration_date: null,
                password: "",
                role: null,
                notify: false,
                selected_groups: []
            },
            errors: {
                name: null,
                email: null,
                registration_date: null,
                password: null,
                roles: null,
                selected_groups: null
            },
            notify_by_mail: false,
            roles: [],
            groupsOptions: [],
            selectedGroups: [],
            rolesOptions: [],
            selectedRoles: [],
            currentGroup: null,
            currentRole: "",

            //загрузка
            loading: false
        };
    },
    created() {
        this.device_groups.forEach(group => {
            if (group.deleted_at === null)
                this.groupsOptions.push({
                    label: group.title,
                    code: group.id
                });
        });
        // this.roles.forEach((role) => {
        //     this.rolesOptions.push({label:role.title, code: role.id})
        // })
    },

    watch: {
        selectedGroups: {
            handler: function() {},
            deep: true
        },
        groupsOptions: {
            handler: function() {},
            deep: true
        },
        rolesOptions: {
            handler: function() {},
            deep: true
        },
        selectedRoles: {
            handler: function() {},
            deep: true
        }
    },
    mounted() {
        console.log(this.startDate);
        this.uploadRoles();
    },
    methods: {
        uploadRoles() {
            axios.get("/role").then(resp => {
                this.currentRole = "";
                this.rolesOptions = [];

                this.roles = resp.data.roles.data;

                this.roles.forEach(item => {
                    this.rolesOptions.push(item.name);
                    console.log(item.name);
                });

                this.currentRole = this.user.roles[0].name;
            });
        },
        submit() {
            this.loading = true;
            this.new_user.registration_date = this.startDate;
            this.new_user.roles = this.selectedRoles;
            this.new_user.selected_groups = this.selectedGroups;
            this.new_user.role = this.currentRole;
            this.new_user.notify = this.notify_by_mail;
            if (this.currentGroup) {
                this.new_user.device_group_id = this.currentGroup.code;
            } else {
                this.new_user.device_group_id = null;
            }
            axios
                .post("/user", this.new_user)
                .then(() => {
                    this.sendNotify("Пользовател успешно обновлен", "success");

                    setTimeout(() => {
                        window.location.href = "/users";
                    }, 2000);
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
                    console.log(errors);
                });
        },
        removeGroup(group) {
            let removeIndex = this.selectedGroups
                .map(item => item.code)
                .indexOf(group.code);
            this.selectedGroups.splice(removeIndex, 1);
            this.groupsOptions.push(group);
        },
        removeRole(role) {
            let removeIndex = this.selectedRoles
                .map(item => item.code)
                .indexOf(role.code);
            this.selectedRoles.splice(removeIndex, 1);
            this.rolesOptions.push(role);
        },
        sendNotify(notification, type = "primary") {
            this.$notify({
                title: "Отчеты",
                text: notification,
                type: type
            });
        }
    }
};
</script>

<style scoped>
.add-button {
    background: #7224f2;
    border: none;
    color: white;
    font-size: 11px;
    font-weight: 500;
}

.add-button-disabled {
    background: #dfe1ee !important;
    border: none !important;
}

.custom-input {
    background: transparent;
    color: black;
    font-weight: 500;
    font-size: 12px;
    border-color: #dfe1ee;
}

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
    border: 1px solid #7c34f2;
}

.slider:before {
    position: absolute;
    content: "";
    height: 11px;
    width: 11px;
    left: 4px;
    bottom: 4px;
    background-color: #7c34f2;
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
    background-color: #7c34f2;
}

input:checked + .slider {
    border: 1px solid #7c34f2;
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
.invalid-feedback {
    position: absolute !important;
}
</style>
