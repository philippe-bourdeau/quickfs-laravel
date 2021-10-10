function compound(value, iterations, rate) {
    return value * (1 + rate / 100) ** iterations
}

exports.compound = compound
