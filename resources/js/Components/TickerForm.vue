<template>
    <div class="grid grid-cols-4">
        <div class="flex items-center">
            <h2
                v-if="financials && financials.name">
                {{ financials.ticker }} - {{ financials.name }}
            </h2>
        </div>
        <div class="flex items-center">
            <h2
                v-if="financials && financials.currency">
                {{ financials.price }} {{ financials.currency }}
            </h2>
        </div>
        <div class="flex items-center">
            <h2
                v-if="financials && financials.market_cap">
                Market cap. : {{ financials.market_cap }} {{ financials.currency }}
            </h2>
        </div>
        <div>
            <form
                @submit.prevent="submit"
            >
                <div class="flex items-center border-b border-teal-500 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                           type="text"
                           placeholder="ex. BCE.CA, AMZN.US"
                           aria-label="ticker_and_country"
                           v-model="form.ticker"
                    >
                    <button type="submit" :disabled="form.processing">Search</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    inject: ['financials'],
    data() {
        return {
            form: {
                ticker: ''
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.get('/ticker', this.form)
        },
    },
}

</script>
