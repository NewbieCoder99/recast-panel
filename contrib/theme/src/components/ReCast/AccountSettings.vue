<template>
    <div class="content">
        <div class="container-fluid">
            <card>
                <h4>Change Password</h4>

                <form @submit="changePassword">
                    <fg-input label="Current Password" v-model="resetPassword.currentPassword" type="password" required="required"></fg-input>
                    <fg-input label="New Password" v-model="resetPassword.newPassword" pattern=".{6,}" type="password" required="required"></fg-input>
                    <small>Passwords must have at minimum 6 characters</small>
                    <fg-input label="New Password Repeat" v-model="resetPassword.newPassword2" pattern=".{6,}" type="password" required="required"></fg-input>

                    <button class="btn btn-primary">Change Password</button>
                </form>
            </card>
        </div>
    </div>
</template>
<script>
    import Card from "../UIComponents/Cards/Card";

    export default {
        components: {
            Card
        },
        data() {
            return {
                resetPassword: {
                    currentPassword: '',
                    newPassword: '',
                    newPassword2: '',
                }
            }
        },
        methods: {
            changePassword: function (e) {
                e.preventDefault();

                if (this.resetPassword.newPassword !== this.resetPassword.newPassword2) {
                    const notification = {
                        template: `<span>New Passwords are not equal</span>`
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
                    this.axios.post('/auth/changePassword', {currentPassword: this.resetPassword.currentPassword, newPassword: this.resetPassword.newPassword}).then(response => {
                        this.$auth.logout({
                            redirect: {name: 'login'}
                        })
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
            }
        }
    }
</script>
<style>
    h4 {
        margin-top: 0;
    }
</style>
