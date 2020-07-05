images=$('.image')
images.on("click",function () {
    let id=$(this).attr("id");
    $.ajax({
        url:"src/templates/product/index.html.twig",
        method: "GET",
        data: {"id":id},
        success: function (data) {
            $('amp-lightbox').text(data)

        }
    })
})