<template>
    <div class="grid grid-cols-12">
        <div class="col-span-2">

            <div class="p-6 sm:px-6 bg-white py-2 mb-6">
                <div class="w-full max-w-xs">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="stage1">
                                Stage 1 Growth rate (year 1-5)
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="stage1"
                                   type="text"
                                   placeholder="Stage 1 growth"
                                   v-model="userInput.rate1"
                            >
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="stage2">
                                Stage 2 Growth rate (year 6-10)
                            </label>
                            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                   id="stage2"
                                   type="text"
                                   placeholder="Stage 2 growth"
                                   v-model="userInput.rate2"
                            >
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="discount_rate">
                                Discount rate
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="discount_rate"
                                   type="text"
                                   placeholder="Discount rate"
                                   v-model="userInput.discount_rate"
                            >
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="multiple">
                                Terminal multiple
                            </label>
                            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                   id="multiple"
                                   type="text"
                                   placeholder="Multiple"
                                   v-model="userInput.terminal_multiple"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="block text-gray-500 font-bold">
                                <input
                                    class="mr-2 leading-tight"
                                    type="checkbox"
                                    v-model="userInput.include_present_value"
                                >
                                <span class="text-sm">
                            Include present value
                        </span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-span-10">
                    <table v-if="summary.ticker">
                        <thead>
                        <tr>
                            <th>Year</th>
                            <th>Revenue</th>
                            <th>Earnings</th>
                            <th>Earnings/share</th>
                            <th>Dividends</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in summary.series" key="index">
                            <td class="border px-4 py-2">{{ index }}</td>
                            <td class="border px-4 py-2">{{ item.revenue }}</td>
                            <td class="border px-4 py-2">{{ item.earnings }}</td>
                            <td class="border px-4 py-2">{{ item.earnings_per_share }}</td>
                            <td class="border px-4 py-2">{{ item.dividends }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
    </div>

    <div class="p-6 sm:px-6 bg-white py-2 mb-6">
        <div class="w-full bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <table>
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
        </div>
    </div>
</template>

<script>

import {defineComponent} from 'vue'
import {round} from 'lodash'

const {TwoStageModel} = require('../../js/Business/TwoStageModel')

export default defineComponent({
    props:['summary'],
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
