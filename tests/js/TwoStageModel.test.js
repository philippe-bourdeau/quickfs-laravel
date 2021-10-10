const lodash = require("lodash");
const {TwoStageModel} = require("../../resources/js/Business/TwoStageModel");

test('Terminal value for 10 years model', () => {
    const model = new TwoStageModel(
        34.15,
        60,
        12,
        5,
        8,
        5
    )

    expect(lodash.round(model.terminalValue,2 )).toBe(4912.78);
});
