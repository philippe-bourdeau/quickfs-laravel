const calculations = require('../../resources/js/Algorithms/calculations.js');
const lodash = require ('lodash')

test('compound 1 year @ 5%', () => {
    expect(lodash.round(calculations.compound(2.52,1, 5),2 )).toBe(2.65);
});

test('compound 6 years @ 8%', () => {
    expect(lodash.round(calculations.compound(16.18,6, 8),2 )).toBe(25.68);
});
