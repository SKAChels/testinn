<template lang="pug">
    b-overlay(:show="loading")
        ValidationObserver(ref="observer" v-slot="{ passes }")
            b-form(
                @submit.prevent="passes(onSubmit)"
            )
                validated-masked-input(
                    :text="form.inn.text"
                    :placeholder="form.inn.placeholder"
                    :mask="form.inn.mask"
                    :rules="form.inn.rules"
                    :value.sync="form.inn.value"
                )
                b-alert.mt-3(
                    :show="result !== null"
                    variant="success"
                    v-html="result"
                )
                b-alert.mt-3(
                    :show="error !== null"
                    variant="danger"
                    v-html="error"
                )
                button.btn.btn-block.btn-primary.mt-3.py-3(
                    type="submit"
                ) Отправить
</template>

<script>
    import {ValidationObserver} from "vee-validate";
    import ValidatedMaskedInput from "../components/form/ValidatedMaskedInput";

    export default {
        name: 'TestInnForm',
        components: {
            ValidationObserver,
            ValidatedMaskedInput,
        },
        data() {
            return {
                form: {
                    inn: {
                        text: 'ИНН',
                        placeholder: 'Введите ИНН',
                        mask: '############',
                        rules: 'required|length_one_of:10,12',
                        value: null
                    }
                },
                result: null,
                error: null,
                loading: false,
            }
        },
        methods: {
            onSubmit() {
                return new Promise((resolve, reject) => {
                    this.result = null;
                    this.error = null;
                    this.loading = true;

                    let data = {
                        inn: this.form.inn.value
                    };
                    this.axios.post(this.$config.makeApiUrl('v1/inn/check'), data)
                        .then((response) => {
                            this.result = response.data
                                ? 'Налогоплательщик является плательщиком налога на профессиональный доход'
                                : 'Налогоплательщик не является плательщиком налога на профессиональный доход';
                            resolve();
                        })
                        .catch((error) => {
                            this.error =  this.$config.apiError(error);
                            reject(error);
                        })
                        .finally(() => {this.loading = false;});
                });
            },
        }
    }
</script>
