<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <stats-card>
                        <div slot="header" class="icon-warning">
                            <i class="fa fa-signal text-warning"></i>
                        </div>
                        <div slot="content">
                            <p class="card-category">Created streams</p>
                            <h4 class="card-title">{{ stats.streams }}</h4>
                        </div>
                        <div slot="footer">
                            <i class="fa fa-refresh"></i> Updated now
                        </div>
                    </stats-card>
                </div>

                <div class="col-xl-3 col-md-6">
                    <stats-card>
                        <div slot="header" class="icon-success">
                            <i class="fa fa-signal text-success"></i>
                        </div>
                        <div slot="content">
                            <p class="card-category">Live streams</p>
                            <h4 class="card-title">{{ stats.liveStreams }}</h4>
                        </div>
                        <div slot="footer">
                            <i class="fa fa-refresh"></i> Updated now
                        </div>
                    </stats-card>
                </div>

                <div class="col-xl-3 col-md-6">
                    <stats-card>
                        <div slot="header" class="icon-danger">
                            <i class="fa fa-user text-danger"></i>
                        </div>
                        <div slot="content">
                            <p class="card-category">Registered users</p>
                            <h4 class="card-title">{{ stats.users }}</h4>
                        </div>
                        <div slot="footer">
                            <i class="fa fa-refresh"></i> Updated now
                        </div>
                    </stats-card>
                </div>

                <div class="col-xl-3 col-md-6">
                    <stats-card>
                        <div slot="header" class="icon-info">
                            <i class="fa fa-server text-primary"></i>
                        </div>
                        <div slot="content">
                            <p class="card-category">Supported endpoints</p>
                            <h4 class="card-title">{{ stats.endpoints }}</h4>
                        </div>
                        <div slot="footer">
                            <i class="fa fa-refresh"></i> Updated now
                        </div>
                    </stats-card>
                </div>

            </div>

        </div>
    </div>
</template>
<script>
    import StatsCard from 'src/components/UIComponents/Cards/StatsCard.vue'

    export default {
        components: {
            StatsCard
        },
        mounted() {
            this.axios.get('/stats').then(response => {
                this.stats = response.data;
            });
        },
        data() {
            return {
                stats: {
                    streams: 0,
                    liveStreams: 0,
                    users: 0,
                    endpoints: 0
                }
            }
        }
    }
</script>
<style>

</style>
