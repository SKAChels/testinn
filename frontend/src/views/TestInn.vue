<template lang="pug">
    b-container
        h1.text-center.mt-5 Проверка принадлежности ИНН плательщику налога на профессиональный доход
        test-inn-form.mt-5
</template>

<script>
    import TestInnForm from "../components/TestInnForm";

    export default {
        name: 'TestInn',
        components: {
            TestInnForm
        }
    }
</script>
