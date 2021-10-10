const lodash = require("lodash");
const {TwoStageModel} = require("../../resources/js/Business/TwoStageModel");

test('Terminal value for 10 years model', () => {
    const model = new TwoStageModel(
        34.15,
        60,
        10,
        false,
        12,
        5,
        8,
        5
    )

    expect(lodash.round(model.terminalValue,2 )).toBe(4912.78);
});

test('Find value in 7 years', () => {
    const model = new TwoStageModel(
        34.15,
        60,
        10,
        false,
        12,
        5,
        8,
        5
    )

    expect(lodash.round(model.projectedValue(7),2 )).toBe(70.20);
});
