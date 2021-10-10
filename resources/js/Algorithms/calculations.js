function compound(value, iterations, rate) {
    return value * (1 + rate / 100) ** iterations
}

/**
 * Could be converted to n stages in the future
 * but would rather be explicit about stage 1 and stage 2 for now
 * @param data
 * @returns {*}
 */
function two_stage_model(data) {
    const first_stage = compound(
        data.value,
        data.first_stage.iterations,
        data.first_stage.rate
    )

    return first_stage + compound(
        first_stage,
        data.second_stage.iterations,
        data.second_stage.rate
    )
}

exports.compound = compound;

