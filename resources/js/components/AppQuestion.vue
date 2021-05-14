<template>
    <v-card
        class="mb-12 pa-10"
        color="#DAE3FC"
        height="200px">
        <div>
            <h3 class="text-center"> {{ index + 1 + ') ' + question.body }}</h3>
            <div v-for="(choice, i) in question.choices" :key="i">
                <input v-if="question.is_multi_answer" :value="choice.id"
                       v-model="question.userAnswers"
                       type="checkbox" :id="'variant_' + index + '_' + i">
                <input v-else
                    v-model="question.userAnswers" type="radio" :value="choice.id"
                   :id="'variant_' + index + '_' + i">
                <label :for="'variant_' + index + '_' + i">
                    {{ choice.body }}
                </label>
            </div>
        </div>
        <p class="text-right">{{ question.points }} points</p>
    </v-card>
</template>
<script>
export default {
    name: "AppQuestion",
    props: {
        question: {type: Object},
        index: {type: Number}
    },
}
</script>
<style scoped>

</style>
