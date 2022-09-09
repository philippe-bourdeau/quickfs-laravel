<template>
    <app-layout title="Dashboard">
        <template #header>
            <ticker-form :summary="summary"/>
        </template>

        <div class="bg-red-100 text-center py-4 lg:px-4" v-if="errors.ticker">
            <jet-validation-errors></jet-validation-errors>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <valuation-table :summary="summary"/>
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
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

export default defineComponent({
        components: {
            AppLayout,
            ValuationTable,
            TickerForm,
            JetValidationErrors
        },
        props: {
            summary : Object,
            errors: Object
        }
    })
</script>
