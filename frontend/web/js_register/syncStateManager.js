/**
 * Синхронизация значений полей между двумя таблицами
 */
 $(document).ready(function() {
    window.__formState = {};

    /**
     * 
     * @param {Event} event 
     * @returns boolean
     */
    function isCheckbox(type) {
        return type === 'checkbox'
    }

    $.each($('.listeners'), function (index, val) {
        $(this).change(function (event) {
            event.preventDefault();
            const { target: { name, type }} = event
            const value = isCheckbox(type)
                ? $(this).is(":checked")
                : $(this).val();
            const { __formState } = window
            const nextState = {
                ...__formState,
                [name]: value
            }
            window.__formState = nextState
            for (const name in nextState) {
                $(`input[name='${name}']`).each(function() {
                    if (typeof nextState[name] === 'boolean') $(this).prop("checked", nextState[name])
                    $(this).val(nextState[name]);
                });
            }
        });
    });
});
