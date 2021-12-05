<template>
    <input ref="holder" type="text">

    <div id="card-element">
        <!-- Stripe Elements Placeholder -->
    </div>

    <button ref="button" @click="handle" data-secret="{{ intent.client_secret }}">
        Subscribe
    </button>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    data() {
        return {
            card : undefined,
            stripe : undefined,
            elements: undefined
        }
    },

    props: {
        intent : Object,
        stripe_public_key : String
    },

    mounted: function () {
        this.stripe = Stripe(this.stripe_public_key)
        this.elements = this.stripe.elements()

        this.card = this.elements.create('card')
        this.card.mount('#card-element');
    },

    methods : {
        async handle(e) {
            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                this.$refs.button, {
                    payment_method: {
                        card: this.card,
                        billing_details: { name: this.$refs.holder.value }
                    }
                }
            );

            if (error) {
                alert('error !')
            } else {
                alert('yay !')
            }
        }
    }
})
</script>

<style scoped>

</style>
