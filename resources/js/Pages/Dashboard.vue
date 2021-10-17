\<template>
    <app-layout title="Dashboard">
        <template #header>
            <ticker-form :summary="summary"/>
        </template>

        <div class="bg-red-900 text-center py-4 lg:px-4" v-if="errors.ticker">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                <span class="font-semibold mr-2 text-left flex-auto">{{ errors.ticker }}</span>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <valuation-table :sumary="summary"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ValuationTable from '@/Components/ValuationTable.vue'
import TickerForm from "@/Components/TickerForm.vue"

export default defineComponent({
        components: {
            AppLayout,
            ValuationTable,
            TickerForm
        },
        props: {
            summary : Object,
            errors: Object
        }
    })
</script>
