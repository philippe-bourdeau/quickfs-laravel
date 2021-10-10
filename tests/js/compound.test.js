const helper = require('../../resources/js/Business/tools.js')
const lodash = require ('lodash')

test('compound 1 year @ 5%', () => {
    expect(lodash.round(helper.compound(2.52,1, 5),2 )).toBe(2.65);
});

test('compound 5 years @ 12%', () => {
    expect(lodash.round(helper.compound(34.15,5, 12),2 )).toBe(60.18);
});

test('compound 6 years @ 8%', () => {
    expect(lodash.round(helper.compound(16.18,6, 8),2 )).toBe(25.68);
});

test('2 stage model @ 12% & 8%', () => {
    const first_stage = helper.compound(
        34.15,
        5,
        12
    )

    expect(lodash.round(first_stage, 2)).toBe(60.18);

    const second_stage = helper.compound(
        first_stage,
        5 - 1,
        8
    )

    expect(lodash.round(second_stage, 2)).toBe(81.88);
});

