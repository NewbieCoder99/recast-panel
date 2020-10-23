<template>
    <div class="loginWrapper">
        <div class="sidebarBanner"></div>
        <div class="loginForm" v-if="!showRegistration">
            <h4>Login</h4>

            <div class="alert alert-danger" v-if="authFailed">Bad credentials</div>

            <form @submit="onLogin">
                <fg-input type="text"
                          label="Username"
                          placeholder="Username"
                          v-model="login._username">
                </fg-input>

                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="login._password">
                </div>

                <div class="form-group">
                    <p-checkbox v-model="rememberMe">Remember Me</p-checkbox>
                </div>

                <button class="btn btn-primary">Login</button>

                <div v-if="settings.registrationEnabled">
                    <hr>
                    <div class="text-center">
                        <a @click="toggleRegistration" href="#">Create a new Account</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="loginForm" v-if="showRegistration">
            <h4>Registration</h4>

            <form @submit="onRegister">
                <fg-input type="text"
                          label="Username"
                          placeholder="Username"
                          pattern=".{3,}"
                          v-model="register.username">
                </fg-input>

                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" pattern=".{6,}" placeholder="Password" v-model="register.password">
                </div>

                <div class="form-group">
                    <label class="control-label">Password Confirmation</label>
                    <input type="password" class="form-control" pattern=".{6,}" placeholder="Password Confirmation" v-model="register.passwordConfirm">
                </div>

                <fg-input type="email"
                          label="Email"
                          placeholder="Email"
                          v-model="register.email">
                </fg-input>

                <button class="btn btn-primary">Register</button>
                <hr>
                <div class="text-center">
                    <a @click="toggleRegistration" href="#">I have already a account</a>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import PCheckbox from 'src/components/UIComponents/Inputs/Checkbox.vue'
    import Card from 'src/components/UIComponents/Cards/Card.vue'

    export default {
        mounted() {
            this.axios.get('/settings').then(response => {
                this.settings = response.data;
            })
        },
        components: {
            Card,
            PCheckbox
        },
        data() {
            return {
                login: {
                    _username: '',
                    _password: '',
                },
                register: {
                    username: '',
                    password: '',
                    passwordConfirm: '',
                    email: ''
                },
                rememberMe: false,
                authFailed: false,
                settings: {
                    registrationEnabled: false
                },
                showRegistration: false
            }
        },
        methods: {
            onLogin: function (e) {
                e.preventDefault();
                let bodyFormData = new FormData();
                bodyFormData.set('_username', this.login._username);
                bodyFormData.set('_password', this.login._password);

                this.$auth.login({
                    data: bodyFormData,
                    rememberMe: this.rememberMe,
                    redirect: {name: 'Overview'},
                    error: () => {
                        const notification = {
                            template: `<span>Login failed</span>`
                        };

                        this.$notify(
                            {
                                component: notification,
                                icon: 'fa fa-exclamation-triangle',
                                horizontalAlign: 'right',
                                verticalAlign: 'top',
                                type: 'danger'
                            });
                    }
                })
            },
            onRegister: function(e) {
                e.preventDefault();

                if (this.register.password !== this.register.passwordConfirm) {
                    const notification = {
                        template: `<span>Passwords are not equal</span>`
                    };

                    this.$notify(
                        {
                            component: notification,
                            icon: 'fa fa-exclamation-triangle',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            type: 'danger'
                        });
                } else {
                    this.axios.post('/register', this.register).then(response => {
                        const notification = {
                            template: `<span>Registration was successfully. You can login now</span>`
                        };

                        this.$notify(
                            {
                                component: notification,
                                icon: 'fa fa-exclamation-triangle',
                                horizontalAlign: 'right',
                                verticalAlign: 'top',
                                type: 'success'
                            });
                        this.toggleRegistration();
                    }).catch(error => {
                        const notification = {
                            template: `<span>${error.response.data.message}</span>`
                        };

                        this.$notify(
                            {
                                component: notification,
                                icon: 'fa fa-exclamation-triangle',
                                horizontalAlign: 'right',
                                verticalAlign: 'top',
                                type: 'danger'
                            });
                    })
                }
            },
            toggleRegistration: function () {
                this.showRegistration = !this.showRegistration;
            }
        }
    }
</script>
<style>
    .loginWrapper {
        height: 100vh;
        align-items: stretch;
        flex-wrap: nowrap;
        box-sizing: border-box;
        justify-content: flex-start;
        display: flex;
        flex-flow: nowrap;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .loginForm {
        flex: 1 0 auto;
        padding: 80px 40px 80px 40px;
    }

    .sidebarBanner {
        background-image: url("/static/img/bg.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        height: 100%;
        flex: 4 1 auto;
    }
</style>
