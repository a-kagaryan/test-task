/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;
import VueX from 'vuex';
import vuetify from './vuetify'
Vue.use(VueX)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('App', require('./components/App.vue').default);
Vue.component('Ticker', require('./components/Ticker.vue').default);
Vue.component('AppQuiz', require('./components/AppQuiz.vue').default);
Vue.component('AppQuestion', require('./components/AppQuestion.vue').default);
Vue.component('AppQuizResult', require('./components/AppQuizResult.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const store = new VueX.Store({
    state: {
        questions: {},
        quizResult: [],
        isStarted: false,
        showResult: false
    },
    mutations: {
        setQuestions (state, value) {
            state.questions = value
        },
        setQuizResult (state, value) {
            state.quizResult = value
        },
        setShowResult (state, value) {
            state.showResult = value
        },
        setIsStarted (state, value) {
            state.isStarted = value
        },

    },
    getters: {
        answers(state) {
            const answers = {};

            for (let question of state.questions) {
                answers[question.id] = question.userAnswers
            }

            return answers;
        },
        timeLimit(state) {
            let time = 0;
            for (let question of state.questions) {
                time += question.time;
            }

            return time;
        },
        maxPossiblePoints(state) {
            let points = 0;

            for (let question of state.questions) {
                points += question.points;
            }

            return points;
        }
    },
    actions: {
        loadQuestions({state, commit}) {
            fetch('/list')
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                data.map((question) => {
                    return question.userAnswers = null;
                })
                commit('setQuestions', data);
            });
        },
        start ({state, commit}) {
            commit('setIsStarted', true);
        },
        check({state, commit, getters}) {
            fetch('/check', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin':'*'
                },
                body: JSON.stringify({data: getters.answers})
            })
           .then((response) => {
                return response.json();
            })
            .then((data) => {
                commit('setQuizResult', data)
                commit('setShowResult', true);
            });
        }
    }
})

const app = new Vue({
    el: '#app',
    store,
    vuetify
});
