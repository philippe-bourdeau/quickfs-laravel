const {compound} = require("./tools")

class TwoStageModel {
    constructor(
        start_value,
        terminal_multiple,
        discount_rate,
        include_present_value,
        rate1,
        iterations1,
        rate2,
        iterations2
    ) {
        this.start_value = start_value
        this.terminal_multiple = terminal_multiple
        this.include_present_value = include_present_value
        this.discount_rate = discount_rate
        this.rate1 = rate1
        this.rate2 = rate2
        this.iterations1 = iterations1
        this.iterations2 = iterations2
    }

    /**
     * In a typical 10 years 2 stage model, this equals to the ninth years in the future
     * @returns {*}
     */
    get terminalValue() {
        const first_stage = compound(
            this.start_value,
            this.iterations1,
            this.rate1
        )

        return compound(
            first_stage,
            this.iterations2 - 1,
            this.rate2
        ) * this.terminal_multiple
    }

    /**
     *
     * @param iteration
     * @returns {number|*}
     */
    presentValue(iteration) {
        if (!this.include_present_value) {
            return 0
        }

        let projected = this.projectedValue(iteration)

        return compound(projected, - iteration, this.discount_rate)
    }

    /**
     * Find projected value in n iterations (years)
     *
     * @param iterations
     */
    projectedValue(iterations) {
        if (iterations > 10) {
            throw new Error('Cannot go further in the future than 10 years')
        }

        if (iterations < this.iterations1) {
            return compound(this.start_value, iterations, this.rate1)
        }

        const first_stage = compound(
            this.start_value,
            this.iterations1,
            this.rate1
        )

        return compound(
            first_stage,
            iterations - this.iterations1,
            this.rate2
        )
    }

    /**
     * @returns {number}
     */
    presentValueTerminal () {
        return this.terminalValue * (1 + this.discount_rate/100) ** -10
    }

    /**
     * Yields the number we are looking for
     *
     * Either per/share or market cap
     * @returns {number}
     */
    intrinsicValue() {
        if (!this.include_present_value) {
            return this.presentValueTerminal()
        }

        console.log('here')

        let sum = this.presentValueTerminal()
        for (let i = 1; i <= 10; i++) {
            sum += this.presentValue(i)
        }

        return sum
    }
}

module.exports.TwoStageModel = TwoStageModel
