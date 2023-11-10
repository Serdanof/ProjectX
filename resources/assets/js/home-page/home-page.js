$(document).on('click', '.languageSelection', function (e){
    e.preventDefault();
    let languageName = $(this).data('prefix-value');
    $.ajax({
        type: 'POST',
        url: '/change-language',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { languageName: languageName },
        success: function () {
            location.reload();
        },
    });
});
