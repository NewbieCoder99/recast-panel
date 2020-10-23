// ReCast Views
import Login from '../components/ReCast/Login';

import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'

// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'


// Admin pages
import Overview from 'src/components/ReCast/Overview.vue'
import ListStreams from 'src/components/ReCast/Streams/List.vue'
import EditStream from 'src/components/ReCast/Streams/EditStream.vue'
import SetupStream from 'src/components/ReCast/Streams/SetupStream.vue'
import EditEndpoint from 'src/components/ReCast/Endpoints/EditEndpoint.vue'

import AccountSettings from 'src/components/ReCast/AccountSettings.vue'

const routes = [
    {
        path: '/',
        redirect: '/ucp/overview'
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        path: '/ucp',
        component: DashboardLayout,
        redirect: '/ucp/overview',
        meta: {auth: true},
        children: [
            {
                path: 'overview',
                name: 'Overview',
                component: Overview,
                meta: {auth: true},
            },
            {
                path: 'settings',
                component: AccountSettings,
                meta: {auth: true},
            },
            {
                path: 'streams',
                name: 'My Streams',
                component: ListStreams,
                meta: {auth: true},
            },
            {
                path: 'streams/:id/',
                component: EditStream,
                meta: {auth: true},
            },
            {
                path: 'streams/:id/setup',
                component: SetupStream,
                meta: {auth: true},
            },
            {
                path: 'streams/:streamId/endpoints/:id',
                component: EditEndpoint,
                meta: {auth: true},
            },
        ]
    },
    {path: '*', component: NotFound}
];

export default routes
