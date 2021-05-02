$(document).ready(function (){
    $('#addTaskForm').submit(function (e){
        e.preventDefault()
        $('.is-invalid').removeClass('is-invalid')
        const form = $(this)

        $.ajax({
            url:form.attr('action'),
            type:form.attr('method'),
            data: form.serialize(),
            success:function (response){
                alert(response.message)
                window.location.href = ''
            },
            error:function (response){
                const status = response.status
                if (status === 401) {
                    const errors = response.responseJSON.errors
                    for (const key in errors){
                        $(`#${key}`).addClass('is-invalid').next().text(errors[key])
                    }
                }else {
                    alert('Что-то пошло не так')
                }
            }
        })
    })
})

