<template>
    <input ref="holder" type="text">

    <div id="card-element"></div>

    <button ref="button" @click="handle" data-secret="{{ intent.client_secret }}">
        Subscribe
    </button>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    data() {
        return {
            card : undefined
        }
    },

    props: {
        intent : Object,
        stripe_public_key : String
    },

    mounted: function () {
        this.card = this.elements.create('card')
        this.card.mount(this.$refs.card);
    },

    computed : {
      stripe() {
          return Stripe(this.stripe_public_key)
      },
      elements() {
          return this.stripe().elements
      }
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
