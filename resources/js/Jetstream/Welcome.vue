<template>
    <div>
        <valuation-table/>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import ValuationTable from '@/Components/ValuationTable.vue'

    export default defineComponent({
        components: {
            ValuationTable
        },
    })
</script>
