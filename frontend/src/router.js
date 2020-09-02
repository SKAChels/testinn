import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            name: 'Home',
            path: '/',
            redirect: '/testinn',
            component: () => import('./containers/DefaultContainer'),
            children: [
                {
                    path: 'testinn',
                    name: 'TestInn',
                    component: () => import('./views/TestInn')
                }
            ]
        },
    ]
})
