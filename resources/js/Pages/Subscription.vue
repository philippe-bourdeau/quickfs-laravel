<template>
    <div class="text-center">
        <h2 class="text-2xl font-bold">
            Hold up! You need an active subscription first.
        </h2>
        <jet-button class="mt-4 mr-2" style="background-color:#22c55e" @click.native="checkout">
            To checkout
        </jet-button>
        <jet-button class="mt-4" style="background-color:#0ea5e9" @click.native="home">
            Back to Home
        </jet-button>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import JetButton from '../Jetstream/Button';

export default defineComponent({
    components: {
        JetButton,
    },
    props: {
        stripeKey: {
            type: String,
            required: true,
        },
        sessionId: {
            type: String,
            required: true,
        },
    },
    computed: {
        title() {
            return 'Manage Subscription';
        },
    },
    methods: {
        checkout() {
            window
                .Stripe(this.stripeKey)
                .redirectToCheckout({
                    sessionId: this.sessionId,
                })
        },
        home() {
            window.location = '/'
        },
    },
});

</script>

<style scoped>
</style>
