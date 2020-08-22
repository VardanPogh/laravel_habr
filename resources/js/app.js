/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('dashboard-component', require('./components/Admin/DashboardComponent.vue').default);
Vue.component('categories-component', require('./components/Admin/Categories/CategoriesComponent.vue').default);
Vue.component('services-add-edit-component', require('./components/Admin/Services/ServicesAddEditComponent.vue').default);
Vue.component('categories-add-edit-component', require('./components/Admin/Categories/CategoriesAddEditComponent.vue').default);
Vue.component('services-component', require('./components/Admin/Services/ServicesComponent.vue').default);
Vue.component('agent-component', require('./components/Admin/Agents/AgentsComponent.vue').default);
Vue.component('agent-add-edit-component', require('./components/Admin/Agents/AgentsAddEditComponent.vue').default);
Vue.component('client-component', require('./components/Admin/Client/ClientComponent.vue').default);
Vue.component('client-add-edit-component', require('./components/Admin/Client/ClientAddEditComponent.vue').default);
Vue.component('general-categories-component', require('./components/Admin/General/GeneralCategoriesComponent.vue').default);
Vue.component('managers-component', require('./components/Admin/Managers/ManagersComponent.vue').default);
Vue.component('transactions-component', require('./components/Admin/Transactions/TransactionsComponent.vue').default);





Vue.component('agent-user-component', require('./components/User/AgentComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
