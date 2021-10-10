const {compound} = require("./tools")

class TwoStageModel {
    constructor(
        start_value,
        terminal_multiple,
        rate1,
        iterations1,
        rate2,
        iterations2
    ) {
        this.start_value = start_value
        this.rate1 = rate1
        this.rate2 = rate2
        this.iterations1 = iterations1
        this.iterations2 = iterations2
        this.terminal_multiple = terminal_multiple
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
}

module.exports.TwoStageModel = TwoStageModel
