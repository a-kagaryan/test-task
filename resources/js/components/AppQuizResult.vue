<template>
    <div class="result">
        <h2 class="center">You collected {{ quizResult.collectedPoints }} points from {{ maxPossiblePoints }}</h2>
        <div v-for="(question, key) in questions" class="task-container" :key="key">
            <h3 :class="question.passed ? 'successText' : 'errorText' ">{{key + 1 + ') ' + question.body}}</h3>
            <div v-for="(choice, i) in question.choices" :key="i">
                <div v-if="question.is_multi_answer" class="item checkbox-item" :class="question.classes[i]">
                    <input v-model="question.userAnswers"
                       :value="choice.id"
                       type="checkbox" :id="'variant_' + key + '_' + i" disabled>
                    <label :for="'variant_' + key + '_' + i">
                        <b>{{choice.body}}</b>
                    </label>
                </div>
                <div v-else class="item radio-item" :class="choice.classes">
                    <input v-model="quizResult.questions[question.id].user_answer" type="radio" :value="choice.id"
                           :id="'variant_' + key + '_' + i" disabled/>
                    <label :for="'variant_' + key + '_' + i">
                        <b>{{ choice.body }}</b>
                    </label>
                </div>
            </div>
            <br><br>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex';

    export default {
        name: "AppQuizResult",
        data() {
            return {
                collectedPoints: 0,
            }
        },
        computed: {
            ...mapGetters(['maxPossiblePoints', 'timeLimit']),
            ...mapState(['quizResult', 'questions'])
        },
        beforeMount() {
            this.questions.map((task) => {
                task.passed = this.quizResult.questions[task.id].passed
                task.classes = [];

                for (let i = 0; i < task.choices.length; i++) {
                    task.choices[i].classes = {
                        successR: this.quizResult.questions[task.id].right_answer === task.choices[i].id,
                        errorR: this.quizResult.questions[task.id].right_answer !== task.choices[i].id
                            && this.quizResult.questions[task.id].user_answer === task.choices[i].id
                    }
                }
            })
        }
    }
</script>

<style scoped>
    .item {
        display: inline-block;
        position: relative;
        padding: 0 6px;
        margin: 10px 0 0;
    }

    .item input {
        display: none;
    }

    .item label:before {
        content: " ";
        display: inline-block;
        position: relative;
        top: 0px;
        margin: 0 5px 0 0;
        width: 18px;
        height: 18px;
        border: 2px solid #004c97;
        background-color: transparent;
    }

    .item.errorR input[type=radio]:checked + label:before {
        border: 2px solid red;
    }

    .item.errorR input[type=radio]:checked + label:after {
        background: #ff0000;
    }

    .item.successR input + label:before {
        border: 2px solid #008000;
    }

    .item.successR input[type=radio] + label:after {
        background: green;
        border-radius: 50%;
        width: 10px;
        height: 10px;
        position: absolute;
        top: 4px;
        left: 10px;
        content: " ";
        display: block;
    }

    .item.successR.checkbox-item input + label:after {
        color: green;
        content: "✓";
    }

    .item.errorR.checkbox-item input + label:after {
        color: red;
        content: "✓";
    }

    .item.errorR.checkbox-item input + label:before {
        border: 2px solid red;
    }

    .item input + label:after {
        border-radius: 50%;
        width: 10px;
        height: 10px;
        position: absolute;
        top: 4px;
        left: 10px;
        content: " ";
        display: block;
    }

    .item.checkbox-item input + label:before {
        border-radius: 4px;
    }

    .item.radio-item input + label:before {
        border-radius: 50%;
    }

    .item.checkbox-item input + label:after {
        font-weight: bold;
        top: -4px;
        left: 8px;
    }

    .errorText {
        color: red
    }

    .successText {
        color: green
    }

    .center {
        text-align: center;
    }
</style>
