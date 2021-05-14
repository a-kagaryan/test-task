<template>
    <v-app>
        <v-row>
            <v-col v-if="!showResult" cols="2" class="pa-10">
                <center>
                    <v-btn @click="start" :disabled="isStarted" color="primary" class="ma-2">Start</v-btn>
                    <ticker @timesUp="onTimesUp" :start="isStarted" :timeLimit="timeLimit" class="ma-2"></ticker>
                    <v-btn @click="onTimesUp" :disabled="!isStarted"  color="success">Finish</v-btn>
                </center>
            </v-col>
            <v-col cols="10">
                <div v-if="isStarted">
                    <app-quiz></app-quiz>
                </div>
            </v-col>
        </v-row>
        <div v-if="showResult">
            <app-quiz-result></app-quiz-result>
        </div>
    </v-app>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
    name: 'app',
    data() {
        return {
            time: null,
        }
    },
    computed: {
        ...mapState(['showResult', 'isStarted', 'timeLimit'])
    },
    methods: {
        ...mapActions(['check', 'start']),
        onTimesUp () {
            this.$store.commit('setIsStarted', false);
            this.check();
        },
    },
}
</script>
<style>
.v-application--wrap {
    min-width: 700px;
}
</style>
