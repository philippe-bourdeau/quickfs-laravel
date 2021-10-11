<template>
    <table class="table-auto">
        <thead>
        <tr>
            <th>Starting number</th>
            <th v-for="year in 10"
                :key="year"
                class="px-4 py-2"
            >
                Year {{ year }}
            </th>
            <th class="px-4 py-2">Terminal value</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border px-4 py-2">
                <input
                    class="input"
                    type="text"
                    v-model="userInput.start_value"
                >
            </td>
            <td v-for="year in 10"
                :key="year"
                class="border px-4 py-2"
            >
                {{ formatFloat(model.projectedValue(year)) }}
            </td>
            <td class="border px-4 py-2">
                {{formatFloat(model.terminalValue) }}
            </td>
        </tr>
        <tr>
            <td class="border px-4 py-2">Present Value @ {{ userInput.discount_rate }} %</td>
            <td v-for="year in 10"
                :key="year"
                class="border px-4 py-2"
            >
                {{ formatFloat(model.presentValue(year)) }}
            </td>
            <td class="border px-4 py-2">{{formatFloat(model.presentValueTerminal)}}</td>
        </tr>
        <tr><b>&nbsp;&nbsp;INTRINSIC VALUE : {{formatFloat(model.intrinsicValue())}}</b></tr>
        </tbody>
    </table>
</template>

<script>

import { defineComponent } from 'vue'
const {TwoStageModel} = require('../../js/Business/TwoStageModel')
import {round} from 'lodash'

export default defineComponent({
    data() {
        let userInput = {
            start_value: 0,
            terminal_multiple: 15,
            discount_rate: 10,
            include_present_value: false,
            rate1: 12,
            iterations1: 5,
            rate2: 8,
            iterations2: 5
        }

        let model = new TwoStageModel(
            0,
            15,
            10,
            false,
            12,
            5,
            8,
            5
        );

        return {
            userInput,
            model
        }
    },
    watch: {
        userInput: {
            handler(after, before){
                this.model = new TwoStageModel(
                    after.start_value,
                    after.terminal_multiple,
                    after.discount_rate,
                    after.include_present_value,
                    after.rate1,
                    after.iterations1,
                    after.rate2,
                    after.iterations2
                )
            },
            deep: true
        }
    },
    methods: {
        formatFloat(value) {
            return round(value,2)
        }
    }
})
</script>
