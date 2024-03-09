function addToCart()
{
    let quantity = $('input[name="quantity"]').val();
    let size = $('input[name="size"]:checked').val();
    let productId = $('#product_id').val();
    console.log(quantity, size, productId);

    $.ajax({
        url: '/add-to-cart',
        method: 'POST',
        data: {
            quantity: quantity,
            size: size,
            productId: productId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    })


}
