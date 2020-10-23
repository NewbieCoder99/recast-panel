<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4 v-if="$route.params.id == 'add'">Create a new Stream</h4>
                    <h4 v-if="$route.params.id != 'add'">Edit "{{ stream.name }}"</h4>

                    <card>
                        <form @submit="save">
                            <fg-input label="Name" v-model="stream.name"></fg-input>
                            <div class="form-group">
                                <p-checkbox v-model="stream.active">Active</p-checkbox>
                            </div>

                            <button class="btn btn-primary">Save</button>
                        </form>
                    </card>

                    <div v-if="this.$route.params.id !== 'add'">
                        <h4>Endpoints</h4>

                        <div class="bg-white p-3">
                            <a class="btn btn-primary mb-3" :href="'#/ucp/streams/' + $route.params.id + '/endpoints/add'">Add a new Endpoint</a>

                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Active</th>
                                    <th>Name</th>
                                    <th>Service</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="endpoint in endpoints">
                                    <td><i class="fa fa-circle" :class="endpoint.active ? 'text-success' : 'text-danger'" aria-hidden="true"></i></td>
                                    <td>{{ endpoint.name }}</td>
                                    <td>{{ endpoint.type }}</td>
                                    <td>{{ endpoint.server }}</td>
                                    <td>
                                        <a :href="'#/ucp/streams/' + $route.params.id + '/endpoints/' + endpoint.id" class="btn btn-secondary">Edit</a>
                                        <a @click="toggleEndpoint(endpoint)" class="btn btn-info">{{ endpoint.active ? 'Disable' : 'Enable' }}</a>
                                        <a @click="deleteEndpoint(endpoint)" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PCheckbox from 'src/components/UIComponents/Inputs/Checkbox.vue'
    import Card from 'src/components/UIComponents/Cards/Card.vue'

    export default {
        components: {
            PCheckbox,
            Card
        },
        data() {
            return {
                stream: {
                    active: false,
                    name: ''
                },
                endpoints: []
            }
        },
        mounted() {
            if (this.$route.params.id !== 'add') {
                this.axios.get('/streams/one?id=' + this.$route.params.id).then(response => {
                    this.stream = response.data;
                });
                this.axios.get('/streams/' + this.$route.params.id + '/endpoints/').then(response => {
                    this.endpoints = response.data;
                });
            }
        },
        methods: {
            save: function (e) {
                e.preventDefault();
                this.axios.post('/streams/update', this.stream).then(() => {
                    this.$router.push('/ucp/streams/');
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
                });
            },
            deleteEndpoint: function (endpoint) {
                this.endpoints.splice(this.endpoints.indexOf(endpoint), 1);
                this.axios.post('/streams/deleteEndpoint', {id: endpoint.id});
            },
            toggleEndpoint: function (endpoint) {
                this.axios.post('/streams/toggleEndpoint', {id: endpoint.id}).then(response => {
                    this.axios.get('/streams/' + this.$route.params.id + '/endpoints/').then(response => {
                        this.endpoints = response.data;
                    });
                });
            }
        }
    }

</script>
<style>

</style>
