<template>
    <v-row justify="space-around">
        <v-col cols="10">
            <v-stepper
                v-model="e1"
                :vertical="vertical"
                :alt-labels="altLabels"
                disabled
            >
                <template v-for="(question, n) in questions">
                    <v-stepper-step
                        :key="`${ n + 1}-step`"
                        :complete="e1 > n + 1"
                        :step="n + 1"
                        :editable="editable"
                    >
                        Question {{ n + 1 }}
                    </v-stepper-step>

                    <v-stepper-content
                        :key="`${n + 1}-content`"
                        :step="n + 1"
                    >
                    <app-question :question="question" :index="+n"></app-question>
                    <v-btn v-if="n < 4"
                           class="ma-2"
                           color="primary"
                           @click="nextStep(n + 1)"
                    >
                        Continue
                    </v-btn>
                    </v-stepper-content>
                </template>
            </v-stepper>
        </v-col>
    </v-row>
</template>

<script>
import {mapState, mapActions} from 'vuex'

export default {
    name: "AppQuiz",
    data() {
        return {
            e1: 1,
            steps: 5,
            vertical: true,
            altLabels: false,
            editable: true,
        }
    },
    computed: {
        ...mapState(['questions'])
    },
    methods: {
        ...mapActions(['loadQuestions']),
        nextStep(n) {
            this.e1 = n === this.steps ? 1 : n + 1
        },
    },
    created() {
        this.loadQuestions();
    }
}
</script>

<style scoped>
.task-container {
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 10px auto;
    width: 50%;
    padding: 10px;
}

.buttons-container {
    width: 60%;
    margin: 10px auto;
}

.fixed {
    position: fixed;
    top: 4%;
    left: 1%;
}
</style>
