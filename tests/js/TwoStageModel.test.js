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

test('Present value for year 9', () => {
    const model = new TwoStageModel(
        0.64,
        20,
        15,
        true,
        15,
        5,
        10,
        4
    )

    expect(lodash.round(model.presentValue(9),2 )).toBe(0.54);
});
