$(document).ready(function () {
    $("#contact-form").submit(function (e) {
        e.preventDefault(); // Предотвращаем отправку формы по умолчанию
        
        $.ajax({
            type: "POST",
            url: "sender.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                $(".status").text(response.message);
                if (response.status === "success") {
                    // Очищаем поля ввода
                    $("#contact-form")[0].reset();
                }
            }
        });
    });
});
