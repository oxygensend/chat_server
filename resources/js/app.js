/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
const {ObserveVisibility} = require('vue-observe-visibility')
Vue.use(ObserveVisibility)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('choose-room', require('./components/ChooseRoom.vue').default);
Vue.component('create-room', require('./components/CreateRoom.vue').default);
Vue.component('users-panel', require('./components/UsersPanel.vue').default);
Vue.component('chat-panel', require('./components/ChatPanel.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Pusher.logToConsole = true;
let pusher = new Pusher('0088f26dd9d16f7ccf5f', {
    cluster: 'eu'
});
exports.channel = pusher.subscribe('my-channel');


const app = new Vue({
    el: '#app',


});
