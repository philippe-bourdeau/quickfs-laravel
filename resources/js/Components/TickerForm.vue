<template>
    <div class="grid grid-cols-4">
        <div class="flex items-center">
            <h2
                v-if="summary && summary.name">
                {{ summary.ticker }} - {{ summary.name }}
            </h2>
        </div>
        <div class="flex items-center">
            <h2
                v-if="summary && summary.currency">
                {{ summary.price }} {{ summary.currency }}
            </h2>
        </div>
        <div class="flex items-center">
            <h2
                v-if="summary && summary.market_cap">
                Market cap. : {{ `${new Intl.NumberFormat('en-US').format(summary.market_cap)} ${summary.currency} Mil` }}
            </h2>
            <h2 v-else>Pick a market and ticker to get your summary !</h2>
        </div>
        <div>
            <form
                @submit.prevent="search"
            >
                <div class="flex items-center border-b border-teal-500 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                           type="text"
                           placeholder="ex. BCE:CA, AMZN:US"
                           aria-label="ticker_and_country"
                           v-model="ticker"
                    >
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import {mixin} from "./formatsInMillionsMixin";

export default {
    data() {
        return {
            'ticker' : ''
        }
    },
    mixins :  [mixin],
    props: ['summary'],
    methods : {
        search () {
            return Inertia.visit(
                '/dashboard',
                {
                    data : {
                        ticker : this.ticker
                    },
                    only:[
                        'summary',
                        'errors'
                    ]
                })
        }
    }
}

</script>
