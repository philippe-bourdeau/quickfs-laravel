const calculations = require('../../resources/js/Algorithms/calculations.js');
const lodash = require ('lodash')

test('compound 1 year @ 5%', () => {
    expect(lodash.round(calculations.compound(2.52,1, 5),2 )).toBe(2.65);
});

test('compound 5 years @ 12%', () => {
    expect(lodash.round(calculations.compound(34.15,5, 12),2 )).toBe(60.18);
});

test('compound 6 years @ 8%', () => {
    expect(lodash.round(calculations.compound(16.18,6, 8),2 )).toBe(25.68);
});

test('2 stage model @ 12% & 8%', () => {
    const data = {
        value: 34.15,
        first_stage: {
            iterations: 5,
            rate: 12
        },
        second_stage: {
            iterations: 5,
            rate:8
        }
    }

    expect(
        lodash.round(
            calculations.two_stage_model_compounding(
                data
            ), 2)
    ).toBe(88.43);
});
