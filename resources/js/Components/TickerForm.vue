<template>
    <form
        class="w-full max-w-sm"
        @submit.prevent="submit"
    >
        <div class="flex items-center border-b border-teal-500 py-2">
            <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                   type="text"
                   placeholder="Ticker & Country ex. BCE.CA, T.US, T.CA"
                   aria-label="ticker_and_country"
                   v-model="form.ticker"
            >
            <button type="submit" :disabled="form.processing">Search</button>
        </div>
    </form>
</template>

<script>
export default {
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
