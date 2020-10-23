<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3>Setup</h3>

                    <fg-input label="URL" v-model="stream.streamUrl" readonly="true"></fg-input>
                    <fg-input label="Stream Key" v-model="stream.streamKey" readonly="true"></fg-input>

                    <div v-if="stats.active">
                        <h3>Stream Statistics</h3>

                        <p>
                            <strong>Bytes received</strong> {{ stats.bytes_in / 1048576 | toNumber }} MiB<br>
                            <strong>Bytes sent</strong> {{ stats.bytes_out / 1048576 | toNumber }} MiB<br>
                            <strong>Current bandwidth in</strong> {{ stats.bw_in / 1000000 | toNumber }} Mb/s<br>
                            <strong>Current bandwidth out</strong> {{ stats.bw_out / 1000000 | toNumber }} Mb/s<br>
                            <strong>Res: </strong> {{ stats.meta.video.width }}x{{ stats.meta.video.height }}<br>
                            <strong>FPS: </strong> {{ stats.meta.video.frame_rate }}
                        </p>
                    </div>

                    <h4>OBS</h4>

                    <ul>
                        <li>Go to File, Settings, Stream and choose as Stream Type "Custom Streaming Server"</li>
                        <li>Fill the Server and Stream Key in</li>
                    </ul>
                    <img src="https://i.imgur.com/ltaKXiy.png"/>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                stream: {},
                stats: {}
            }
        },
        mounted() {
            this.axios.get('/streams/one?id=' + this.$route.params.id).then(response => {
                this.stream = response.data;
            });

            this.axios.get(`/streams/${this.$route.params.id}/stats`).then(response => {
                this.stats = response.data;
            })
        },
        filters: {
            toNumber: function (value) {
                return value.toFixed(2);
            }
        }
    }

</script>
<style>

</style>
