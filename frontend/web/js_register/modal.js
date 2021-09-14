$(document).on('click', '.modal-link', function (e) {
    const $this = $(this);
    e.preventDefault();
    e.stopPropagation();
    const isMain = !!$this.data('maindomain')

    // необходимо обнулить результат предыдущей работы
    $('#modal .modal-body').html('');
    let ajaxDataRequest = {}
    if (isMain) {
        ajaxDataRequest = {
            type: 'GET',
            url: 'get-rules',
            dataType: 'html'
        }
    } else {
        ajaxDataRequest = {
            type: 'GET',
            url: 'get-agreement',
            dataType: 'json'
        }
    }

    function handleSuccessResponse(data) {
        if(data.error === 0){
            $('#modal .modal-body').html(
                data.html.replace(
                    '###FIO###', ''
                )
            );
        } else if (isMain) {
            const divWarpper = $( "<div class='modal-rules-warpper'></div>" )
            const divData = $(data).filter('.windowed-text');
            /**
             * Подмена домена на источник
             */
            const aData = $( divData ).find( "a" );
            const linkUrl = new URL($(aData).attr("href"), 'https://4slovo.kz/').href;
            aData.attr('href', linkUrl)

            $('#modal .modal-body').html(divWarpper.append(divData));
        } else {
            $('#modal .modal-body').html('Документ не найден.');
        }
    }

    function handleFailResponse(data) {
        $('#modal .modal-body').html('Документ не найден.');
    }

    const requestParams = Object.assign({}, ajaxDataRequest, {
        success: handleSuccessResponse,
        error: handleFailResponse
    })

    $.ajax(requestParams);
    $('#modal').modal();
});