import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

//Admin Pages Import
import login from './components/admin/pages/login'
import dashboard from './components/admin/pages/dashboard'
import tags from './components/admin/pages/tag'
import category from './components/admin/pages/category'
import createblog from './components/admin/pages/create-blog'
import adminusers from './components/admin/pages/adminusers'
import role from './components/admin/pages/role'
import permission from './components/admin/pages/permission'

const routes = [
    //All Admin Routes Start
    { path: '/login', component: login, name: 'login' },
    { path: '/dashboard', component: dashboard, name: 'dashboard' },
    { path: '/tags', component: tags, name: 'tags' },
    { path: '/category', component: category, name: 'category' },
    { path: '/create-blog', component: createblog, name: 'create-blog' },
    { path: '/admin-users', component: adminusers, name: 'admin-users' },
    { path: '/roles', component: role, name: 'roles' },
    { path: '/permission', component: permission, name: 'permission' },
]

export default new Router({
    mode: 'history',
    routes
})
