<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white p-3">
                        <a class="btn btn-primary mb-3" href="#/ucp/streams/add">Add a new Stream</a>

                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>Live</th>
                                <th>Active</th>
                                <th>Name</th>
                                <th>Endpoints</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="stream in streams">
                                    <td><i class="fa fa-circle" :class="stream.live ? 'text-success' : 'text-danger'" aria-hidden="true"></i></td>
                                    <td><i class="fa fa-circle" :class="stream.active ? 'text-success' : 'text-danger'" aria-hidden="true"></i></td>
                                    <td>{{ stream.name }}</td>
                                    <td>{{ getProviders(stream) }}</td>
                                    <td>
                                        <a :href="'#/ucp/streams/' + stream.id + '/setup'" class="btn btn-info">Setup</a>
                                        <a :href="'#/ucp/streams/' + stream.id + '/'" class="btn btn-secondary">Edit</a>
                                        <a @click="regenerateKey(stream)" class="btn btn-danger">Regenerate Stream Key</a>
                                        <a @click="deleteStream(stream)" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                streams: []
            }
        },
        mounted() {
            this.axios.get('/streams/list').then(response => {
                this.streams = response.data;
            });
        },
        methods: {
            deleteStream: function (stream) {
                this.streams.splice(this.streams.indexOf(stream), 1);
                this.axios.post('/streams/delete', {id: stream.id});
            },
            regenerateKey: function(stream) {
                this.axios.post('/streams/regenerate', {id: stream.id}).then(response => {
                    window.location.reload();
                });
            },
            getProviders: function (stream) {
                let providers = '';

                stream.endpoints.forEach(endpoint => {
                    providers += endpoint.type + ', ';
                });

                if (providers.length) {
                    providers = providers.substr(0, providers.length - 2);
                }

                return providers;
            }
        },
    }
</script>
<style>
</style>
