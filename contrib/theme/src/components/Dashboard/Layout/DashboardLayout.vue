<template>
    <div class="wrapper">
        <side-bar>
            <sidebar-link to="/ucp/overview">
                <i class="fa fa-line-chart"></i>
                <p>Dashboard</p>
            </sidebar-link>
            <sidebar-link to="/ucp/streams">
                <i class="fa fa-signal"></i>
                <p>My Streams</p>
            </sidebar-link>
        </side-bar>
        <div class="main-panel">
            <top-navbar></top-navbar>

            <dashboard-content @click="toggleSidebar">

            </dashboard-content>

            <content-footer></content-footer>
        </div>
    </div>
</template>
<style lang="scss">

</style>
<script>
    import TopNavbar from './TopNavbar.vue'
    import ContentFooter from './ContentFooter.vue'
    import DashboardContent from './Content.vue'

    export default {
        components: {
            TopNavbar,
            ContentFooter,
            DashboardContent
        },
        methods: {
            toggleSidebar() {
                if (this.$sidebar.showSidebar) {
                    this.$sidebar.displaySidebar(false)
                }
            }
        }
    }

</script>
